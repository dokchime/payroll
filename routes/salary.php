<?php
require_once "../controllers/Salary.php";

$salary = new Salary();


if (isset($_POST['action'])) {

    $action = $_POST['action'];

    switch ($action) {
        case 'create_salary_structure':
            $name = $_POST['name'];
            $description = $_POST['description'];
            $highest_grad_level = $_POST['highest_grad_level'];
            $min_step = $_POST['min_step'];
            $result = $salary->createSalaryStructure($name, $description, $highest_grad_level, $min_step);
            echo json_encode(['status' => $result ? 'success' : 'error']);
            break;
            // case 'create':
            //     $psn = $_POST['psn'];

            //     $result = $salary->createSalary($psn);
            //     echo json_encode(['status' => $result ? 'success' : 'error']);
            //     break;
        case 'getSalary':
            $psn = $_POST['psn'];

            $result = $salary->getStaffSalary($psn);
            echo json_encode(['status' => $result ? 'success' : 'error']);
            break;
        case 'read':

            $page = $_GET['page'] ?? 1;
            $limit = 5; // Number of records per page
            $offset = ($page - 1) * $limit;

            $data = $salary->getSalaryStructPaginated($limit, $offset);
            $totalAssoc = $salary->getStructureCounts();
            $totalPages = ceil($totalAssoc / $limit);
            echo json_encode(['status' => true, 'data' => $data, 'totalPages' => $totalPages]);
            break;

        default:
            echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
            break;
    }
}
