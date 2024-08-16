<?php

require_once "../controllers/Staff.php";

$staff = new Staff();

// Read raw POST data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Determine the action
$action = $data['action'] ?? $_POST['action'] ?? $_GET['action'] ?? '';

error_log("Action: " . $action);

switch ($action) {
    case 'create':
        $title = $_POST['title'];
        $staff_id = $_POST['staff_id'];
        $first_name = $_POST['first_name'];
        $surname = $_POST['surname'];
        $middle_name = $_POST['middle_name'];
        $fullname = $surname . ' ' . $first_name;
        if (!empty($middle_name)) {
            $fullname .= ' '.$middle_name;
        }
        $state = $_POST['state'];
        $local_govt = $_POST['local_govt'];
        $sex = $_POST['sex'];
        $phone_number = $_POST['phone_number'];
        $date_of_birth = $_POST['date_of_birth'];

        $date_of_employment = $_POST['date_of_employment'];
        $date_of_resign = $_POST['date_of_resign'];
        $status = $_POST['status'];
        $rank = $_POST['rank'];
        $grade_level = $_POST['grade_level'];
        $step = $_POST['step'];
        $acc_number = $_POST['acc_number'];
        $bank_id = $_POST['bank_id'];
        $acc_number = $_POST['acc_number'];
        $minist_parast_id = $_POST['minist_parast_id'];

        $success = $staff->createStaff(
            $staff_id,
            $title,
            $first_name,
            $surname,
            $middle_name,
            $fullname,
            $state,
            $local_govt,
            $sex,
            $phone_number,
            $date_of_birth,
            $date_of_employment,
            $date_of_resign,
            $status,
            $step,
            $rank,
            $grade_level,
            $acc_number,
            $bank_id,
            $minist_parast_id
        );
        echo json_encode($success);
        break;

    case 'read':
        if (isset($_GET['staff_id'])) {
            $staff_id = $_GET['staff_id'];
            $data = $staff->getStaffById($staff_id);
            echo json_encode($data);
        } else {
            $page = $_GET['page'] ?? 1;
            $limit = 5; // Number of records per page
            $offset = ($page - 1) * $limit;

            $data = $staff->getStaffs($limit, $offset);
            $totalStaff = $staff->getStaffCount();
            $totalPages = ceil($totalStaff / $limit);

            echo json_encode(['data' => $data, 'totalPages' => $totalPages]);
        }
        break;


    case 'increment_step':
        $staff_id = $_POST['staff_id'] ?? $data['staff_id'];
        $step = $_POST['step'] ?? $data['step'];
        $success = $staff->incrementStaffStep($staff_id, $step);
        echo json_encode(['success' => $success]);
        break;

        // case 'delete':
        //     $staff_id = $_POST['staff_id'] ?? $data['staff_id'];
        //     $success = $staff->deleteStaff($staff_id);
        //     echo json_encode(['success' => $success]);
        //     break;

    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}
