<?php
require_once "../controllers/IndividualBasedDeductions.php";

$individualDeduction = new IndividualBasedDeductions();

// Read raw POST data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Determine the action
$action = $data['action'] ?? $_POST['action'] ?? $_GET['action'] ?? '';

error_log("Action: " . $action);

switch ($action) {
    case 'create':
        $year = $_POST['year'];
        $month = $_POST['month'];
        $staff_id = $_POST['staff_id'];
        $description = $_POST['description'];
        $amount = $_POST['amount'];
        $is_active = $_POST['is_active'];
        $success = $individualDeduction->createDeduction($year, $month, $staff_id, $description, $amount, $is_active);
        echo json_encode(['success' => $success]);
        break;

    case 'read':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $data = $individualDeduction->getDeductionById($id);
            echo json_encode($data);
        } else {
            $page = $_GET['page'] ?? 1;
            $limit = 5; // Number of records per page
            $offset = ($page - 1) * $limit;

            $data = $individualDeduction->getDeductionsPaginated($limit, $offset);
            $totalDeductions = $individualDeduction->getCounts();
            $totalPages = ceil($totalDeductions / $limit);
            echo json_encode(['status' => true, 'data' => $data, 'totalPages' => $totalPages]);
        }
        break;

    case 'update':
        $id = $_POST['id'];
        $year = $_POST['year'];
        $month = $_POST['month'];
        $staff_id = $_POST['staff_id'];
        $description = $_POST['description'];
        $amount = $_POST['amount'];
        $is_active = $_POST['is_active'];
        $success = $individualDeduction->updateDeduction($id, $year, $month, $staff_id, $description, $amount, $is_active);
        echo json_encode(['success' => $success]);
        break;

    case 'bulkUpload':
        if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
            $csvFile = $_FILES['csv_file']['tmp_name'];
            $file = fopen($csvFile, 'r');

            // Skip the header row
            fgetcsv($file);

            $success = false;
            $uploadedCount = 0;
            while (($row = fgetcsv($file, 1000, ",")) !== FALSE) {
                $year = $row[0];
                $month = $row[1];
                $staff_id = $row[2];
                $description = $row[3];
                $amount = $row[4];
                $is_active = $row[5];

                if ($individualDeduction->createDeduction($year, $month, $staff_id, $description, $amount, $is_active)) {
                    $success = true;
                    $uploadedCount++;
                }
            }
            fclose($file);

            if ($uploadedCount > 0) {
                echo json_encode(['success' => true, 'message' => "$uploadedCount records successfully uploaded."]);
            } else {
                echo json_encode(['success' => false, 'message' => 'No records were uploaded.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'CSV file upload failed']);
        }
        break;

    case 'delete':
        $id = $data['id'];
        $success = $individualDeduction->deleteDeduction($id);
        echo json_encode(['success' => $success]);
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}
