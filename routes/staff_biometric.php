<?php

// File: routes.php

require_once 'controllers/StaffBiometricController.php';

$biometricController = new StaffBiometricController($db);

// Route to handle biometric data capturing
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'captureBiometric') {
    $staff_id = $_POST['staff_id'];
    $thumbfingerData = $_POST['thumbfingerData'];
    $indexfingerData = $_POST['indexfingerData'];

    if ($biometricController->captureBiometric($staff_id, $thumbfingerData, $indexfingerData)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
}
