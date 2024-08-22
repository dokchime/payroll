<?php
require_once "../db/connect.php";

class Deduction extends DB
{
    private $table = "individual_based_deductions";

    public function __construct()
    {
        parent::__construct();
    }

    public function exists($staff_id, $description)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE `staff_id` = ? AND `description` = ?");
        $stmt->bind_param("is", $staff_id, $description);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    public function getCounts()
    {
        $result = $this->conn->query("SELECT COUNT(*) AS total FROM $this->table");
        return $result->fetch_assoc()['total'];
    }

    public function createDeduction($staff_id, $description, $amount, $is_active)
    {
        if ($this->exists($staff_id, $description)) {
            return ['success' => false, 'message' => 'Deduction already exists'];
        }

        $stmt = $this->conn->prepare("INSERT INTO $this->table (`staff_id`, `description`, `amount`, `is_active`) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isdi", $staff_id, $description, $amount, $is_active);

        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Deduction created successfully'];
        } else {
            return ['success' => false, 'message' => 'Failed to create deduction'];
        }
    }

    public function updateDeduction($id, $staff_id, $description, $amount, $is_active)
    {
        $stmt = $this->conn->prepare("UPDATE $this->table SET staff_id = ?, description = ?, amount = ?, is_active = ? WHERE id = ?");
        $stmt->bind_param("isdii", $staff_id, $description, $amount, $is_active, $id);

        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Deduction updated successfully'];
        } else {
            return ['success' => false, 'message' => 'Failed to update deduction'];
        }
    }

    public function deleteDeduction($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Deduction deleted successfully'];
        } else {
            return ['success' => false, 'message' => 'Failed to delete deduction'];
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

    public function bulkUpload($csvFile)
    {
        $file = fopen($csvFile, 'r');

        // Skip the header row
        fgetcsv($file);

        $success = false;
        $uploadedCount = 0;
        $failedRows = [];

        while (($row = fgetcsv($file, 1000, ",")) !== FALSE) {
            $staff_id = $row[0];
            $description = $row[1];
            $amount = $row[2];
            $is_active = $row[3];

            if (!is_numeric($amount) || !in_array($is_active, ['0', '1'])) {
                $failedRows[] = $row;
                continue;
            }

            if ($this->createDeduction($staff_id, $description, $amount, $is_active)['success']) {
                $success = true;
                $uploadedCount++;
            } else {
                $failedRows[] = $row;
            }
        }
        fclose($file);

        if ($uploadedCount > 0) {
            $message = "$uploadedCount records successfully uploaded.";
            if (!empty($failedRows)) {
                $message .= " However, some rows failed.";
            }
            return ['success' => true, 'message' => $message, 'failedRows' => $failedRows];
        } else {
            return ['success' => false, 'message' => 'No records were uploaded.', 'failedRows' => $failedRows];
        }
    }
}