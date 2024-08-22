<!DOCTYPE html>
<html lang="en">

<head>
    <?php require("./included.php"); ?>
    <script src="../utils/notifier.js"></script>
    <script src="../scripts/utils.js"></script>
    <script src="../scripts/salary_schedule.js" defer></script>
</head>

<body>
    <?php require("../utils/notifier.php"); ?>
    <div class="container">
        <div id="alertContainer" class="mt-3"></div>
        <div class="row d-flex">

            <div class="col-md-6">
                <div class="auth-form p-5">
                    <div class="bg-success p-3 mb-2 text-white">
                        <h4 class="text-center font-bold">Create Salary Schedule</h4>
                    </div>

                    <form id="salaryScheduleForm" enctype="multipart/form-data" method="POST" action="process_salary_schedule.php">
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
                            <label for="salary_structure_grades_id" class="form-label">Salary Structure Grade ID</label>
                            <select class="form-select" id="salary_structure_grades_id" name="salary_structure_grades_id" required>
                                <!-- Options will be populated by JavaScript -->
                            </select>

                        </div>

                        <div class="mb-3">
                            <label for="staff_id" class="form-label">Staff ID</label>
                            <input type="text" class="form-control" id="staff_id" name="staff_id" required>
                        </div>

                        <div class="mb-3">
                            <label for="grade_based_additions" class="form-label">Grade Based Additions</label>
                            <input type="text" class="form-control" id="grade_based_additions" name="grade_based_additions" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="grade_based_deductions" class="form-label">Grade Based Deductions</label>
                            <input type="text" class="form-control" id="grade_based_deductions" name="grade_based_deductions" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="individual_based_additions" class="form-label">Individual Based Additions</label>
                            <input type="text" class="form-control" id="individual_based_additions" name="individual_based_additions" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="individual_based_deductions" class="form-label">Individual Based Deductions</label>
                            <input type="text" class="form-control" id="individual_based_deductions" name="individual_based_deductions" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="net_take_home_pay" class="form-label">Net Take Home Pay</label>
                            <input type="text" class="form-control" id="net_take_home_pay" name="net_take_home_pay" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="due_date" class="form-label">Due Date</label>
                            <input type="text" class="form-control" id="due_date" name="due_date" required>
                        </div>

                        <div class="mb-3">
                            <label for="is_active" class="form-label">Is Active</label>
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
                        <h4 class="m-2 text-center font-bold">Upload Salary Schedule CSV</h4>
                    </div>
                    <form id="csvUploadForm" enctype="multipart/form-data" method="POST" action="upload_salary_schedule.php">
                        <div class="mb-3">
                            <label for="csv_file" class="form-label">Select CSV File</label>
                            <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv" required>
                        </div>
                        <div class="mb-3">
                            <a href="../sample_csv/monthly_pay_schedule_sample.csv" download="monthly_pay_schedule_sample.csv" class="text-success">Download Sample CSV</a>
                        </div>
                        <button type="submit" class="btn btn-success">Upload</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <div class="bg-success p-3">
                <h4 class="text-center text-white"> <i> SALARY SCHEDULE </i></h4>
            </div>
            <table class="table table-responsive" id="salaryScheduleTable">
                <thead>
                    <tr class="bg-success text-white">
                        <th>Year</th>
                        <th>Month</th>
                        <th>Salary Structure Grade ID</th>
                        <th>Staff ID</th>
                        <th>Grade Based Additions</th>
                        <th>Grade Based Deductions</th>
                        <th>Individual Based Additions</th>
                        <th>Individual Based Deductions</th>
                        <th>Net Take Home Pay</th>
                        <th>Due Date</th>
                        <th>Is Active</th>
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
