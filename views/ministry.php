<!DOCTYPE html>
<html lang="en">

<head>

    <head>
        <?php require("./included.php"); ?>
        <script src="../scripts/utils.js"></script>
        <script src="../scripts/ministry.js" defer></script>
    </head>
</head>

<body>
    <div class="container mt-5">

        <div id="alertContainer" class="mt-3"></div>
        <div class="row">
            <div class="col-md-6">
                <div class="auth-form">
                    <div class="bg-success p-5">
                        <h4 class="mt-2 text-center text-white">Ministry Management</h4>
                    </div>
                    <form id="ministryForm" enctype="multipart/form-data">
                        <!-- <input type="hidden" id="action" name="action" value="create"> -->
                        <input type="hidden" id="id" name="id">
                        <div class="mb-3">
                            <label for="name" class="form-label">Ministry Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>

                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="auth-form p-5">
                    <div class="bg-success p-3 mb-2 text-white">
                        <h4 class="m-2 text-center font-bold">Upload Ministry CSV</h4>
                    </div>
                    <form id="csvUploadForm" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="csv_file" class="form-label">Select CSV File</label>
                            <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv"
                                required>
                        </div>
                        <div class="mb-3">
                            <a href="../sample_csv/ministry_parast_sample.csv" download="ministry_parast_sample.csv" class="text-success">Download Sample CSV</a>
                        </div>
                        <button type="submit" class="btn btn-success">Upload</button>
                    </form>
                </div>
            </div>

        </div>

        <h2 class="mt-5">Ministry List</h2>
        <table class="table table-responsive table-striped table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="ministryList"></tbody>
        </table>
        <!-- Pagination Buttons -->
        <div id="pagination" class="d-flex justify-content-center mt-4"></div>
    </div>

</body>

</html>