const url = "../routes/individual_based_deductions.php";

document.addEventListener("DOMContentLoaded", () => {
  const individualDeductionForm = document.getElementById("deductionForm");
  const individualDeductionsTable = document.getElementById("deductionTable").querySelector("tbody");
  const csvUploadForm = document.getElementById("csvUploadForm");
  const gradeSelect = document.getElementById("salary_structure_grades_id");

  function loadIndividualDeductions(page = 1) {
    fetch(`${url}?action=read&page=${page}`)
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
        individualDeductionsTable.innerHTML = "";
        data?.data?.forEach((deduction) => {
          const row = document.createElement("tr");
          row.innerHTML = `
                        <td>${deduction?.year}</td>
                        <td>${deduction?.month}</td>              
                        <td>${deduction?.staff_id}</td>
                        <td>${deduction?.description}</td>
                        <td>${deduction?.amount}</td>
                        <td>${deduction?.is_active ? 'Yes' : 'No'}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editIndividualDeduction(${deduction.id})">Update</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteIndividualDeduction(${deduction.id})">Delete</button>
                        </td>
                    `;
            individualDeductionsTable.appendChild(row);
        });
        updatePagination(data?.totalPages, page, loadIndividualDeductions);
      });
  }

  individualDeductionForm.addEventListener("submit", (event) => {
    event.preventDefault();

    const formData = new FormData(individualDeductionForm);
    const action = formData.get("id") ? "update" : "create";
    formData.append("action", action);

    fetch(url, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          individualDeductionForm.reset();
          alertContainer.innerHTML = `<div class="alert alert-success">Individual deduction saved successfully!</div>`;
          loadIndividualDeductions();
        } else {
          alertContainer.innerHTML = `<div class="alert alert-danger">An error occurred while saving the individual deduction.</div>`;
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
          loadIndividualDeductions();
          alertContainer.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
        } else {
          alertContainer.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
        }
      });
  });

  window.editIndividualDeduction = function (id) {
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

  window.deleteIndividualDeduction = function (id) {
    if (confirm("Are you sure you want to delete this individual deduction?")) {
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
            alertContainer.innerHTML = `<div class="alert alert-success">Individual deduction deleted successfully!</div>`;
            loadIndividualDeductions();
          } else {
            alertContainer.innerHTML = `<div class="alert alert-danger">Failed to delete the individual deduction.</div>`;
          }
        });
    }
  };

  loadIndividualDeductions();
});
