<?php
require_once "../controllers/IndividualBasedDeductions.php";

$deduction = new Deduction();

// Read raw POST data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Determine the action
$action = $data['action'] ?? $_POST['action'] ?? $_GET['action'] ?? '';

error_log("Action: " . $action);

switch ($action) {
    case 'create':
        $staff_id = $_POST['staff_id'];
        $description = $_POST['description'];
        $amount = $_POST['amount'];
        $is_active = $_POST['is_active'];
        $response = $deduction->createDeduction($staff_id, $description, $amount, $is_active);
        echo json_encode($response);
        break;

    case 'read':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $data = $deduction->getDeductionById($id);
            echo json_encode($data);
        } else {
            $page = $_GET['page'] ?? 1;
            $limit = 5; // Number of records per page
            $offset = ($page - 1) * $limit;

            $data = $deduction->getDeductionsPaginated($limit, $offset);
            $totalDeduction = $deduction->getCounts();
            $totalPages = ceil($totalDeduction / $limit);
            echo json_encode(['status' => true, 'data' => $data, 'totalPages' => $totalPages]);
        }
        break;

    case 'update':
        $id = $_POST['id'];
        $staff_id = $_POST['staff_id'];
        $description = $_POST['description'];
        $amount = $_POST['amount'];
        $is_active = $_POST['is_active'];
        $response = $deduction->updateDeduction($id, $staff_id, $description, $amount, $is_active);
        echo json_encode($response);
        break;

    case 'bulkUpload':
        if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
            $csvFile = $_FILES['csv_file']['tmp_name'];
            $response = $deduction->bulkUpload($csvFile);
            echo json_encode($response);
        } else {
            echo json_encode(['success' => false, 'message' => 'CSV file upload failed']);
        }
        break;

    case 'delete':
        $id = $data['id'];
        $response = $deduction->deleteDeduction($id);
        echo json_encode($response);
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}