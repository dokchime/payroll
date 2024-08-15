<?php
require_once '../db/connect.php';

class Staff extends DB
{
    private $table = "staff_personal_info ";
    private $table_emp_info = "staff_emp_info ";

    public function __construct()
    {
        parent::__construct();
    }

    // Check if bank exists
    public function staffExists($staff_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE staff_id = ? ");
        $stmt->bind_param("s", $staff_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    // Create a new bank
    public function createStaff(
        $staff_id,
        $title,
        $first_name,
        $surname,
        $middle_name,
        $fullname,
        $state,
        $local_govt,
        $sex,
        $phone_number,
        $date_of_birth,
        $date_of_employment,
        $date_of_resign,
        $status,
        $step,
        $rank,
        $grade_level,
        $acc_number,
        $bank_id,
        $minist_parast_id
        )
    {
        if ($this->staffExists($staff_id)) {
            return ['success' => false, 'message' => 'staff exists already'];
        }

        // Insert data into database
        $stmt = $this->conn->prepare("INSERT INTO $this->table  (`staff_id`, `title`, `fullname`, `first_name`, `middle_name`, `surname`, `status`, `phone_number`, `sex`, `date_of_birth`, `local_govt`, `state`) VALUES (?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssss", $staff_id, $title, $fullname, $first_name, $middle_name, $surname, $status, $phone_number, $sex, $date_of_birth, $local_govt, $state);
        
        if ($stmt->execute()) {
            $stmt = $this->conn->prepare("INSERT INTO $this->table_emp_info (`staff_id`, `date_of_employment`, `date_of_resign`, `rank`, `grade_level`, `step`, `acc_number`, `bank_id`, `minist_parast_id`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssss", $staff_id, $date_of_employment, $date_of_resign, $rank, $grade_level, $step, $acc_number, $bank_id, $minist_parast_id);
            $stmt->execute();
            return ['success' => true];
        } else {
            return ['success' => false, 'message' => 'Failed to add staff information'];
        }
    }

    // Get staffs with pagination
    public function getStaffs($limit, $offset)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table LIMIT ? OFFSET ?");
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Get total staff count for pagination
    public function getStaffCount()
    {
        $result = $this->conn->query("SELECT COUNT(*) AS total FROM $this->table");
        return $result->fetch_assoc()['total'];
    }

    // Get a single staff by ID
    public function getStaffById($staff_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE staff_id = ?");
        $stmt->bind_param("i", $staff_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    // increment staff step
    public function incrementStaffStep($staff_id, $step)
    {
        if ($this->staffExists($staff_id)) {
            return ['success' => false, 'message' => 'staff exists already'];
        }

        $stmt = $this->conn->prepare("UPDATE $this->table_emp_info SET `step` = ? WHERE staff_id = ?");
        $stmt->bind_param("si", $step, $staff_id);

        if ($stmt->execute()) {
            return ['success' => true];
        } else {
            return ['success' => false, 'message' => 'Failed to update bank'];
        }
    }

    // Delete a bank
    public function deleteStaff($staff_id)
    {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE staff_id = ?");
        $stmt->bind_param("i", $staff_id);

        if ($stmt->execute()) {
            return ['success' => true];
        } else {
            return ['success' => false, 'message' => 'Failed to delete staff'];
        }
    }

    public function loadStaff() {
        $staffs = [];
        $query = "SELECT * FROM $this->table ORDER BY `first_name` ASC";
        $result = $this->conn->query($query);

        if (!$result) {
            echo json_encode(['status' => 'error', 'message' => $this->conn->error]);
            exit;
        }

        while ($row = $result->fetch_assoc()) {
            $staffs[$row['staff_id']] = $row['fullname'];
        }
        echo json_encode(['status' => 'success', 'staffs' => $staffs]);
        exit;
    }
}
