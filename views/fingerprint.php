<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fingerprint Registration and Verification</title>
    <script src="fingerprint.js" defer></script>
</head>

<body>
    <h1>Fingerprint Registration and Verification</h1>

    <h2>Register</h2>
    <form id="register-form">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="fullname">Full Name:</label>
        <input type="text" id="fullname" name="fullname" required><br>
        <button type="button" id="register-button">Register</button>
    </form>

    <h2>Verify</h2>
    <form id="verify-form">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        <button type="button" id="verify-button">Verify</button>
    </form>
</body>

</html>