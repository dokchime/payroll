document.addEventListener('DOMContentLoaded', function () {
  const loginForm = document.getElementById("loginForm");

  if (loginForm) {
      loginForm.addEventListener("submit", function (e) {
          e.preventDefault();
          
          let formData = new FormData(this);
          formData.append("action", "login");

          fetch('./routes/user_route.php', {
              method: 'POST',
              body: formData
          })
          .then(response => response.json())
          .then(result => {
              if (result.status === 'success') {
                  alert(result.message);
                  window.location.href = result.redirect; // Redirect based on server response
              } else {
                  alert(result.message);
              }
          })
          .catch(error => {
              console.error('Error:', error);
              alert('An error occurred while processing your request.');
          });
      });
  }
});
