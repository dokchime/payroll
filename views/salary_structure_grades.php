<?php require("../session/isloggedin.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require("./included.php"); ?>
    <script src="../utils/notifier.js"></script>
    <script src="../scripts/utils.js"></script>
    <script src="../scripts/salary_structure_grades.js" defer></script>
</head>

<body>
    <?php require("../utils/notifier.php"); 
    include '../components/nav.php';
    ?>
    <div class="container">
        <div id="alertContainer" class="mt-3"></div>
        <div class="row d-flex">

            <div class="col-md-6">
                <div class="auth-form p-5">
                    <div class="bg-success p-3 mb-2 text-white">
                        <h4 class="text-center font-bold">Create Salary Structure Grade</h4>
                    </div>

                    <form id="salaryStructureForm" enctype="multipart/form-data">
                        <input type="hidden" id="id" name="id">
                        <div class="mb-3">
                            <label for="struct_name" class="form-label">Salary Structure</label>
                            <select class="form-select" id="struct_name" name="struct_name" required>
                                <option value="">Select Salary Structure</option>
                                <!-- Options will be populated by JavaScript -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="grade_level" class="form-label">Grade Level</label>
                            <input type="number" class="form-control" id="grade_level" name="grade_level" required>
                        </div>
                        <div class="mb-3">
                            <label for="step" class="form-label">Step</label>
                            <input type="number" class="form-control" id="step" name="step" required>
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>

            <div class="col-md-6">
                <div class="auth-form p-5">
                    <div class="bg-success p-3 mb-2 text-white">
                        <h4 class="m-2 text-center font-bold">Upload Salary Structure Grades CSV</h4>
                    </div>
                    <form id="csvUploadForm" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="csv_file" class="form-label">Select CSV File</label>
                            <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv" required>
                        </div>
                        <div class="mb-3">
                            <a href="../sample_csv/salary_structure_grades_sample.csv" download="salary_structure_grades_sample.csv" class="text-success">Download Sample CSV</a>
                        </div>
                        <button type="submit" class="btn btn-success">Upload</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <div class="bg-success p-3">
                <h4 class="text-center text-white"> <i> SALARY STRUCTURE GRADES </i></h4>
            </div>
            <table class="table table-responsive" id="salaryStructureTable">
                <thead>
                    <tr class="bg-success text-white">
                        <th>Salary Structure</th>
                        <th>Grade Level</th>
                        <th>Step</th>
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
