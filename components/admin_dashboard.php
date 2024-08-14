<!DOCTYPE html>
<html lang="en">

<head>
    <?php require("./included.php"); ?>
    <title>Admin Dashboard</title>
    <style>
        .dashboard-container {
            padding: 20px;
        }
        .dashboard-card {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <?php
    session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user']['categ_name'] !== 'Admin') {
        header('Location: ./login.php');
        exit();
    }
    ?>

    <div class="container dashboard-container">
        <h2 class="text-center">Admin Dashboard</h2>
        <div class="dashboard-card">
            <h4>Welcome, <?php echo htmlspecialchars($_SESSION['user']['username']); ?>!</h4>
            <p>As an admin, you have full access to the system.</p>
        </div>
        <!-- Add more admin-specific functionality here -->
        <a href="./logout.php" class="btn btn-secondary">Logout</a>
    </div>
</body>

</html>
