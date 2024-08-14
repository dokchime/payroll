<?php
require_once '../db/connect.php';

class Privileges extends DB
{
    private $table = "privileges";

    public function __construct()
    {
        parent::__construct();
    }

    // Create a new privilege
    public function createPrivilege($categ_name)
    {
        $stmt = $this->conn->prepare("INSERT INTO $this->table (categ_name) VALUES (?)");
        $stmt->bind_param("s", $categ_name);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Get all privileges
    public function getAllPrivileges()
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Update an existing privilege
    public function updatePrivilege($categ_id, $categ_name)
    {
        $stmt = $this->conn->prepare("UPDATE $this->table SET categ_name = ? WHERE categ_id = ?");
        $stmt->bind_param("si", $categ_name, $categ_id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Delete a privilege
    public function deletePrivilege($categ_id)
    {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE categ_id = ?");
        $stmt->bind_param("i", $categ_id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Get a single privilege by ID
    public function getPrivilegeById($categ_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE categ_id = ?");
        $stmt->bind_param("i", $categ_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }
}
