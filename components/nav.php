<nav class="navbar navbar-expand-lg navbar-dark bg-success text-white">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="includes/images/logo.jpg" alt="" width="30" height="24" class="d-inline-block align-text-top">
            Payroll TB
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse text-white" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>

                <?php
                if (isset($_SESSION['categ_name'])):
                    if ($_SESSION['categ_name'] == 'superadmin'): ?>
                        <a href="../views/dashboard.php" class="nav-link">Dashboard</a>
                        <a href="../views/association.php" class="nav-link">Associations</a>
                        <a href="../views/privileges.php" class="nav-link">Monthly salary schedule</a>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Additions
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="grade_based_additions.php">Add by grade</a></li>
                                <li><a class="dropdown-item" href="individual_based_additions.php">Add by individual</a></li>
                                <li><a class="dropdown-item" href="salary_structure_details.php">Salary Structure details</a>
                                </li>

                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Ministry & Users
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="ministry.php">Ministries</a></li>
                                <li><a class="dropdown-item" href="register.php">Create User</a></li>
                                <li><a class="dropdown-item" href="privileges.php">Add user role</a></li>
                                <li><a class="dropdown-item" href="salary_structure.php">Create salary structure</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Staff Deductions
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="grade_based_deductions.php">Deductions by grade</a></li>
                                <li><a class="dropdown-item" href="individual_based_deductions.php">Deductions by Individual</a>
                                </li>
                                <li><a class="dropdown-item" href="banks.php">Create-Banks</a></li>
                                <li><a class="dropdown-item" href="#">Units</a></li>
                            </ul>
                        </li>
                </div>
            <?php elseif ($_SESSION['categ_name'] == 'admin'): ?>
                <a href="../views/privileges.php" class="nav-link">Monthly salary schedule</a>
                <a href="../views/salary_structure.php" class="nav-link">Add salary structure</a>

                <div class="submenu">
                    <a href="../views/ministry.php" class="nav-link">Manage Ministry</a>
                    <a href="../views/association.php" class="nav-link">Create association</a>
                </div>
            <?php elseif ($_SESSION['categ_name'] == 'user'): ?>
                <a href="../views/personal_data.php" class="nav-link">Personal Data</a>
                <a href="../views/password.php" class="nav-link">Password Reset</a>
            <?php endif; ?>
        <?php endif; ?>

        <a href="../views/logout.php" class="nav-link">Logout</a>
        </ul>
    </div>
    </div>
</nav>