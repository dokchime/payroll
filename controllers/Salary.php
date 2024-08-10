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
