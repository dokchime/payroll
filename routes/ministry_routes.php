<?php
require_once "../controllers/Ministry.php";

$ministry = new Ministry();

$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Determine the action
$action = $data['action'] ?? $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'create':
        $name = $_POST['name'];
        $description = $_POST['description'];
        $address = $_POST['address'];
        $result = $ministry->createMinistry($name, $description, $address);
        echo json_encode($success);
        break;

    case 'update':
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $address = $_POST['address'];
        // $logoFile = !empty($_FILES['logo']) ? $_FILES['logo'] : null;
        $result = $ministry->updateMinistry($id, $name, $description, $address);
        echo json_encode(['success' => $result ? true : false, 'message' => $result ? 'success Updated' : 'error']);
        break;

    case 'delete':
        $id = $_POST['id'];
        $result = $ministry->deleteMinistry($id);
        echo json_encode(['status' => $result ? 'success' : 'error']);
        break;

    case 'read':
        $page = $_GET['page'] ?? 1;
        $limit = 5; // Number of records per page
        $offset = ($page - 1) * $limit;

        $data = $ministry->getMinistriesPaginated($limit, $offset);
        $totalMinisties = $ministry->getCounts();
        $totalPages = ceil($totalMinisties / $limit);
        echo json_encode(['status'=>true, 'data' => $data, 'totalPages' => $totalPages]);
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
                $address = $row[2];
                
                if ($ministry->createMinistry($name, $description, $address)) {
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
        
    case 'getById':
        $id = $_POST['id'];
        $ministryData = $ministry->getMinistryById($id);
        echo json_encode(['status' => 'success', 'data' => $ministryData]);
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        break;
}
