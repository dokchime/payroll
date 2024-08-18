<!DOCTYPE html>
<html lang="en">

<head>
    <?php require ("./included.php"); ?>
    <script src="./scripts/auths.js" defer></script>
</head>

<body>
    <?php
    // include './components/nav.php';
    // include './utils/notification.php';
    ?>
    <div class="container">

        <div class=" d-flex m-4 justify-content-center align-items-center ">
            <div class="auth-form">
                <div class="bg-success p-4">
                    <h4 class="text-center  text-white mb-4">TARABA STATE PAYROLL SYSTEM</h4>
                    <h4 class="text-center text-white mb-4" style="font-family:cursive;"> Login</h4>
                </div>
                <form id="loginForm" action="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>