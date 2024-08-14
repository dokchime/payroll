<?php
require_once "../db/connect.php";

class Association extends DB
{
    private $table = "association";

    public function __construct()
    {
        parent::__construct();
    }

    public function createAssociation($name, $description, $dues_type, $fixed_amount = null, $percentage_of_gross = null)
    {
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

    public function getAssociationById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }
}
?>
