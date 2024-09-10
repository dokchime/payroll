<?php require("../session/isloggedin.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <?php require("./included.php"); ?>
    <script src="../scripts/utils.js"></script>
    <script src="../scripts/salary_struct.js" defer></script>

</head>

<body>

    <?php
    include '../components/nav.php';
    ?>
    <div class="container">
        <div id="alertContainer" class="mt-3"></div>
        <div class="row mt-4">
            <div class="col-md-4">
                <div class=" d-flex justify-content-center align-items-center">
                    <div class="auth-form p-5">
                        <div class="bg-success p-5 mb-2">
                            <h4 class="mt-2 text-center text-white">Create Salary Structure</h4>
                        </div>

                        <form id="salaryForm" enctype="multipart/form-data">

                            <input type="hidden" id="id" name="id" />

                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </form>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="auth-form p-5">
                    <div class="bg-success p-3 mb-2 text-white">
                        <h4 class="m-2 text-center font-bold">Bulk Upload CSV</h4>
                    </div>
                    <form id="csvUploadForm" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="csv_file" class="form-label">Select CSV File</label>
                            <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv"
                                required>
                        </div>
                        <div class="mb-3">
                            <a href="../sample_csv/salary_struct_sample.csv" download="salary_struct_sample.csv" class="text-success">Download Sample CSV</a>
                        </div>
                        <button type="submit" class="btn btn-success">Upload</button>
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <div class="mt-5">
                    <div class="bg-success p-3">
                        <h4 class="text-center text-white"> <i> SALARY STRUCTURE </i></h4>
                    </div>
                    <table class="table table-responsive" id="structTable">
                        <thead>
                            <tr class="bg-success text-white">
                                <th>Name</th>
                                <th>Description</th>
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

        </div>
    </div>
</body>

</html>