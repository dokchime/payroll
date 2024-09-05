<!DOCTYPE html>
<html lang="en">

<head>
    <?php require("./included.php"); ?>
    <script src="../scripts/priv_loader.js"></script>
    <script src="../scripts/auths.js" defer></script>
</head>

<body>
    <div class="container">
        <div class=" d-flex m-4 justify-content-center align-items-center">
            <div class="auth-form">
                <div class="bg-success p-4">
                    <h4 class="text-center  text-white mb-4">TARABA STATE PAYROLL SYSTEM</h4>
                    <h4 class="text-center text-white mb-4" style="font-family:cursive;"> Register</h4>
                </div>
                <form id="registerForm" class="mt-3">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="categ_id" class="form-label">Role</label>
                        <select id="categ_id" name="categ_id" class="form-select" required>
                            <option value="">Select Role</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Register</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>