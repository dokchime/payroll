<?php
require_once "../db/connect.php";

class MonthlySalarySchedule extends DB
{
    private $table = "monthly_salary_schedule";

    public function __construct()
    {
        parent::__construct();
    }

    public function recordExists($year, $month, $staff_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE `year` = ? AND `month` = ? AND `staff_id` = ?");
        $stmt->bind_param("ssi", $year, $month, $staff_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    public function getCounts()
    {
        $result = $this->conn->query("SELECT COUNT(*) AS total FROM $this->table");
        return $result->fetch_assoc()['total'];
    }

    public function createSalarySchedule($year, $month, $salary_structure_grades_id, $staff_id, $due_date, $is_active)
    {
        if ($this->recordExists($year, $month, $staff_id)) {
            return ['success' => false, 'message' => 'Record already exists for the given year, month, and staff ID'];
        }

        // Calculate all relevant financials
        $grade_based_additions = $this->getGradeBasedAdditions($salary_structure_grades_id, $staff_id);
        $grade_based_deductions = $this->getGradeBasedDeductions($salary_structure_grades_id, $staff_id);
        $individual_based_additions = $this->getIndividualBasedAdditions($staff_id);
        $individual_based_deductions = $this->getIndividualBasedDeductions($staff_id);
        $net_take_home_pay = $this->calculateNetTakeHomePay($salary_structure_grades_id, $staff_id, $grade_based_additions, $grade_based_deductions, $individual_based_additions, $individual_based_deductions);

        $stmt = $this->conn->prepare("INSERT INTO $this->table (`year`, `month`, `salary_structure_grades_id`, `staff_id`, `grade_based_additions`, `grade_based_deductions`, `individual_based_additions`, `individual_based_deductions`, `net_take_home_pay`, `due_date`, `is_active`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiisssssi", $year, $month, $salary_structure_grades_id, $staff_id, $grade_based_additions, $grade_based_deductions, $individual_based_additions, $individual_based_deductions, $net_take_home_pay, $due_date, $is_active);

        return $stmt->execute();
    }

    public function updateSalarySchedule($id, $year, $month, $salary_structure_grades_id, $staff_id, $due_date, $is_active)
    {
        // Recalculate all relevant financials on update
        $grade_based_additions = $this->getGradeBasedAdditions($salary_structure_grades_id, $staff_id);
        $grade_based_deductions = $this->getGradeBasedDeductions($salary_structure_grades_id, $staff_id);
        $individual_based_additions = $this->getIndividualBasedAdditions($staff_id);
        $individual_based_deductions = $this->getIndividualBasedDeductions($staff_id);
        $net_take_home_pay = $this->calculateNetTakeHomePay($salary_structure_grades_id, $staff_id, $grade_based_additions, $grade_based_deductions, $individual_based_additions, $individual_based_deductions);

        $stmt = $this->conn->prepare("UPDATE $this->table SET year = ?, month = ?, salary_structure_grades_id = ?, staff_id = ?, grade_based_additions = ?, grade_based_deductions = ?, individual_based_additions = ?, individual_based_deductions = ?, net_take_home_pay = ?, due_date = ?, is_active = ? WHERE id = ?");
        $stmt->bind_param("ssiiisssssii", $year, $month, $salary_structure_grades_id, $staff_id, $grade_based_additions, $grade_based_deductions, $individual_based_additions, $individual_based_deductions, $net_take_home_pay, $due_date, $is_active, $id);

        return $stmt->execute();
    }

    public function deleteSalarySchedule($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    public function getSalarySchedules()
    {
        $result = $this->conn->query("SELECT * FROM $this->table");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getSalarySchedulesPaginated($limit, $offset)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table LIMIT ? OFFSET ?");
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getSalaryScheduleById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    private function getGradeBasedAdditions($salary_structure_grades_id, $staff_id)
    {
        $stmt = $this->conn->prepare("SELECT SUM(amount) as total_additions FROM grade_based_additions WHERE salary_structure_grades_id = ? AND is_active = 1");
        $stmt->bind_param("i", $salary_structure_grades_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        return $result['total_additions'] ?? 0;
    }

    private function getGradeBasedDeductions($salary_structure_grades_id, $staff_id)
    {
        $stmt = $this->conn->prepare("SELECT SUM(amount) as total_deductions FROM grade_based_deductions WHERE salary_structure_grades_id = ? AND is_active = 1");
        $stmt->bind_param("i", $salary_structure_grades_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        return $result['total_deductions'] ?? 0;
    }

    private function getIndividualBasedAdditions($staff_id)
    {
        $stmt = $this->conn->prepare("SELECT SUM(amount) as total_additions FROM individual_based_additions WHERE staff_id = ? AND is_active = 1");
        $stmt->bind_param("i", $staff_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        return $result['total_additions'] ?? 0;
    }

    private function getIndividualBasedDeductions($staff_id)
    {
        $stmt = $this->conn->prepare("SELECT SUM(amount) as total_deductions FROM individual_based_deductions WHERE staff_id = ? AND is_active = 1");
        $stmt->bind_param("i", $staff_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        return $result['total_deductions'] ?? 0;
    }

    private function calculateNetTakeHomePay($salary_structure_grades_id, $staff_id, $grade_based_additions, $grade_based_deductions, $individual_based_additions, $individual_based_deductions)
    {
        $stmt = $this->conn->prepare("SELECT monthly_net FROM salary_structure_details WHERE salary_structure_grades_id = ? AND is_active = 1 LIMIT 1");
        $stmt->bind_param("i", $salary_structure_grades_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        $monthly_net = $result['monthly_net'] ?? 0;

        // Calculate net take-home pay
        return $monthly_net + $grade_based_additions + $individual_based_additions - $grade_based_deductions - $individual_based_deductions;
    }
}
