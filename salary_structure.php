<!DOCTYPE html>
<html lang="en">

<head>

    <?php require("./included.php"); ?>
    <script src="./scripts/salary.js" defer></script>

</head>

<body>
    <div class="container">
        <div class=" d-flex m-4 justify-content-center align-items-center">
            <div class="auth-form p-5">
                <h4 class="mt-2 text-center">Create Salary Structure</h4>

                <form id="salaryForm" enctype="multipart/form-data">
                    
                    <input type="hidden" id="id" name="id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="highest_grad_level" class="form-label">Highest Grade Level</label>
                        <input type="text" class="form-control" id="highest_grad_level" name="highest_grad_level" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="min_step" class="form-label">Minimun Step</label>
                        <input type="text" class="form-control" id="min_step" name="min_step" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>
        </div>
    </div>

</body>

</html>