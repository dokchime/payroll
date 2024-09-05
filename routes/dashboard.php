<?php
require_once "../session/isloggedin.php";
require_once "../controllers/dashboardController.php";
include '../components/nav.php';
include '../utils/notifier.php';

$dashboardController = new DashboardController();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <?php require("../included.php"); ?>
    <script src="../scripts/auths.js" defer></script>
</head>
<body>
    <?php if ($_SESSION['categ_name'] == 'superadmin'): ?>
        <div class="card pt-5">
            <div class="card-body">
                <div class="row px-3">
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="small-box bg-primary text-white shadow-sm border border-2 text-center justify-content-center p-3">
                            <div class="inner">
                                <h3><?php echo $dashboardController->getMinistryCount(); ?></h3>
                                <p>Total Ministry & Parasitatals</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-th-list"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="small-box bg-success text-white shadow-sm border border-2 text-center justify-content-center p-3">
                            <div class="inner">
                                <h3><?php echo $dashboardController->getUnitCount(); ?></h3>
                                <p>Total Units</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-list-alt"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="small-box bg-warning text-white shadow-sm border border-2 text-center justify-content-center p-3">
                            <div class="inner">
                                <h3><?php echo $dashboardController->getUserCount(); ?></h3>
                                <p>Total Users</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pt-2 px-3">
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="small-box bg-danger text-white shadow-sm border border-2 text-center justify-content-center p-3">
                            <div class="inner">
                                <h3><?php echo $dashboardController->getEmployeeCount(); ?></h3>
                                <p>Total Employees</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-user-friends"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="small-box bg-info text-white shadow-sm border border-2 text-center justify-content-center p-3">
                            <div class="inner">
                                <h3><?php echo $dashboardController->getCapturedStaffCount(); ?></h3>
                                <p>Total Number of Captured Staff</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-tasks"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="small-box bg-secondary text-white shadow-sm border border-2 text-center justify-content-center p-3">
                            <div class="inner">
                                <h3><?php echo $dashboardController->getPendingStaffCount(); ?></h3>
                                <p>Total Pending Staff Yet to be Captured</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-user-secret"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    Welcome <?php echo $_SESSION['categ_name']; ?>!
                </div>
            </div>
        </div>
    <?php endif; ?>
</body>
</html>
