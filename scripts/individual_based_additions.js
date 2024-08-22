const url = "../routes/individual_additions.php";

document.addEventListener("DOMContentLoaded", () => {
  const individualAdditionForm = document.getElementById("individualAdditionForm");
  const individualAdditionsTable = document
    .getElementById("individualAdditionsTable")
    .querySelector("tbody");

  function loadIndividualAdditions(page = 1) {
    fetch(`${url}?action=read&page=${page}`)
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
        individualAdditionsTable.innerHTML = "";
        data?.data?.forEach((addition) => {
          const row = document.createElement("tr");
          row.innerHTML = `
                        <td>${addition?.staff_id}</td>
                        <td>${addition?.description}</td>
                        <td>${addition?.amount}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editIndividualAddition(${addition.id})">Update</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteIndividualAddition(${addition.id})">Delete</button>
                        </td>
                    `;
          individualAdditionsTable.appendChild(row);
        });
        updatePagination(data?.totalPages, page, loadIndividualAdditions);
      });
  }

  individualAdditionForm.addEventListener("submit", (event) => {
    event.preventDefault();

    const formData = new FormData(individualAdditionForm);
    const action = formData.get("id") ? "update" : "create";
    formData.append("action", action);

    fetch(url, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          individualAdditionForm.reset();
          showToast("Individual addition saved successfully!", "success");
          loadIndividualAdditions();
        } else {
          showToast(
            "An error occurred while saving the individual addition.",
            "danger"
          );
        }
      });
  });

  csvUploadForm.addEventListener("submit", (event) => {
    event.preventDefault();
    const formData = new FormData(csvUploadForm);
    formData.append("action", "bulkUpload");

    fetch(url, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        const alertContainer = document.getElementById("alertContainer");
        if (data.success) {
          csvUploadForm.reset();
          loadIndividualAdditions();
          alertContainer.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
        } else {
          alertContainer.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
        }
      });
  });

  window.editIndividualAddition = function (id) {
    fetch(`${url}?action=read&id=${id}`)
      .then((response) => response.json())
      .then((data) => {
        document.getElementById("id").value = data?.id;
        document.getElementById("staff_id").value = data?.staff_id;
        document.getElementById("description").value = data?.description;
        document.getElementById("amount").value = data?.amount;
      });
  };

  window.deleteIndividualAddition = function (id) {
    if (confirm("Are you sure you want to delete this individual addition?")) {
      fetch(url, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          id: id,
          action: "delete",
        }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            showToast("Individual addition deleted successfully!", "success");
            loadIndividualAdditions();
          } else {
            showToast("Failed to delete the individual addition.", "danger");
          }
        });
    }
  };

  loadIndividualAdditions();
});
