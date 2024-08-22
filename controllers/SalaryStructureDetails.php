<?php
require_once "../db/connect.php";

class SalaryStructure extends DB
{
    private $table = "salary_structure_details";

    public function __construct()
    {
        parent::__construct();
    }

    public function getCounts()
    {
        $result = $this->conn->query("SELECT COUNT(*) AS total FROM $this->table");
        return $result->fetch_assoc()['total'];
    }

    public function createSalaryStructure($salary_structure_grades_id, $annual_basic, $annual_gross, $annual_net, $monthly_basic, $monthly_gross, $monthly_net)
    {
        $stmt = $this->conn->prepare("INSERT INTO $this->table (salary_structure_grades_id, annual_basic, annual_gross, annual_net, monthly_basic, monthly_gross, monthly_net) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssss", $salary_structure_grades_id, $annual_basic, $annual_gross, $annual_net, $monthly_basic, $monthly_gross, $monthly_net);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateSalaryStructure($id, $salary_structure_grades_id, $annual_basic, $annual_gross, $annual_net, $monthly_basic, $monthly_gross, $monthly_net)
    {
        $stmt = $this->conn->prepare("UPDATE $this->table SET salary_structure_grades_id = ?, annual_basic = ?, annual_gross = ?, annual_net = ?, monthly_basic = ?, monthly_gross = ?, monthly_net = ? WHERE id = ?");
        $stmt->bind_param("issssssi", $salary_structure_grades_id, $annual_basic, $annual_gross, $annual_net, $monthly_basic, $monthly_gross, $monthly_net, $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteSalaryStructure($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getSalaryStructures()
    {
        $result = $this->conn->query("SELECT * FROM $this->table");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getSalaryStructuresPaginated($limit, $offset)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table LIMIT ? OFFSET ?");
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getSalaryStructureById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
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
        $stmt->bind_param("isi", $salary_structure_id, $grade_level, $step);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row ? $row['id'] : null;
    }    
}
