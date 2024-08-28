<?php require("../session/isloggedin.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require("./included.php"); ?>
</head>

<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['categ_name']); ?>!</h1>
    <p>You are logged in.</p>
    <a href="logout.php">Logout</a>
</body>

</html>