<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TARABA STATE PAYROLL SYSTEM</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="./scripts/user_auth.js" defer></script>
</head>

<body>
    <div class="container">
        <div class="d-flex m-4 justify-content-center align-items-center">
            <div class="auth-form">
                <h4 class="text-center mb-4">TARABA STATE PAYROLL SYSTEM</h4>
                <h4 class="text-center mb-4"><i>Login</i></h4>
                <form id="loginForm">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</body>

</html>