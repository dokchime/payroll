<?php
require_once "../controllers/Banks.php";

$banks = new Banks();

// Read raw POST data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Determine the action
$action = $data['action'] ?? $_POST['action'] ?? $_GET['action'] ?? '';

error_log("Action: " . $action);

switch ($action) {
    case 'create':
        $bank_name = $_POST['bank_name'] ?? $data['bank_name'];
        $sort_code = $_POST['sort_code'] ?? $data['sort_code'];
        $success = $banks->createBank($bank_name, $sort_code);
        echo json_encode(['success' => $success]);
        break;

    case 'read':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $data = $banks->getBankById($id);
            echo json_encode($data);
        } else {
            $page = $_GET['page'] ?? 1;
            $limit = 5; // Number of records per page
            $offset = ($page - 1) * $limit;

            $data = $banks->getBanks($limit, $offset);
            $totalBanks = $banks->getBankCount();
            $totalPages = ceil($totalBanks / $limit);

            echo json_encode(['data' => $data, 'totalPages' => $totalPages]);
        }
        break;


    case 'update':
        $id = $_POST['id'] ?? $data['id'];
        $bank_name = $_POST['bank_name'] ?? $data['bank_name'];
        $sort_code = $_POST['sort_code'] ?? $data['sort_code'];
        $success = $banks->updateBank($id, $bank_name, $sort_code);
        echo json_encode(['success' => $success]);
        break;

    case 'delete':
        $id = $_POST['id'] ?? $data['id'];
        $success = $banks->deleteBank($id);
        echo json_encode(['success' => $success]);
        break;

    case 'bulkUpload':
        if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
            $csvFile = $_FILES['csv_file']['tmp_name'];
            $file = fopen($csvFile, 'r');

            $success = true;
            while (($row = fgetcsv($file, 1000, ",")) !== FALSE) {
                $bank_name = $row[0];
                $sort_code = $row[1];

                if (!$banks->createBank($bank_name, $sort_code)) {
                    $success = false;
                    break;
                }
            }
            fclose($file);
            echo json_encode(['success' => $success]);
        } else {
            echo json_encode(['success' => false, 'message' => 'CSV file upload failed']);
        }
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}
