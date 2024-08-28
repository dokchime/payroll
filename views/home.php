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

    <?php
    $twhere = "";
    if ($_SESSION['categ_id'] == 2)
        $twhere = "  ";
    ?>
    <!-- Info boxes -->
    <?php if ($_SESSION['categ_id'] == 1): ?>
        <div class="row">
            <div class="col-12 col-sm-6 col-md-4">
                <div class="small-box bg-light shadow-sm border">
                    <div class="inner">
                        <h3><?php echo $conn->query("SELECT * FROM ministry_parast")->num_rows; ?></h3>
                        <p>Total Ministry & Parasitatals</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-th-list"></i>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="small-box bg-light shadow-sm border">
                    <div class="inner">
                        <h3><?php echo $conn->query("SELECT * FROM units")->num_rows; ?></h3>
                        <p>Total Units</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-list-alt"></i>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="small-box bg-light shadow-sm border">
                    <div class="inner">
                        <h3><?php echo $conn->query("SELECT * FROM users")->num_rows; ?></h3>
                        <p>Total Users</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="small-box bg-light shadow-sm border">
                    <div class="inner">
                        <h3><?php echo $conn->query("SELECT * FROM staff_emp_info")->num_rows; ?></h3>
                        <p>Total Employees</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user-friends"></i>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="small-box bg-light shadow-sm border">
                    <div class="inner">
                        <h3><?php echo $conn->query("SELECT * FROM staff_biometric WHERE staff_biometric_status = 1")->num_rows; ?>
                        </h3>
                        <p>Total Number of Captured Staff</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-tasks"></i>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="small-box bg-light shadow-sm border">
                    <div class="inner">
                        <h3><?php echo $conn->query("SELECT * FROM staff_biometric WHERE staff_biometric_status  = 0")->num_rows; ?>
                        </h3>
                        <p>Total Pending staff yet to be Captured</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user-secret"></i>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    Welcome <?php echo $_SESSION['staffname']; ?>!
                </div>
            </div>
        </div>
    <?php endif; ?>
</body>

</html>