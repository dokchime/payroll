<!DOCTYPE html>
<html lang="en">

<head>

    <?php require("./included.php"); ?>
    <script src="../scripts/state_lga.js"></script>
    <script src="../scripts/min_loader.js"></script>
    <script src="../scripts/bank_loader.js"></script>
    <script src="../scripts/staff_capturing.js" defer></script>

</head>

<body>
    <div class="container mt-5">

        <div class="card">
            <div class="card-header p-4 bg-success">
                <h4 class="text-center text-white"> Staff Data Capturing Registration</h4>
            </div>
            <div class="card-body">
                <div id="alertContainer" class="mt-3"></div>
                <form id="registrationForm">
                    <!-- Step 1: Personal Information -->
                    <h4> Personal Information</h4>
                    <div class="form-step">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="staff_id" class="form-label">Staff ID</label>
                                    <input type="text" class="form-control" id="staff_id" name="staff_id" required>
                                </div>
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <select id="title" name="title" class="form-select">
                                        <option value="">Select Title</option>
                                        <option value="Mr">Mr</option>
                                        <option value="Mrs">Mrs</option>
                                        <option value="Miss">Miss</option>
                                        <option value="Mal">Mal</option>
                                        <option value="Prof">Prof</option>
                                        <option value="Dr">Dr</option>
                                        <option value="Hon">Hon</option>
                                        <option value="Haj">Haj</option>
                                        <option value="Alh">Alh</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">FirstName</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="surname" class="form-label">SURNAME</label>
                                    <input type="text" class="form-control" id="surname" name="surname" required>
                                </div>
                                <div class="mb-3">
                                    <label for="middle_name" class="form-label">MIDDLE-NAME</label>
                                    <input type="text" class="form-control" id="middle_name" name="middle_name" required>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="state" class="form-label">State</label>
                                    <select id="state" name="state" class="form-select">
                                        <option value="">Select State</option>
                                        <!-- Options will be loaded dynamically -->
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="local_govt" class="form-label">Local Government</label>
                                    <select id="local_govt" name="local_govt" class="form-select">
                                        <option value="">Select Local Government</option>
                                        <!-- Options will be loaded dynamically -->
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="sex" class="form-label">Gender</label>
                                    <select id="sex" name="sex" class="form-select">
                                        <option value="">Select Title</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="phone_number" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                                </div>
                                <div class="mb-3">
                                    <label for="date_of_birth" class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary" id="nextStep">Next</button>
                    </div>

                    <!-- Step 2: Employment Information -->
                    <div class="form-step" style="display:none;">
                        <div class="row">
                            <div class="col-md-6">

                                <div class="mb-3">
                                    <label for="rank" class="form-label">Rank</label>
                                    <input type="text" class="form-control" id="rank" name="rank" required>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select id="status" name="status" class="form-select">
                                        <option value="">Select Status</option>
                                        <option value="Contract">Contract</option>
                                        <option value="Temporary">Temporary</option>
                                        <option value="Permanent">Permanent</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="grade_level" class="form-label">Grade Level</label>
                                    <input type="text" class="form-control" id="grade_level" name="grade_level" required>
                                </div>
                                <div class="mb-3">
                                    <label for="step" class="form-label">Step</label>
                                    <input type="number" class="form-control" id="rank" name="step" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="minist_parast_id" class="form-label">Ministry</label>
                                    <select id="minist_parast_id" name="minist_parast_id" class="form-select">
                                        <option value="">Select Ministry</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="date_of_employment" class="form-label">Date of Employment</label>
                                    <input type="date" class="form-control" id="date_of_employment" name="date_of_employment" required>
                                </div>
                                <div class="mb-3">
                                    <label for="date_of_resign" class="form-label">Date of Resignation</label>
                                    <input type="date" class="form-control" id="date_of_resign" name="date_of_resign" required>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary" id="prevStep">Previous</button>
                        <button type="button" class="btn btn-primary" id="nextStep2">Next</button>
                    </div>

                    <!-- Step 3: Account Information -->
                    <div class="form-step" style="display:none;">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="acc_number" class="form-label">Account Number</label>
                                <input type="text" class="form-control" id="acc_number" name="acc_number" required>
                            </div>
                            <div class="mb-3">
                                <!-- <label for="bank_id" class="form-label">Bank ID</label>
                            <input type="text" class="form-control" id="bank_id" name="bank_id" required> -->

                                <label for="bank_id" class="form-label">Bank</label>
                                <select id="bank_id" name="bank_id" class="form-select">
                                    <option value="">Select Bank</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                        <button type="button" class="btn btn-secondary" id="prevStep2">Previous</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</body>

</html>