<?php
require_once '../db/connect.php';

class Salary extends DB
{

    private $salaryStructureTb = "salary_structure";
    private $table = "salary_data";
    private $staffTable = "staff_info";

    public function __construct()
    {
        parent::__construct();
    }

    public function createSalary($psn,) {}


    public function getStaffSalary($psn)
    {

        // $query = "select from $this->table sd inner join $this->$staffTable si on sd.psn == si.psn";


        return true;
    }
    
    public function getStructureCounts()
    {
        $result = $this->conn->query("SELECT COUNT(*) AS total FROM $this->salaryStructureTb");
        return $result->fetch_assoc()['total'];
    }

    public function getSalaryStructPaginated($limit, $offset)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->salaryStructureTb LIMIT ? OFFSET ?");
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function createSalaryStructure($name, $description, $highest_grad_level, $min_step)
    {
        $stmt = $this->conn->prepare("INSERT INTO $this->salaryStructureTb (`name`, `description`, `highest_grad_level`, `min_step`) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssii", $name,                     $description, $highest_grad_level, $min_step);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
