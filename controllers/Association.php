<?php
require_once "../db/connect.php";

class Association extends DB
{
    private $table = "association";

    public function __construct()
    {
        parent::__construct();
    }


    public function existance($name, $dues_type)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE `name` LIKE ? AND dues_type LIKE ? ");
        $stmt->bind_param("ss", $name, $dues_type);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    public function getCounts()
    {
        $result = $this->conn->query("SELECT COUNT(*) AS total FROM $this->table");
        return $result->fetch_assoc()['total'];
    }

    public function createAssociation($name, $description, $dues_type, $fixed_amount = null, $percentage_of_gross = null)
    {
        
        if ($this->existance($name, $dues_type)) {
            return ['success' => false, 'message' => 'association exist already'];
        }
        
        $stmt = $this->conn->prepare("INSERT INTO $this->table (`name`, `description`, `dues_type`, `fixed_amount`, `percentage_of_gross`) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdd", $name, $description, $dues_type, $fixed_amount, $percentage_of_gross);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateAssociation($id, $name, $description, $dues_type, $fixed_amount = null, $percentage_of_gross = null)
    {
        $stmt = $this->conn->prepare("UPDATE $this->table SET name = ?, description = ?, dues_type = ?, fixed_amount = ?, percentage_of_gross = ? WHERE id = ?");
        $stmt->bind_param("sssddi", $name, $description, $dues_type, $fixed_amount, $percentage_of_gross, $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteAssociation($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getAssociations()
    {
        $result = $this->conn->query("SELECT * FROM $this->table");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAssociationsPaginated($limit, $offset)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table LIMIT ? OFFSET ?");
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAssociationById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }
}
