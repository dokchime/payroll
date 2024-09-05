<?php
require_once "../db/connect.php";
$db = new DB();

?>

<?php
// $conn = new mysqli('localhost', 'root', '?dokchime2', 'ts_payrol');
?>
<?php require("../session/isloggedin.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <?php require("../included.php"); ?>
    <script src="../scripts/auths.js" defer></script>
</head>
<?php
include '../components/nav.php';
include '../utils/notifier.php';
?>

<body>
    <!-- Info boxes -->
    <?php if ($_SESSION['categ_name'] == 'superadmin'): ?>
        <div class="card pt-5">
            <div class="card-body">
                <div class="row px-3">
                    <!-- Total Ministry & Parasitatals -->
                    <div class="col-12 col-sm-6 col-md-4 ">
                        <div
                            class="small-box bg-primary text-white shadow-sm border border-2 text-center justify-content-center p-3">
                            <div class="inner">
                                <h3><?php echo $db->getConnection()->query("SELECT * FROM ministry_paras")->num_rows; ?>
                                </h3>
                                <p>Total Ministry & Parasitatals</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-th-list"></i>
                            </div>
                        </div>
                    </div>
                    <!-- Total Units -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div
                            class="small-box bg-success text-white shadow-sm border border-2 text-center justify-content-center p-3">
                            <div class="inner">
                                <h3><?php echo $db->getConnection()->query("SELECT * FROM paycode")->num_rows; ?></h3>
                                <p>Total Units</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-list-alt"></i>
                            </div>
                        </div>
                    </div>
                    <!-- Total Users -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div
                            class="small-box bg-warning text-white shadow-sm border border-2 text-center justify-content-center p-3">
                            <div class="inner">
                                <h3><?php echo $db->getConnection()->query("SELECT * FROM paycode1")->num_rows; ?></h3>
                                <p>Total Users</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row pt-2 px-3">
                    <!-- Total Employees -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div
                            class="small-box bg-danger text-white shadow-sm border border-2 text-center justify-content-center p-3">
                            <div class="inner">
                                <h3><?php echo $db->getConnection()->query("SELECT * FROM users")->num_rows; ?></h3>
                                <p>Total Employees</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-user-friends"></i>
                            </div>
                        </div>
                    </div>
                    <!-- Total Number of Captured Staff -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div
                            class="small-box bg-info text-white shadow-sm border border-2 text-center justify-content-center p-3">
                            <div class="inner">
                                <h3><?php echo $db->getConnection()->query("SELECT * FROM staff_info2")->num_rows; ?>
                                </h3>
                                <p>Total Number of Captured Staff</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-tasks"></i>
                            </div>
                        </div>
                    </div>
                    <!-- Total Pending staff yet to be Captured -->
                    <div class="col-12 col-sm-6 col-md-4">
                        <div
                            class="small-box bg-secondary text-white shadow-sm border border-2 text-center justify-content-center p-3">
                            <div class="inner">
                                <h3><?php echo $db->getConnection()->query("SELECT * FROM salary_data")->num_rows; ?>
                                </h3>
                                <p>Total Pending staff yet to be Captured</p>
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