<?php
require_once "../controllers/SalaryStruct.php";

$salary = new SalaryStruct();


// Determine the action
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Determine the action
$action = $data['action'] ?? $_POST['action'] ?? $_GET['action'] ?? '';


switch ($action) {
    case 'create_salary_structure':
        $name = $_POST['name'];
        $description = $_POST['description'];
        $result = $salary->createSalaryStructure($name, $description);
        echo json_encode(['status' => $result ? 'success' : 'error']);
        break;

    case 'read':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $data = $salary->getSalaryStructById($id);
            echo json_encode($data);
        } else {
            $page = $_GET['page'] ?? 1;
            $limit = 5; // Number of records per page
            $offset = ($page - 1) * $limit;
    
            $data = $salary->getSalaryStructPaginated($limit, $offset);
            $totalAssoc = $salary->getStructureCounts();
            $totalPages = ceil($totalAssoc / $limit);
            echo json_encode(['status' => true, 'data' => $data, 'totalPages' => $totalPages]);

        }

        break;

    case 'update':
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $success = $salary->updateStruct($id, $name, $description);
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
                $name = $row[0];
                $description = $row[1];
                if ($salary->createSalaryStructure($name, $description)) {
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
    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        break;
}
