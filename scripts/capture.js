const captId = document.getElementById("captureFingerprint");
if (captId) {
  captId.addEventListener("click", function () {
    var scanner = new ActiveXObject("DPFPDevX.TypeLibrary");
    var capture = scanner.CreateCapture();
    console.log(capture)
    capture.OnCaptureComplete = function (captureEvent) {
      var fingerprintData = captureEvent.FingerprintData;
      sendToServer(fingerprintData);
    };
    capture.StartCapture();
  });
}

function sendToServer(fingerprintData) {
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "save_fingerprint.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      document.getElementById("result").innerText = xhr.responseText;
    }
  };
  xhr.send("fingerprintData=" + encodeURIComponent(fingerprintData));
}
