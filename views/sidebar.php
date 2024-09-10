<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="sidebar">
        <div class="dropdown">
            <a href="../views/index.php" class="brand-link">
                <?php
                if (isset($_SESSION['categ_name'])):
                    if ($_SESSION['categ_name'] == 'superadmin'): ?>
                        <h3 class="text-center p-0 m-0"><b>SUPER ADMIN</b></h3>
                        <a href="../views/dashboard.php" class="nav-link">Dashboard</a>
                        <a href="../views/staff_capturing.php" class="nav-link">Staff Capturing</a>
                        <a href="#" class="nav-link">Qualifications</a>
                        <div class="submenu">
                            <a href="../views/salary_structure.php" class="nav-link">Add Salary Structure</a>
                            <a href="../views/salary_structure_details.php" class="nav-link">Salary Structure Details</a>
                        </div>
                    <?php elseif ($_SESSION['categ_name'] == 'admin'): ?>
                        <h3 class="text-center p-0 m-0"><b>ADMIN</b></h3>
                        <a href="../views/staff_deductions.php" class="nav-link">Staff Deductions</a>
                        <a href="#" class="nav-link">Qualifications</a>
                        <div class="submenu">
                            <a href="../views/contributions.php" class="nav-link">Staff Contributions</a>
                            <a href="../views/manage_staff.php" class="nav-link">Manage Staff</a>
                        </div>
                    <?php elseif ($_SESSION['categ_name'] == 'user'): ?>
                        <h3 class="text-center p-0 m-0"><b>User</b></h3>
                        <a href="../views/personal_data.php" class="nav-link">Personal Data</a>
                        <a href="../views/password.php" class="nav-link">Password Reset</a>
                    <?php else: ?>
                        <h3 class="text-center p-0 m-0"><b>Guest</b></h3>
                    <?php endif; ?>
                    else: ?>
                    <h3 class="text-center p-0 m-0"><b>Guest</b></h3>
                <?php endif; ?>
            </a>
        </div>
    </div>

</body>

</html>