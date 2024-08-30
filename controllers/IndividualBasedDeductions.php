<?php
require_once "../db/connect.php";

class IndividualBasedDeductions extends DB
{
    private $table = "individual_based_deductions";

    public function __construct()
    {
        parent::__construct();
    }

    public function exists($year, $month, $staff_id, $description)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE `year` = ? AND `month` = ? AND `staff_id` = ? AND `description` LIKE ?");
        $stmt->bind_param("ssss", $year, $month,  $staff_id, $description);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    public function getCounts()
    {
        $result = $this->conn->query("SELECT COUNT(*) AS total FROM $this->table");
        return $result->fetch_assoc()['total'];
    }

    public function createDeduction($year, $month, $staff_id, $description, $amount, $is_active)
    {
        if ($this->exists($year, $month, $staff_id, $description)) {
            return ['success' => false, 'message' => 'Deduction already exists for this staff member.'];
        }

        $stmt = $this->conn->prepare("INSERT INTO $this->table (`year`, `month`, `staff_id`, `description`, `amount`, `is_active`) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssdi", $year, $month, $staff_id, $description, $amount, $is_active);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateDeduction($id, $year, $month, $staff_id, $description, $amount, $is_active = 1)
    {
        $stmt = $this->conn->prepare("UPDATE $this->table SET `year` = ?, `month` = ?, staff_id = ?, description = ?, amount = ?, is_active = ? WHERE id = ?");
        $stmt->bind_param("ssssdii", $year, $month, $staff_id, $description, $amount, $is_active, $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteDeduction($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id = ?");
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
        $stmt = $this->conn->prepare("SELECT * FROM $this->table LIMIT ? OFFSET ?");
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getDeductionById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }
}
