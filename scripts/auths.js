const url = "./routes/auths.php";
document.addEventListener("DOMContentLoaded", function () {
  const loginForm = document.getElementById("loginForm");

  if (loginForm) {
    loginForm.addEventListener("submit", function (e) {
      e.preventDefault();

      let formData = new FormData(this);
      formData.append("action", "login");

      fetch(url, {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.status === "success") {
            alert("Login successful!");
            showToast("Login successful!", "success");
            window.location.href = "./views/dashboard.php";
          } else {
            alert(result.message);
          }
        })
        .catch((error) => {
          showToast(`An error occurred: ${error?.message}`, "danger");
          console.error("Error:", error);
        });
    });
  }

  if (registerForm) {
    registerForm.addEventListener("submit", function (e) {
      e.preventDefault();
      const formData = new FormData(this);
      formData.append("action", "register");

      fetch(url, {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.status === "success") {
            alert("Registration successful!");
            window.location.href = "index.php";
          } else {
            alert(data.message);
          }
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    });
  }
});
