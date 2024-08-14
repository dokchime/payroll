<?php
require_once '../db/connect.php';

class Banks extends DB
{
    private $table = "banks";

    public function __construct()
    {
        parent::__construct();
    }

    // Check if bank exists
    public function bankExists($bank_name, $sort_code)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE bank_name = ? AND sort_code = ?");
        $stmt->bind_param("ss", $bank_name, $sort_code);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    // Create a new bank
    public function createBank($bank_name, $sort_code)
    {
        if ($this->bankExists($bank_name, $sort_code)) {
            return ['success' => false, 'message' => 'Bank already exists'];
        }

        $stmt = $this->conn->prepare("INSERT INTO $this->table (bank_name, sort_code) VALUES (?, ?)");
        $stmt->bind_param("ss", $bank_name, $sort_code);

        if ($stmt->execute()) {
            return ['success' => true];
        } else {
            return ['success' => false, 'message' => 'Failed to create bank'];
        }
    }

    // Get banks with pagination
    public function getBanks($limit, $offset)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table LIMIT ? OFFSET ?");
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Get total bank count for pagination
    public function getBankCount()
    {
        $result = $this->conn->query("SELECT COUNT(*) AS total FROM $this->table");
        return $result->fetch_assoc()['total'];
    }

    // Get a single bank by ID
    public function getBankById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    // Update a bank
    public function updateBank($id, $bank_name, $sort_code)
    {
        $stmt = $this->conn->prepare("UPDATE $this->table SET bank_name = ?, sort_code = ? WHERE id = ?");
        $stmt->bind_param("ssi", $bank_name, $sort_code, $id);

        if ($stmt->execute()) {
            return ['success' => true];
        } else {
            return ['success' => false, 'message' => 'Failed to update bank'];
        }
    }

    // Delete a bank
    public function deleteBank($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return ['success' => true];
        } else {
            return ['success' => false, 'message' => 'Failed to delete bank'];
        }
    }
}
