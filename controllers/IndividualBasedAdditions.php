<?php
require_once "../db/connect.php";

class IndividualBasedAdditions extends DB
{
    private $table = "individual_based_additions";

    public function __construct()
    {
        parent::__construct();
    }

    public function exists($staff_id, $description)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE `staff_id` = ? AND `description` LIKE ?");
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

    public function createAddition($staff_id, $description, $amount, $is_active)
    {
        if ($this->exists($staff_id, $description)) {
            return ['success' => false, 'message' => 'Addition already exists for this staff member.'];
        }

        $stmt = $this->conn->prepare("INSERT INTO $this->table (`staff_id`, `description`, `amount`, `is_active`) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isdi", $staff_id, $description, $amount, $is_active);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateAddition($id, $staff_id, $description, $amount, $is_active)
    {
        $stmt = $this->conn->prepare("UPDATE $this->table SET staff_id = ?, description = ?, amount = ?, is_active = ? WHERE id = ?");
        $stmt->bind_param("isdii", $staff_id, $description, $amount, $is_active, $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteAddition($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getAdditions()
    {
        $result = $this->conn->query("SELECT * FROM $this->table");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAdditionsPaginated($limit, $offset)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table LIMIT ? OFFSET ?");
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAdditionById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }
}
