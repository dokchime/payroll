<?php
session_start();

// Check if the 'username' session is not set
if (!isset($_SESSION['username'])) {
    // Redirect to index.php (login page) if the session does not exist
    header('Location: ../index.php');
    exit();
}
