<?php
//require_once "../controllers/SalaryStructure.php";
require_once "../controllers/SalaryStructureDetails.php";

//$salaryStructure = new SalaryStructure();
$salaryStructureDetails = new SalaryStructureDetails();

// Read raw POST data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Determine the action
$action = $data['action'] ?? $_POST['action'] ?? $_GET['action'] ?? '';

error_log("Action: " . $action);

switch ($action) {
    case 'create':
        // Fetch salary_structure_grades_id based on struct_details
        $struct_details = $_POST['salary_structure_grades_id'];
        $salary_structure_grades_id = $struct_details;

        $annual_basic = $_POST['annual_basic'];
        $annual_gross = $_POST['annual_gross'];
        $monthly_basic = $_POST['monthly_basic'];
        $monthly_gross = $_POST['monthly_gross'];

        // Get salary_structure_id from struct_name
        /*$salary_structure_id = $salaryStructureDetails->getStructureIdByName($struct_name);
        if ($salary_structure_id === null) {
            echo json_encode(['success' => false, 'message' => 'Invalid salary structure']);
            break;
        }

        // Get salary_structure_grades_id based on grade_level and step
        $salary_structure_grades_id = $salaryStructureDetails->getStructureGradesIdByDetails($salary_structure_id, $grade_level, $step);
        if ($salary_structure_grades_id === null) {
            echo json_encode(['success' => false, 'message' => 'Invalid salary structure grade']);
            break;
        }

        $annual_basic = $_POST['annual_basic'];
        $annual_gross = $_POST['annual_gross'];
        $annual_net = $_POST['annual_net'];
        $monthly_basic = $_POST['monthly_basic'];
        $monthly_gross = $_POST['monthly_gross'];
        $monthly_net = $_POST['monthly_net'];*/

        $success = $salaryStructureDetails->createSalaryStructure($salary_structure_grades_id, $annual_basic, $annual_gross, $monthly_basic, $monthly_gross);
        echo json_encode(['success' => $success]);
        break;

    case 'read':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $data = $salaryStructureDetails->getSalaryStructureById($id);
            echo json_encode($data);
        } else {
            $page = $_GET['page'] ?? 1;
            $limit = 5; // Number of records per page
            $offset = ($page - 1) * $limit;

            $data = $salaryStructureDetails->getSalaryStructuresPaginated($limit, $offset);
            $totalCount = $salaryStructureDetails->getCounts();
            $totalPages = ceil($totalCount / $limit);
            echo json_encode(['status' => true, 'data' => $data, 'totalPages' => $totalPages]);
        }
        break;

    case 'read2':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $data = $salaryStructureDetails->getSalaryStructureById($id);
            echo json_encode($data);
        } else {
            // Fetch all salary structures details without pagination for dropdown
            $data = $salaryStructureDetails->getAllSalaryStructures();
            echo json_encode($data);
        }
        break;    

    case 'update':
        // Fetch salary_structure_grades_id based on struct_details
        $struct_details = $_POST['salary_structure_grades_id'];
        //$salary_structure_grades_id = $struct_details;

        $id = $_POST['id'];
        $annual_basic = $_POST['annual_basic'];
        $annual_gross = $_POST['annual_gross'];
        $monthly_basic = $_POST['monthly_basic'];
        $monthly_gross = $_POST['monthly_gross'];

        $success = $salaryStructureDetails->updateSalaryStructure($id, $struct_details, $annual_basic, $annual_gross, $monthly_basic, $monthly_gross);
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
                $salary_structure_id = $salaryStructureDetails->getStructureIdByName($struct_name);
                if ($salary_structure_id === null) {
                    continue; // Skip this record if struct_name is invalid
                }
                $grade_level = $row[1];
                $step = $row[2];
                $salary_structure_grades_id = $salaryStructureDetails->getStructureGradesIdByDetails($salary_structure_id, $grade_level, $step);
                if ($salary_structure_grades_id === null) {
                    continue; // Skip this record if grade_level and step are invalid
                }
                $annual_basic = $row[3];
                $annual_gross = $row[4];
                $monthly_basic = $row[5];
                $monthly_gross = $row[6];

                if ($salaryStructureDetails->createSalaryStructure($salary_structure_grades_id, $annual_basic, $annual_gross, $monthly_basic, $monthly_gross)) {
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
        $success = $salaryStructureDetails->deleteSalaryStructure($id);
        echo json_encode(['success' => $success]);
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}
