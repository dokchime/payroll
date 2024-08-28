<?php
require_once "../controllers/MonthlySalarySchedule.php";

$salarySchedule = new MonthlySalarySchedule();

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
        $staff_id = $_POST['staff_id'];
        $due_date = $_POST['due_date'];
        $is_active = $_POST['is_active'];
        $comment = $_POST['comment'];

        // Let the backend handle the computation of the additions, deductions, and net_take_home_pay
        $success = $salarySchedule->createSalarySchedule(
            $year, 
            $month, 
            $salary_structure_grades_id, 
            $staff_id, 
            $due_date, 
            $is_active,
            $comment
        );
        echo json_encode(['success' => $success]);
        break;

    case 'read':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $data = $salarySchedule->getSalaryScheduleById($id);
            echo json_encode($data);
        } else {
            $page = $_GET['page'] ?? 1;
            $limit = 5; // Number of records per page
            $offset = ($page - 1) * $limit;

            $data = $salarySchedule->getSalarySchedulesPaginated($limit, $offset);
            $totalSchedules = $salarySchedule->getCounts();
            $totalPages = ceil($totalSchedules / $limit);
            echo json_encode(['status' => true, 'data' => $data, 'totalPages' => $totalPages]);
        }
        break;

    case 'read2':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $data = $salarySchedule->getSalaryScheduleById($id);
            echo json_encode($data);
        } else {
            // Fetch all salary structures details without pagination for dropdown
            $data = $salarySchedule->getAllSalaryStructureDetails();
            echo json_encode($data);
        }
        break;    
    
    case 'update':
        $id = $_POST['id'];
        $year = $_POST['year'];
        $month = $_POST['month'];
        $salary_structure_grades_id = $_POST['salary_structure_grades_id'];
        $staff_id = $_POST['staff_id'];
        $due_date = $_POST['due_date'];
        $is_active = $_POST['is_active'];
        $comment = $_POST['comment'];

        // Let the backend handle the computation of the additions, deductions, and net_take_home_pay
        $success = $salarySchedule->updateSalarySchedule(
            $id, 
            $year, 
            $month, 
            $salary_structure_grades_id, 
            $staff_id, 
            $due_date, 
            $is_active,
            $comment
        );
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
                $salary_structure_id = $salarySchedule->getStructureIdByName($struct_name);
                if ($salary_structure_id === null) {
                    continue; // Skip this record if struct_name is invalid
                }
                $grade_level = $row[3];
                $step = $row[4];
                $salary_structure_grades_id = $salarySchedule->getStructureGradesIdByDetails($salary_structure_id, $grade_level, $step);
                if ($salary_structure_grades_id === null) {
                    continue; // Skip this record if grade_level and step are invalid
                }
                $staff_id = $row[5];
                $due_date = $row[6];
                $is_active = $row[7];
                $comment = $row[8];

                // Let the backend handle the computation of the additions, deductions, and net_take_home_pay
                if ($salarySchedule->createSalarySchedule(
                    $year, 
                    $month, 
                    $salary_structure_grades_id, 
                    $staff_id, 
                    $due_date, 
                    $is_active,
                    $comment
                )) {
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
        $success = $salarySchedule->deleteSalarySchedule($id);
        echo json_encode(['success' => $success]);
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}
?>
