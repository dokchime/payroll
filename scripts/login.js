const url = './routes/login.php';

$(document).ready(function () {
    const loginForm = document.getElementById("loginForm");

    if (loginForm) {
        loginForm.addEventListener("submit", function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            formData.append("action", "login");

            $.ajax({
                url,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    let result = JSON.parse(response);
                    if (result.status === 'success') {
                        alert(result.message);
                        window.location.href = result.redirect; // Redirect based on server response
                    } else {
                        alert(result.message);
                    }
                }
            });
        });
    }
});
