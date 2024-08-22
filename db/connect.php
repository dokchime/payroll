<?php


class DB {
    protected $host = "localhost";
    protected $username = "root";
    protected $password = "";
    // protected $dbname = "ts_payrol";
    protected $dbname = "payroll";

    protected $port = '3306';
    protected $conn;

    public function __construct() {
        $this->conn = new mysqli(
            $this->host,
            $this->username,
            $this->password,
            $this->dbname,
            $this->port
        );
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function closeConnection() {
        $this->conn->close();
    }
    public function __destruct() {
        $this->conn->close();
    }
}

?>