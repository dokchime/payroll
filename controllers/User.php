<?php
require_once '../db/connect.php';

class UserController extends DB
{
    private $table = "users";

    public function __construct()
    {
        parent::__construct();
    }

    public function authenticate($username, $password)
    {
        $stmt = $this->conn->prepare("
            SELECT u.*, p.categ_name 
            FROM $this->table u 
            LEFT JOIN privileges p ON u.categ_id = p.categ_id
            WHERE u.username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            return $user; // Return user data on successful authentication
        } else {
            return false; // Authentication failed
        }
    }

    // Additional methods for user-related operations can be added here
}
?>
