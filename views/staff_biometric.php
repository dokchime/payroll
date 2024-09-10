<!-- File: capture_biometric.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capture Staff Biometric</title>
    <?php require("./included.php"); ?>
    <script src="staff_biometric.js"></script> <!-- Link to your JavaScript file -->
    <!--<script src="../scripts/state_lga.js"></script>
    <script src="../scripts/min_loader.js"></script>
    <script src="../scripts/bank_loader.js"></script -->
    <script src="../scripts/staff_capturing.js" defer></script>
</head>

<body>
    <div class="container mt-5">

        <div class="card">
            <div class="card-header p-4 bg-success">
                <h4 class="text-center text-white"> Capture Staff Biometric Data</h4>
            </div>
            <div class="card-body">
                <div id="alertContainer" class="mt-3"></div>
                <h1></h1>
                <form id="biometricForm">
                    <label for="staffId">Staff ID:</label>
                    <input type="text" id="staffId" name="staff_id" required><br><br>

                    <button type="button" class="btn btn-success" id="captureFingerprint">Capture Fingerprints</button>
                </form>
</body>

</html>