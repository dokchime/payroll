<?php
require_once "../controllers/GradeBasedAdditions.php";

$addition = new GradeBasedAdditions();

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
        $salary_structure_grades_id = $_POST['salary_structure_grades_id'];
        $description = $_POST['description'];
        $amount = $_POST['amount'];
        $is_active = $_POST['is_active'] ?? 1; // Default to active if not provided
        $success = $addition->createAddition($year, $month, $salary_structure_grades_id, $description, $amount, $is_active);
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

    case 'read2':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $data = $addition->getAdditionById($id);
            echo json_encode($data);
        } else {
            // Fetch all salary structures details without pagination for dropdown
            $data = $addition->getAllSalaryStructureDetails();
            echo json_encode($data);
        }
        break;    
    
    case 'update':
        $id = $_POST['id'];
        $year = $_POST['year'];
        $month = $_POST['month'];
        $salary_structure_grades_id = $_POST['salary_structure_grades_id'];
        $description = $_POST['description'];
        $amount = $_POST['amount'];
        $is_active = $_POST['is_active'] ?? 1; // Default to active if not provided
        $success = $addition->updateAddition($id, $year, $month, $salary_structure_grades_id, $description, $amount, $is_active);
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
                $struct_name = $row[2];
                $salary_structure_id = $addition->getStructureIdByName($struct_name);
                if ($salary_structure_id === null) {
                    continue; // Skip this record if struct_name is invalid
                }
                $grade_level = $row[3];
                $step = $row[4];
                $salary_structure_grades_id = $addition->getStructureGradesIdByDetails($salary_structure_id, $grade_level, $step);
                if ($salary_structure_grades_id === null) {
                    continue; // Skip this record if grade_level and step are invalid
                }
                $description = $row[5];
                $amount = $row[6];
                $is_active = $row[7] ?? 1; // Default to active if not provided

                if ($addition->createAddition($year, $month, $salary_structure_grades_id, $description, $amount, $is_active)) {
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
