<?php
require_once "../controllers/GradeBasedAddition.php";

$addition = new GradeBasedAddition();

// Read raw POST data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Determine the action
$action = $data['action'] ?? $_POST['action'] ?? $_GET['action'] ?? '';

error_log("Action: " . $action);

switch ($action) {
    case 'create':
        $salary_structure_grades_id = $_POST['salary_structure_grades_id'];
        $description = $_POST['description'];
        $amount = $_POST['amount'];
        $is_active = $_POST['is_active'] ?? 1; // Default to active if not provided
        $success = $addition->createAddition($salary_structure_grades_id, $description, $amount, $is_active);
        echo json_encode(['success' => $success]);
        break;

    case 'read':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $data = $addition->getAdditionById($id);
            echo json_encode($data);
        } else {
            $page = $_GET['page'] ?? 1;
            $limit = 5; // Number of records per page
            $offset = ($page - 1) * $limit;

            $data = $addition->getAdditionsPaginated($limit, $offset);
            $totalAdditions = $addition->getCounts();
            $totalPages = ceil($totalAdditions / $limit);
            echo json_encode(['status' => true, 'data' => $data, 'totalPages' => $totalPages]);
        }
        break;

    case 'update':
        $id = $_POST['id'];
        $salary_structure_grades_id = $_POST['salary_structure_grades_id'];
        $description = $_POST['description'];
        $amount = $_POST['amount'];
        $is_active = $_POST['is_active'] ?? 1; // Default to active if not provided
        $success = $addition->updateAddition($id, $salary_structure_grades_id, $description, $amount, $is_active);
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
                $salary_structure_grades_id = $row[0];
                $description = $row[1];
                $amount = $row[2];
                $is_active = $row[3] ?? 1; // Default to active if not provided

                if ($addition->createAddition($salary_structure_grades_id, $description, $amount, $is_active)) {
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
        $success = $addition->deleteAddition($id);
        echo json_encode(['success' => $success]);
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}
