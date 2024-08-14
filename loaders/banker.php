<?php
require_once "../db/connect.php";

class BankLoader extends DB {
  
    private $table = "pay_point";
    public function __construct() {
        parent::__construct();
    }

    public function loadBanks() {
        $banks = [];
        $query = "SELECT * FROM $this->table ORDER BY `name` ASC";
        $result = $this->conn->query($query);

        if (!$result) {
            echo json_encode(['status' => 'error', 'message' => $this->conn->error]);
            exit;
        }

        while ($row = $result->fetch_assoc()) {
            $banks[$row['id']] = $row['name'];
        }
        echo json_encode(['status' => 'success', 'banks' => $banks]);
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    
    $bankLoader = new BankLoader();
    $bankLoader->loadBanks();
    // Close the database connection
    $bankLoader->closeConnection();
}

?>
