<?php
require_once "../db/connect.php";
require_once "../utils/ImageHandler.php";

class Ministry extends DB
{
    private $table = "ministry_parast";

    public function __construct()
    {
        parent::__construct();
    }

    public function existance($name, $address)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE `name` LIKE ? AND `address` LIKE ?");
        $stmt->bind_param("ss", $name, $address);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    public function getCounts()
    {
        $result = $this->conn->query("SELECT COUNT(*) AS total FROM $this->table");
        return $result->fetch_assoc()['total'];
    }

    public function createMinistry($name, $description, $address)
    {
        // $imageHandler = new ImageHandler();
        // $logoPath = $imageHandler->uploadNow($logoFile);

        // if (strpos($logoPath, "Sorry") === false) {
        //     return false; // Image upload failed
        // }

        if ($this->existance($name, $address)) {
            return ['success' => false, 'message' => 'Ministry exist already'];
        }

        $stmt = $this->conn->prepare("INSERT INTO $this->table (`name`, `description`, `address`) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $description, $address);

        if ($stmt->execute()) {
            return ['success' => true, 'message'=>'Ministry Created'];
        } else {
            return ['success' => false, 'message' => 'Failed to create bank'];
        }
    }

    public function updateMinistry($id, $name, $description, $address)
    {
        $stmt = $this->conn->prepare("UPDATE $this->table SET `name` = ?, `description` = ?, `address` = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $description, $address, $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteMinistry($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getMinistries()
    {
        $result = $this->conn->query("SELECT * FROM $this->table");

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getMinistriesPaginated($limit, $offset)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table LIMIT ? OFFSET ?");
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getMinistryById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }
    public function loadMinistries()
    {
        $ministries = [];
        $query = "SELECT * FROM $this->table ORDER BY name ASC";
        $result = $this->conn->query($query);

        if (!$result) {
            echo json_encode(['status' => 'error', 'message' => $this->conn->error]);
            exit;
        }

        while ($row = $result->fetch_assoc()) {
            $ministries[] = [
                'id' => $row['id'],
                'name' => $row['name']
            ];
        }
        echo json_encode(['status' => 'success', 'ministries' => $ministries]);
        exit;
    }
}
