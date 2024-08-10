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
            $data = $association->getAssociations();
            echo json_encode($data);
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

    case 'delete':
        $id = $data['id'];
        $success = $association->deleteAssociation($id);
        echo json_encode(['success' => $success]);
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}
