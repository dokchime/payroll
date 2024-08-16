<?php
require_once "../controllers/Association.php";

$association = new Association();

// Read raw POST data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Determine the action
$action = $data['action'] ?? $_POST['action'] ?? $_GET['action'] ?? '';


error_log("Action: " . $action);

switch ($action) {
    case 'create':
        $name = $_POST['name'];
        $description = $_POST['description'];
        $dues_type = $_POST['dues_type'];
        $fixed_amount = $_POST['fixed_amount'];
        $percentage_of_gross = $_POST['percentage_of_gross'];
        $success = $association->createAssociation($name, $description, $dues_type, $fixed_amount, $percentage_of_gross);
        echo json_encode(['success' => $success]);
        break;

    case 'read':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $data = $association->getAssociationById($id);
            echo json_encode($data);
        } else {
            // $data = $association->getAssociations();
            // echo json_encode($data);

            $page = $_GET['page'] ?? 1;
            $limit = 5; // Number of records per page
            $offset = ($page - 1) * $limit;

            $data = $association->getAssociationsPaginated($limit, $offset);
            $totalAssoc = $association->getCounts();
            $totalPages = ceil($totalAssoc / $limit);
            echo json_encode(['status' => true, 'data' => $data, 'totalPages' => $totalPages]);
            break;
        }
        break;

    case 'update':
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $dues_type = $_POST['dues_type'];
        $fixed_amount = $_POST['fixed_amount'];
        $percentage_of_gross = $_POST['percentage_of_gross'];
        $success = $association->updateAssociation($id, $name, $description, $dues_type, $fixed_amount, $percentage_of_gross);
        echo json_encode(['success' => $success]);
        break;

    case 'bulkUpload':
        if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
            $csvFile = $_FILES['csv_file']['tmp_name'];
            $file = fopen($csvFile, 'r');
        
            // Skip the header row
            fgetcsv($file);
        
            $success = true;
            while (($row = fgetcsv($file, 1000, ",")) !== FALSE) {
                $name = $row[0];
                $description = $row[1];
                $dues_type = $row[2];
                $fixed_amount = $row[3];
                $percentage_of_gross = $row[4];
        
                if (!$association->createAssociation($name, $description, $dues_type, $fixed_amount, $percentage_of_gross)) {
                    $success = false;
                    break;
                }
            }
            fclose($file);
            echo json_encode(['success' => $success]);
        } else {
            echo json_encode(['success' => false, 'message' => 'CSV file upload failed']);
        }
        

    case 'delete':
        $id = $data['id'];
        $success = $association->deleteAssociation($id);
        echo json_encode(['success' => $success]);
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}
