<!DOCTYPE html>
<html lang="en">

<head>
    <?php require ("./included.php"); ?>
    <title>User Dashboard</title>
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
    if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['categ_name'], ['Category I', 'Category II'])) {
        header('Location: ./login.php');
        exit();
    }
    ?>

    <div class="container dashboard-container">
        <h2 class="text-center">User Dashboard</h2>
        <div class="dashboard-card">
            <h4>Welcome, <?php echo htmlspecialchars($_SESSION['user']['username']); ?>!</h4>
            <p>You have access to general user functionalities.</p>
        </div>
        <!-- Add more user-specific functionality here -->
        <a href="./logout.php" class="btn btn-secondary">Logout</a>
    </div>
</body>

</html>