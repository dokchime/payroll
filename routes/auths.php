<?php
session_start();
require_once '../controllers/Auth.php';

// Create User object
$auths = new Authenticate();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'login') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $auths->loginUser($email, $password);
    if ($user) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['categ_name'] = $user['categ_name']; 
        echo json_encode(['status' => 'success', 'user' => $user]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid username or password']);
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'register') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $categ_id = $_POST['categ_id'];

    // Attempt to register the new user
    if ($auths->registerUser($username, $email, $password, $categ_id)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Registration failed. email may already be taken.']);
    }
}

?>