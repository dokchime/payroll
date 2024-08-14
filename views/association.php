<!DOCTYPE html>
<html lang="en">

<head>
    <?php require("./included.php"); ?>
    <script src="../utils/notifier.js"></script>
    <script src="../scripts/association.js" defer></script>
</head>

<body>
    <?php require("../utils/notifier.php"); ?>
    <div class="container">
        <div class=" d-flex m-4 justify-content-center align-items-center">
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
        </div>
    </div>
</body>

</html>