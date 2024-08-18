<?php
require_once '../db/connect.php';

class SalaryStruct extends DB
{

    private $salaryStructureTb = "salary_structure";

    public function __construct()
    {
        parent::__construct();
    }

    public function createSalary($psn,) {}

    
    public function getStructureCounts()
    {
        $result = $this->conn->query("SELECT COUNT(*) AS total FROM $this->salaryStructureTb");
        return $result->fetch_assoc()['total'];
    }

    
    public function getSalaryStructById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->salaryStructureTb WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function getSalaryStructPaginated($limit, $offset)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->salaryStructureTb LIMIT ? OFFSET ?");
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function createSalaryStructure($name, $description)
    {
        $stmt = $this->conn->prepare("INSERT INTO $this->salaryStructureTb (`struct_name`, `description`) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $description);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
