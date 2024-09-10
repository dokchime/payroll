<?php require("../session/isloggedin.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require("./included.php"); ?>
    <script src="../scripts/utils.js"></script>
    <script src="../scripts/banks.js" defer></script>
</head>

<body>
    <?php
    include '../components/nav.php';

    ?>
    <div class="container">
        <div class="row m-4 justify-content-center">
            <!-- Form for Adding Single Bank Record -->
            <div class="col-md-6">
                <div class="auth-form p-5">
                    <div class="bg-success p-3 mb-2 text-white">
                        <h4 class="m-2 text-center font-bold">Create Bank</h4>
                    </div>
                    <form id="bankForm" enctype="multipart/form-data">
                        <input type="hidden" id="id" name="id">
                        <div class="mb-3">
                            <label for="bank_name" class="form-label">Bank Name</label>
                            <input type="text" class="form-control" id="bank_name" name="bank_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="sort_code" class="form-label">Sort Code</label>
                            <input type="text" class="form-control" id="sort_code" name="sort_code" required>
                        </div>
                        <button type="submit" class="btn btn-success">Add Bank</button>
                    </form>
                </div>
            </div>

            <!-- Form for Bulk Upload using CSV -->
            <div class="col-md-6">
                <div class="auth-form p-5">
                    <div class="bg-success p-3 mb-2 text-white">
                        <h4 class="m-2 text-center font-bold">Upload Banks CSV</h4>
                    </div>
                    <form id="csvUploadForm" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="csv_file" class="form-label">Select CSV File</label>
                            <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv"
                                required>
                        </div>
                        <div class="mb-3">
                            <a href="../sample_csv/banks_sample.csv" download="banks_sample.csv"
                                class="text-success">Download Sample CSV</a>
                        </div>
                        <button type="submit" class="btn btn-success">Upload</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table for Displaying Bank Records -->
        <div class="mt-5">
            <div class="bg-success p-3 mb-2 text-white">
                <h4 class="text-center">Manage Banks</h4>
            </div>
            <table class="table table-responsive table-bordered" id="bankTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Bank Name</th>
                        <th>Sort Code</th>
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

</body>

</html>