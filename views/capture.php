<!DOCTYPE html>
<html lang="en">

<head>
    <?php require("./included.php"); ?>
    <script src="../utils/notifier.js"></script>
    <script src="../scripts/utils.js"></script>
    <script src="../websdk/fingerprint.sdk.min.js"></script>
    <script src="../websdk/websdk.client.bundle.min.js"></script>

</head>

<body>

    <div class="d-flex flex-row justify-content-center align-items-center mt-5">
        <div id="imagediv" class="border border-4 border-success " ></div>

    </div>

    <div class="d-flex flex-row justify-content-center align-items-center mt-5">
        <button id="startCapture" class="btn btn-success">Start Capture</button>
        <button id="stopCapture" class="btn btn-danger mx-5">Stop Capture</button>
    </div>

    <!-- Include the necessary Fingerprint SDK scripts if available locally or via CDN -->
    <!-- <script src="path_to_fingerprint_sdk.js"></script> -->
    <script src="../scripts/capture.js"></script>
</body>

</html>