// File: fingerprint.js

document.addEventListener('DOMContentLoaded', function () {
    const captureButton = document.getElementById('captureFingerprint');

    captureButton.addEventListener('click', function () {
        // Assuming the SDK provides a method to capture fingerprints
        const thumbfingerData = fingerprintSDK.captureFingerprint();
        const indexfingerData = fingerprintSDK.captureFingerprint();

        // Send fingerprint data to the server
        const staffId = document.getElementById('staffId').value;

        fetch('routes.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'captureBiometric',
                staff_id: staffId,
                thumbfingerData: thumbfingerData,
                indexfingerData: indexfingerData,
            }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Biometric data captured successfully.');
            } else {
                alert('Failed to capture biometric data.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred.');
        });
    });
});
