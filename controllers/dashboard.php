<?php
require_once "../db/connect.php";

class DashboardController {
    private $db;

    public function __construct() {
        $this->db = new DB();
    }

    public function getMinistryCount() {
        return $this->db->getConnection()->query("SELECT * FROM ministry_paras")->num_rows;
    }

    public function getUnitCount() {
        return $this->db->getConnection()->query("SELECT * FROM paycode")->num_rows;
    }

    public function getUserCount() {
        return $this->db->getConnection()->query("SELECT * FROM paycode1")->num_rows;
    }

    public function getEmployeeCount() {
        return $this->db->getConnection()->query("SELECT * FROM users")->num_rows;
    }

    public function getCapturedStaffCount() {
        return $this->db->getConnection()->query("SELECT * FROM staff_info2")->num_rows;
    }

    public function getPendingStaffCount() {
        return $this->db->getConnection()->query("SELECT * FROM salary_data")->num_rows;
    }
}
?>
