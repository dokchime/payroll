<?php
require_once "../db/connect.php";

class SalaryStructureDetails extends DB
{
    private $table = "salary_structure_details";

    public function __construct()
    {
        parent::__construct();
    }

    public function exists($salary_structure_grades_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE salary_structure_grades_id = ?");
        $stmt->bind_param("i", $salary_structure_grades_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    public function getCounts()
    {
        $result = $this->conn->query("SELECT COUNT(*) AS total FROM $this->table");
        return $result->fetch_assoc()['total'];
    }

    public function createSalaryStructure($salary_structure_grades_id, $annual_basic, $annual_gross, $monthly_basic, $monthly_gross)
    {
        if (!$salary_structure_grades_id) {
            return ['success' => false, 'message' => 'Invalid salary structure name, grade/step'];
        }

        if ($this->exists($salary_structure_grades_id)) {
            return ['success' => false, 'message' => 'Grade already exists'];
        }

        $stmt = $this->conn->prepare("INSERT INTO $this->table (salary_structure_grades_id, annual_basic, annual_gross, monthly_basic, monthly_gross) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("idddd", $salary_structure_grades_id, $annual_basic, $annual_gross, $monthly_basic, $monthly_gross);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateSalaryStructure($id, $struct_details, $annual_basic, $annual_gross, $monthly_basic, $monthly_gross)
    {
        $stmt = $this->conn->prepare("UPDATE $this->table SET salary_structure_grades_id = ?, annual_basic = ?, annual_gross = ?, monthly_basic = ?, monthly_gross = ? WHERE id = ?");
        $stmt->bind_param("iddddi", $struct_details, $annual_basic, $annual_gross, $monthly_basic, $monthly_gross, $id);

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
        $stmt = $this->conn->prepare("SELECT ssd.id AS ssd_id, ssg.id AS ssg_id, CONCAT(ss.struct_name, ' ', ssg.grade_level, '/', ssg.step) AS ss_struct_name, ssd.*, ssg.*, ss.* FROM $this->table ssd INNER JOIN salary_structure_grades ssg ON ssd.salary_structure_grades_id=ssg.id INNER JOIN salary_structure ss ON ssg.salary_structure_id=ss.id ORDER BY ss_struct_name LIMIT ? OFFSET ?");
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
    
    public function getAllSalaryStructures()
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
