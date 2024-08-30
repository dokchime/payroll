<!DOCTYPE html>
<html lang="en">

<head>
    <?php require("./included.php"); ?>
    <script src="../utils/notifier.js"></script>
    <script src="../scripts/utils.js"></script>
    <script src="../scripts/salary_structure_details.js" defer></script>
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
                        <h4 class="text-center font-bold">Create Salary Structure Detail</h4>
                    </div>

                    <form id="salaryStructureForm" enctype="multipart/form-data">
                        <input type="hidden" id="id" name="id">
                        <!-- <div class="mb-3">
                            <label for="struct_name" class="form-label">Salary Structure</label>
                            <select class="form-control" id="struct_name" name="struct_name" required>
                                <option value="">Select Salary Structure</option> -->
                                <!-- Options will be populated by JavaScript -->
                            <!-- </select>
                        </div> -->
                        <div class="mb-3">
                            <label for="salary_structure_grades_id" class="form-label">Salary Structure Grade</label>
                            <select class="form-select" id="salary_structure_grades_id" name="salary_structure_grades_id" required>
                                <option value="">Select Grade</option>
                                <!-- Options will be populated by JavaScript -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="annual_basic" class="form-label">Annual Basic</label>
                            <input type="text" class="form-control" id="annual_basic" name="annual_basic" required>
                        </div>
                        <div class="mb-3">
                            <label for="annual_gross" class="form-label">Annual Gross</label>
                            <input type="text" class="form-control" id="annual_gross" name="annual_gross" required>
                        </div>
                        <!-- <div class="mb-3">
                            <label for="annual_net" class="form-label">Annual Net</label>
                            <input type="text" class="form-control" id="annual_net" name="annual_net" required>
                        </div> -->
                        <div class="mb-3">
                            <label for="monthly_basic" class="form-label">Monthly Basic</label>
                            <input type="text" class="form-control" id="monthly_basic" name="monthly_basic" required>
                        </div>
                        <div class="mb-3">
                            <label for="monthly_gross" class="form-label">Monthly Gross</label>
                            <input type="text" class="form-control" id="monthly_gross" name="monthly_gross" required>
                        </div>
                        <!-- <div class="mb-3">
                            <label for="monthly_net" class="form-label">Monthly Net</label>
                            <input type="text" class="form-control" id="monthly_net" name="monthly_net" required>
                        </div> -->
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>

            <div class="col-md-6">
                <div class="auth-form p-5">
                    <div class="bg-success p-3 mb-2 text-white">
                        <h4 class="m-2 text-center font-bold">Upload Salary Structure Details CSV</h4>
                    </div>
                    <form id="csvUploadForm" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="csv_file" class="form-label">Select CSV File</label>
                            <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv" required>
                        </div>
                        <div class="mb-3">
                            <a href="../sample_csv/salary_structure_details_sample.csv" download="salary_structure_details_sample.csv" class="text-success">Download Sample CSV</a>
                        </div>
                        <button type="submit" class="btn btn-success">Upload</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <div class="bg-success p-3">
                <h4 class="text-center text-white"> <i> SALARY STRUCTURE DETAILS </i></h4>
            </div>
            <table class="table table-responsive" id="salaryStructureTable">
                <thead>
                    <tr class="bg-success text-white">
                        <th>Salary Structure Details</th>
                        <th>Annual Basic</th>
                        <th>Annual Gross</th>
                        <th>Monthly Basic</th>
                        <th>Monthly Gross</th>
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

    <script>
        /*document.addEventListener('DOMContentLoaded', function() {
            // Fetch salary structures and populate the struct_name dropdown
            fetch('/path/to/getSalaryStructures.php')
                .then(response => response.json())
                .then(data => {
                    const structNameSelect = document.getElementById('struct_name');
                    data.forEach(struct => {
                        const option = document.createElement('option');
                        option.value = struct.id;
                        option.textContent = struct.struct_name;
                        structNameSelect.appendChild(option);
                    });
                });

            // Fetch grades based on selected struct_name
            document.getElementById('struct_name').addEventListener('change', function() {
                const structId = this.value;
                if (!structId) {
                    document.getElementById('salary_structure_grades_id').innerHTML = '<option value="">Select Grade</option>';
                    return;
                }

                fetch(`/path/to/getGrades.php?salary_structure_id=${structId}`)
                    .then(response => response.json())
                    .then(data => {
                        const gradesSelect = document.getElementById('salary_structure_grades_id');
                        gradesSelect.innerHTML = '<option value="">Select Grade</option>'; // Clear previous options
                        data.forEach(grade => {
                            const option = document.createElement('option');
                            option.value = grade.id;
                            option.textContent = `${grade.grade_level} - ${grade.step}`;
                            gradesSelect.appendChild(option);
                        });
                    });
            });
        });*/
    </script>
</body>

</html>
