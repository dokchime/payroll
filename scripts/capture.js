// const Fingerprint = window.Fingerprint
// console.log(Fingerprint)
const FingerprintSdk = (function () {
    function FingerprintSdk() {
        this.sdk = new Fingerprint.WebApi()

        this.sdk.onSamplesAcquired = function(s) {
            samplesAcquired(s)
        }
    }

    FingerprintSdk.prototype.getDeviceList = function () {
        return this.sdk.enumerateDevices()
    }

    FingerprintSdk.prototype.startCapture = function () {
        this.sdk.startAcquisition(Fingerprint.SampleFormat.PngImage).then(function () {
            console.log('Capturing fingerprint')
        }, function (error) {
            console.error('Error starting fingerprint capture:', error)
        })
    }

    FingerprintSdk.prototype.stopCapture = function () {
        this.sdk.stopAcquisition().then(function () {
            console.log('Fingerprint capture stopped')
        }, function (error) {
            console.error('Error stopping fingerprint capture:', error)
        })
    }

    return FingerprintSdk
})()

function samplesAcquired(s) {   
    // If sample acquired format is PNG, perform the following call on the object received 
    // Get samples from the object - get 0th element of samples as base 64 encoded PNG image         
    localStorage.setItem("imageSrc", "");                
    let samples = JSON.parse(s.samples); 
    window.alert(Fingerprint.b64UrlTo64(samples[0]))
    console.log(samples[0])           
    localStorage.setItem("imageSrc", "data:image/png;base64," + Fingerprint.b64UrlTo64(samples[0]));
    let vDiv = document.getElementById('imagediv');
    vDiv.innerHTML = "";
    let image = document.createElement("img");
    image.id = "image";
    image.src = localStorage.getItem("imageSrc");
    vDiv.appendChild(image);
}

// Initialize SDK
const fingerprintSdk = new FingerprintSdk();

// Attach event listeners to buttons
document.getElementById('startCapture').addEventListener('click', function() {
    fingerprintSdk.startCapture();
});

document.getElementById('stopCapture').addEventListener('click', function() {
    fingerprintSdk.stopCapture();
});

// module.exports = { FingerprintSdk, Fingerprint }