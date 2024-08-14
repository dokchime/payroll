<?php
require_once "../controllers/Privileges.php";

$privileges = new Privileges();

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    switch ($action) {
        case 'create_privilege':
            $categ_name = $_POST['categ_name'];
            $result = $privileges->createPrivilege($categ_name);
            echo json_encode(['status' => $result ? 'success' : 'error']);
            break;
        
        case 'get_all_privileges':
            $result = $privileges->getAllPrivileges();
            echo json_encode(['status' => 'success', 'data' => $result]);
            break;
        
        case 'update_privilege':
            $categ_id = $_POST['categ_id'];
            $categ_name = $_POST['categ_name'];
            $result = $privileges->updatePrivilege($categ_id, $categ_name);
            echo json_encode(['status' => $result ? 'success' : 'error']);
            break;
        
        case 'delete_privilege':
            $categ_id = $_POST['categ_id'];
            $result = $privileges->deletePrivilege($categ_id);
            echo json_encode(['status' => $result ? 'success' : 'error']);
            break;

        case 'get_privilege_by_id':
            $categ_id = $_POST['categ_id'];
            $result = $privileges->getPrivilegeById($categ_id);
            echo json_encode(['status' => 'success', 'data' => $result]);
            break;

        default:
            echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
            break;
    }
}
?>
