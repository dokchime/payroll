<?php
require_once "../controllers/UserController.php";

$userController = new UserController();

if (isset($_POST['action']) && $_POST['action'] === 'login') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = $userController->authenticate($username, $password);

    if ($user) {
        session_start();
        $_SESSION['user'] = $user;

        // Determine the redirect URL based on the user's role
        if ($user['categ_name'] === 'admin') {
            $redirectUrl = './admin_dashboard.php';
        } else if (in_array($user['categ_name'], ['Category I', 'Category II'])) {
            $redirectUrl = './dashboard.php';
        } else {
            $redirectUrl = './login.php'; // Default redirect (or you can add other roles)
        }

        echo json_encode(['status' => 'success', 'message' => 'Login successful!', 'redirect' => $redirectUrl]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid username or password']);
    }
}
?>