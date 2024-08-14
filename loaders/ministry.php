<?php
require_once "../controllers/Ministry.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ministryLoader = new Ministry();
    $ministryLoader->loadMinistries();
    // Close the database connection
    $ministryLoader->closeConnection();
}
?>
