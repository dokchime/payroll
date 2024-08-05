<?php
require_once "../db/connect.php";

class Authenticate extends DB
{
    private $table = "user_tb";

    public function __construct()
    {
        parent::__construct();
    }

    public function loginUser($username, $pass)
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($pass, $user['password'])) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function registerUser($username, $email, $pass)
    {
        // Check if username or email already exists
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return false; // Username or email already exists
        }

        // Hash the password before storing it
        $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

        // Insert the new user into the database
        $stmt = $this->conn->prepare("INSERT INTO $this->table (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_pass);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
