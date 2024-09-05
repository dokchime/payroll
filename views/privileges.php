<?php require("../session/isloggedin.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require("./included.php"); ?>
    <?php include '../components/nav.php'; ?>
    <script src="../scripts/privileges.js" defer></script>
    <style>
        .equal-divs {
            display: flex;
        }

        .equal-divs>div {
            flex: 1;
            padding: 20px;
        }

        .auth-form {
            width: 100%;
            max-width: 100%;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="equal-divs m-4 justify-content-center align-items-start">
            <!-- Form to Add/Edit Category Name -->
            <div class="auth-form p-5">
                <div class="bg-success p-3 mb-2 text-white">
                    <h4 class="mt-2 text-center">Create User role</h4>

                </div>

                <form id="createPrivilegeForm" enctype="multipart/form-data">
                    <input type="hidden" id="categ_id" name="categ_id">

                    <div class="mb-3">
                        <label for="categ_name" class="form-label">Privilege Name</label>
                        <input type="text" class="form-control" id="categ_name" name="categ_name" required>
                    </div>

                    <button type="submit" class="btn btn-success">ADD PRIVILEGE</button>
                </form>
            </div>

            <!-- Display Added Categories -->
            <div class="auth-form p-5">
                <div class="bg-success p-3 mb-2 text-white">
                    <h4 class="mt-2 text-center">Manage Privileges</h4>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Privilege Name</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody id="privilegesTable">
                        <!-- Privileges will be dynamically loaded here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>