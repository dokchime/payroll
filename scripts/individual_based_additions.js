const url = "../routes/individual_based_additions.php";

document.addEventListener("DOMContentLoaded", () => {
  const individualAdditionForm = document.getElementById("individualAdditionForm");
  const individualAdditionsTable = document
    .getElementById("individualAdditionsTable")
    .querySelector("tbody");
    const csvUploadForm = document.getElementById("csvUploadForm");
    const gradeSelect = document.getElementById("salary_structure_grades_id");

  function loadIndividualAdditions(page = 1) {
    fetch(`${url}?action=read&page=${page}`)
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
        individualAdditionsTable.innerHTML = "";
        data?.data?.forEach((addition) => {
          const row = document.createElement("tr");
          row.innerHTML = `
                        <td>${addition?.year}</td>
                        <td>${addition?.month}</td>              
                        <td>${addition?.staff_id}</td>
                        <td>${addition?.description}</td>
                        <td>${addition?.amount}</td>
                        <td>${addition?.is_active ? 'Yes' : 'No'}</td>
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
          alertContainer.innerHTML = `<div class="alert alert-success">Individual addition saved successfully!</div>`;
          loadIndividualAdditions();
        } else {
          alertContainer.innerHTML = `<div class="alert alert-danger">An error occurred while saving the individual addition.</div>`;
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
        document.getElementById("year").value = data?.year;
        document.getElementById("month").value = data?.month;
        document.getElementById("staff_id").value = data?.staff_id;
        document.getElementById("description").value = data?.description;
        document.getElementById("amount").value = data?.amount;
        document.getElementById("is_active").value = data?.is_active;
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
            alertContainer.innerHTML = `<div class="alert alert-success">Individual addition deleted successfully!</div>`;
            loadIndividualAdditions();
          } else {
            alertContainer.innerHTML = `<div class="alert alert-danger">Failed to delete the individual addition.</div>`;
          }
        });
    }
  };

  loadIndividualAdditions();
});
