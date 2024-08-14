<?php
require_once "../db/connect.php";

class LGALoader extends DB {
  
    private $table_lga = "lga";

    public function __construct() {
        parent::__construct();
    }

    public function loadLGAs($state_id) {
        $lgas = [];
        $query = "SELECT * FROM $this->table_lga WHERE state_id = ? ORDER BY lga_name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $state_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            echo json_encode(['status' => 'error', 'message' => $this->conn->error]);
            exit;
        }

        while ($row = $result->fetch_assoc()) {
            $lgas[] = ['id' => $row['id'], 'name' => $row['lga_name']];
        }
        echo json_encode(['status' => 'success', 'lgas' => $lgas]);
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $state_id = $_POST['state_id'];

    $lgaLoader = new LGALoader();
    $lgaLoader->loadLGAs($state_id);
}
?>
