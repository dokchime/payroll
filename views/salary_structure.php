<!DOCTYPE html>
<html lang="en">

<head>

    <?php require("./included.php"); ?>
    <script src="../scripts/utils.js"></script>
    <script src="../scripts/salary.js" defer></script>

</head>

<body>
    <div class="container">
        <div class=" d-flex m-4 justify-content-center align-items-center">
            <div class="auth-form p-5">
                <div class="bg-success p-5 mb-2">
                    <h4 class="mt-2 text-center text-white">Create Salary Structure</h4>
                </div>

                <form id="salaryForm" enctype="multipart/form-data">
                    
                    <input type="hidden" id="id" name="id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="highest_grad_level" class="form-label">Highest Grade Level</label>
                        <input type="text" class="form-control" id="highest_grad_level" name="highest_grad_level" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="min_step" class="form-label">Minimun Step</label>
                        <input type="text" class="form-control" id="min_step" name="min_step" required>
                    </div>

                    <button type="submit" class="btn btn-success">Submit</button>
                </form>

            </div>
        </div>

        <div class="mt-5">
            <div class="bg-success p-3">
                <h4 class="text-center text-white"> <i> SALARY STRUCTURE </i></h4>
            </div>
            <table class="table table-responsive" id="structTable">
                <thead>
                    <tr class="bg-success text-white">
                        <th>Name</th>
                        <th>Description</th>
                        <th>Highest Grade Level</th>
                        <th>Minimun Step</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Rows will be populated by JavaScript -->
                </tbody>
            </table>
            <!-- Pagination Buttons -->
            <div id="pagination" class="d-flex justify-content-center mt-4"></div>
        </div>
    </div>

</body>

</html>