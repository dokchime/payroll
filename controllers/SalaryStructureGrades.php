<?php
require_once "../db/connect.php";

class SalaryStructureGrade extends DB
{
    private $table = "salary_structure_grades";

    public function __construct()
    {
        parent::__construct();
    }

    public function exists($salary_structure_id, $grade_level, $step)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE salary_structure_id = ? AND grade_level = ? AND step = ?");
        $stmt->bind_param("isi", $salary_structure_id, $grade_level, $step);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    public function getCounts()
    {
        $result = $this->conn->query("SELECT COUNT(*) AS total FROM $this->table");
        return $result->fetch_assoc()['total'];
    }

    public function createGrade($struct_name, $grade_level, $step)
    {
        $salary_structure_id = $this->getSalaryStructureIdByName($struct_name);
        if (!$salary_structure_id) {
            return ['success' => false, 'message' => 'Invalid salary structure name'];
        }

        if ($this->exists($salary_structure_id, $grade_level, $step)) {
            return ['success' => false, 'message' => 'Grade already exists'];
        }

        $stmt = $this->conn->prepare("INSERT INTO $this->table (salary_structure_id, grade_level, step) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $salary_structure_id, $grade_level, $step);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateGrade($id, $struct_name, $grade_level, $step)
    {
        $salary_structure_id = $this->getSalaryStructureIdByName($struct_name);
        if (!$salary_structure_id) {
            return ['success' => false, 'message' => 'Invalid salary structure name'];
        }

        $stmt = $this->conn->prepare("UPDATE $this->table SET salary_structure_id = ?, grade_level = ?, step = ? WHERE id = ?");
        $stmt->bind_param("isii", $salary_structure_id, $grade_level, $step, $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteGrade($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getGrades()
    {
        $result = $this->conn->query("SELECT * FROM $this->table");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getGradesPaginated($limit, $offset)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table LIMIT ? OFFSET ?");
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getGradeById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    private function getSalaryStructureIdByName($struct_name)
    {
        $stmt = $this->conn->prepare("SELECT id FROM salary_structure WHERE struct_name = ?");
        $stmt->bind_param("s", $struct_name);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        return $result['id'] ?? null;
    }

    /*public function getIdByName($struct_name) {
        $query = "SELECT id FROM salary_structure WHERE struct_name = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $struct_name);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row ? $row['id'] : null;
    }*/

    public function getSalaryStructById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM salary_structure WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        return $result->fetch_assoc();
    }
    
    public function getAllSalaryStructures()
    {
        $result = $this->conn->query("SELECT id, struct_name FROM salary_structure");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
}
