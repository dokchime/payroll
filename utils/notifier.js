
function showToast(message, type) {
    const toastContainer = document.getElementById("toastPlacement");
    const toastHTML = `
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
          <div class="toast-header">
            <strong class="me-auto">${
              type === "success" ? "Success" : "Error"
            }</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
          <div class="toast-body text-${type}">
            ${message}
          </div>
        </div>
      `;
  
    const toastElement = document.createElement("div");
    toastElement.innerHTML = toastHTML;
    toastContainer.appendChild(toastElement.firstChild);
  
    // const toast = new bootstrap.Toast(toastContainer.lastChild);
    // toast.show();
  }
  