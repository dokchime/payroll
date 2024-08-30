<!DOCTYPE html>
<html lang="en">

<head>
    <?php require("./included.php"); ?>
    <script src="../utils/notifier.js"></script>
    <script src="../scripts/utils.js"></script>
    <script src="../scripts/individual_based_deductions.js" defer></script>
</head>

<body>
    <?php require("../utils/notifier.php"); ?>
    <?php //require("../session/isloggedin.php"); ?>
    <div class="container">
        <div id="alertContainer" class="mt-3"></div>
        <div class="row d-flex">

            <div class="col-md-6">
                <div class="auth-form p-5">
                    <div class="bg-success p-3 mb-2 text-white">
                        <h4 class="text-center font-bold">Create Individual Based Deduction</h4>
                    </div>

                    <form id="deductionForm" enctype="multipart/form-data">
                        <input type="hidden" id="id" name="id">
                        <div class="mb-3">
                            <label for="year" class="form-label">Year</label>
                            <input type="text" class="form-control" id="year" name="year" required>
                        </div>
                        <div class="mb-3">
                            <label for="month" class="form-label">Month</label>
                            <input type="text" class="form-control" id="month" name="month" required>
                        </div>
                        <div class="mb-3">
                            <label for="staff_id" class="form-label">Staff ID</label>
                            <input type="text" class="form-control" id="staff_id" name="staff_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="is_active" class="form-label">Active</label>
                            <select class="form-control" id="is_active" name="is_active" required>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>

            <div class="col-md-6">
                <div class="auth-form p-5">
                    <div class="bg-success p-3 mb-2 text-white">
                        <h4 class="m-2 text-center font-bold">Upload Individual Deduction CSV</h4>
                    </div>
                    <form id="csvUploadForm" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="csv_file" class="form-label">Select CSV File</label>
                            <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv" required>
                        </div>
                        <div class="mb-3">
                            <a href="../sample_csv/individual_based_deductions_sample.csv" download="individual_based_deductions_sample.csv" class="text-success">Download Sample CSV</a>
                        </div>
                        <button type="submit" class="btn btn-success">Upload</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <div class="bg-success p-3">
                <h4 class="text-center text-white"> <i> INDIVIDUAL BASED DEDUCTIONS </i></h4>
            </div>
            <table class="table table-responsive" id="deductionTable">
                <thead>
                    <tr class="bg-success text-white">
                        <th>Year</th>
                        <th>Month</th>    
                        <th>Staff ID</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Active</th>
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
