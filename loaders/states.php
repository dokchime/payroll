<?php
require_once "../db/connect.php";

class StatesLoader extends DB {
  
    private $table = "states";
    public function __construct() {
        parent::__construct();
    }

    public function loadStates() {
        $states = [];
        $query = "SELECT * FROM $this->table ORDER BY state_name ASC";
        $result = $this->conn->query($query);

        if (!$result) {
            echo json_encode(['status' => 'error', 'message' => $this->conn->error]);
            exit;
        }

        while ($row = $result->fetch_assoc()) {
            $states[$row['state_id']] = $row['state_name'];
        }
        echo json_encode(['status' => 'success', 'states' => $states]);
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    
    $unitLoader = new StatesLoader();
    $unitLoader->loadStates();
    // Close the database connection
    $unitLoader->closeConnection();
}

?>
