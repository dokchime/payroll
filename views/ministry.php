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

        <div class="auth-form">
            <h4 class="mt-2 text-center">Ministry Management</h4>
            <div id="alertContainer" class="mt-3"></div>
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

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

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