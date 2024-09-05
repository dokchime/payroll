<?php require("../session/isloggedin.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require("./included.php"); ?>
    <script src="../scripts/privileges.js" defer></script>

</head>

<body>
    <div class="container">
        <div class="row d-flex flex-row mt-4">

            <!-- Form to Add/Edit Category Name -->
            <div class="col-md-4">
                <div class="bg-success mt-2 p-4">

                    <h4 class="text-center text-white">Manage Privilege</h4>
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

            <div class="col-md-2"></div>

            <!-- Display Added Categories -->
            <div class="col-md-6">

                <div class="bg-success mt-2 p-4">

                    <h4 class="text-center text-white">Added Privileges</h4>
                </div>

                <table class="table">
                    <thead class="bg-success text-white">
                        <tr>
                            <th>ID</th>
                            <th>Privilege Name</th>
                            <th>Edit</th>
                            <!-- <th>Delete</th> -->
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