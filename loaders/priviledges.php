<?php
require_once "../controllers/Privileges.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $privLoader = new Privileges();
    $privLoader->loadPrivilege();
    // Close the database connection
    $privLoader->closeConnection();
}