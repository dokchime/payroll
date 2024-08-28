<?php
require_once "../db/connect.php";

class GradeBasedDeductions extends DB
{
    private $table = "grade_based_deductions";

    public function __construct()
    {
        parent::__construct();
    }

    public function exists($year, $month, $salary_structure_grades_id, $description)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE `year` = ? AND `month` = ? AND `salary_structure_grades_id` = ? AND `description` = ?");
        $stmt->bind_param("ssis", $year, $month,  $salary_structure_grades_id, $description);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    public function getCounts()
    {
        $result = $this->conn->query("SELECT COUNT(*) AS total FROM $this->table");
        return $result->fetch_assoc()['total'];
    }

    public function createDeduction($year, $month, $salary_structure_grades_id, $description, $amount, $is_active = 1)
    {
        if ($this->exists($year, $month, $salary_structure_grades_id, $description)) {
            return ['success' => false, 'message' => 'Deduction already exists'];
        }
        
        $stmt = $this->conn->prepare("INSERT INTO $this->table (`year`, `month`, `salary_structure_grades_id`, `description`, `amount`, `is_active`) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssisdi", $year, $month, $salary_structure_grades_id, $description, $amount, $is_active);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateDeduction($id, $year, $month, $salary_structure_grades_id, $description, $amount, $is_active = 1)
    {
        $stmt = $this->conn->prepare("UPDATE $this->table SET `year` = ?, `month` = ?, `salary_structure_grades_id` = ?, `description` = ?, `amount` = ?, `is_active` = ? WHERE `id` = ?");
        $stmt->bind_param("ssisidi", $year, $month, $salary_structure_grades_id, $description, $amount, $is_active, $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteDeduction($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE `id` = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getDeductions()
    {
        $result = $this->conn->query("SELECT * FROM $this->table");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getDeductionsPaginated($limit, $offset)
    {
        $stmt = $this->conn->prepare("SELECT gbd.id AS gbd_id, gbd.description AS gbd_description, ssg.id AS ssg_id, CONCAT(ss.struct_name, ' ', ssg.grade_level, '/', ssg.step) AS ss_struct_name, gbd.*, ssg.*, ss.* FROM $this->table gbd INNER JOIN salary_structure_grades ssg ON gbd.salary_structure_grades_id=ssg.id INNER JOIN salary_structure ss ON ssg.salary_structure_id=ss.id ORDER BY ss_struct_name LIMIT ? OFFSET ?");
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getDeductionById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE `id` = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }
    
    public function getAllSalaryStructureDetails()
    {
        $result = $this->conn->query("SELECT ssg.id AS ssg_id, CONCAT(ss.struct_name, ' ', ssg.grade_level, '/', ssg.step) AS ss_struct_name FROM salary_structure_grades ssg INNER JOIN salary_structure ss ON ssg.salary_structure_id=ss.id ORDER BY ss_struct_name");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getStructureIdByName($struct_name) {
        $query = "SELECT id FROM salary_structure WHERE struct_name = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $struct_name);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row ? $row['id'] : null;
    }

    public function getStructureGradesIdByDetails($salary_structure_id, $grade_level, $step) {
        $query = "SELECT id FROM salary_structure_grades WHERE salary_structure_id = ? AND grade_level = ? AND step = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iii", $salary_structure_id, $grade_level, $step);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row ? $row['id'] : null;
    }
}
?>
