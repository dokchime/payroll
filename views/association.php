<!DOCTYPE html>
<html lang="en">

<head>
    <?php require("./included.php"); ?>
    <script src="../utils/notifier.js"></script>
    <script src="../scripts/utils.js"></script>
    <script src="../scripts/association.js" defer></script>
</head>

<body>
    <?php require("../utils/notifier.php"); ?>
    <?php require("../session/isloggedin.php"); ?>
    <div class="container">
        <div id="alertContainer" class="mt-3"></div>
        <div class="row d-flex">

            <div class="col-md 6">
                <div class="auth-form p-5">
                    <div class="bg-success p-3 mb-2 text-white">
                        <h4 class=" text-center font-bold">Create Association</h4>
                    </div>

                    <form id="associationForm" enctype="multipart/form-data">
                        <input type="hidden" id="id" name="id">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="dues_type" class="form-label">Dues Type</label>
                            <select class="form-control" id="dues_type" name="dues_type" required>
                                <option value="fixed">Fixed</option>
                                <option value="percentage">Percentage</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="fixed_amount" class="form-label">Fixed Amount</label>
                            <input type="number" class="form-control" id="fixed_amount" name="fixed_amount" step="0.01">
                        </div>
                        <div class="mb-3">
                            <label for="percentage_of_gross" class="form-label">Percentage of Gross</label>
                            <input type="number" class="form-control" id="percentage_of_gross" name="percentage_of_gross" step="0.01">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>


            <div class="col-md-6">
                <div class="auth-form p-5">
                    <div class="bg-success p-3 mb-2 text-white">
                        <h4 class="m-2 text-center font-bold">Upload Association CSV</h4>
                    </div>
                    <form id="csvUploadForm" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="csv_file" class="form-label">Select CSV File</label>
                            <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv"
                                required>
                        </div>
                        <div class="mb-3">
                            <a href="../sample_csv/association_sample.csv" download="association_sample.csv" class="text-success">Download Sample CSV</a>
                        </div>
                        <button type="submit" class="btn btn-success">Upload</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <div class="bg-success p-3">
                <h4 class="text-center text-white"> <i> ASSOCIATION </i></h4>
            </div>
            <table class="table table-responsive" id="associationTable">
                <thead>
                    <tr class="bg-success text-white">
                        <th>Name</th>
                        <th>Description</th>
                        <th>Dues Type</th>
                        <th>Fixed Amount</th>
                        <th>Percentage of Gross</th>
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