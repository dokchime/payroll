<?php
require_once "../controllers/SalaryStructureGrades.php";
// require_once "../controllers/SalaryStruct.php"; // Add this for fetching salary structure

$salaryStructureGrades = new SalaryStructureGrades();
// $salaryStructure = new SalaryStruct(); // Instantiate the SalaryStructure class

// Read raw POST data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Determine the action
$action = $data['action'] ?? $_POST['action'] ?? $_GET['action'] ?? '';

error_log("Action: " . $action);

switch ($action) {
    case 'create':
        // Fetch salary_structure_id based on struct_name
        $struct_name = $_POST['struct_name'];
        // $salary_structure_id = $salaryStructureGrades->getIdByName($struct_name); // Add this method to fetch ID
        $salary_structure_id = $struct_name;

        $grade_level = $_POST['grade_level'];
        $step = $_POST['step'];
        $success = $salaryStructureGrades->createGrade($salary_structure_id, $grade_level, $step);
        echo json_encode(['success' => $success]);
        break;

    case 'read':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];    
            $data = $salaryStructureGrades->getGradeById($id);
            echo json_encode($data);
        } else {
            $page = $_GET['page'] ?? 1;
            $limit = 5; // Number of records per page
            $offset = ($page - 1) * $limit;

            $data = $salaryStructureGrades->getGradesPaginated($limit, $offset);
            $totalGrades = $salaryStructureGrades->getCounts();
            $totalPages = ceil($totalGrades / $limit);
            echo json_encode(['status' => true, 'data' => $data, 'totalPages' => $totalPages]);
        }
        break;

    case 'read2':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $data = $salaryStructureGrades->getSalaryStructById($id);
            echo json_encode($data);
        } else {
            // Fetch all salary structures without pagination for dropdown
            $data = $salaryStructureGrades->getAllSalaryStructures();
            echo json_encode($data);
        }
        break;    
    
    case 'update':
        // Fetch salary_structure_id based on struct_name
        $struct_name = $_POST['struct_name'];
        //$salary_structure_id = $salaryStructureGrades->getIdByName($struct_name); // Add this method to fetch ID

        $id = $_POST['id'];
        $grade_level = $_POST['grade_level'];
        $step = $_POST['step'];
        $success = $salaryStructureGrades->updateGrade($id, $struct_name, $grade_level, $step);
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
                $struct_name = $row[0];
                $salary_structure_id = $salaryStructureGrades->getIdByName($struct_name); // Add this method to fetch ID
                $grade_level = $row[1];
                $step = $row[2];

                if ($salaryStructureGrades->createGrade($salary_structure_id, $grade_level, $step)) {
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
        $success = $salaryStructureGrades->deleteGrade($id);
        echo json_encode(['success' => $success]);
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}
