<?php
require_once "../controllers/Banks.php";



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    
    $bankLoader = new Banks();
    $bankLoader->loadBanks();
    // Close the database connection
    $bankLoader->closeConnection();
}