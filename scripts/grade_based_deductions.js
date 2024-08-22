const url = "../routes/grade_based_deductions.php";

document.addEventListener("DOMContentLoaded", () => {
  const deductionForm = document.getElementById("deductionForm");
  const deductionsTable = document
    .getElementById("deductionsTable")
    .querySelector("tbody");

  function loadDeductions(page = 1) {
    fetch(`${url}?action=read&page=${page}`)
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
        deductionsTable.innerHTML = "";
        data?.data?.forEach((deduction) => {
          const row = document.createElement("tr");
          row.innerHTML = `
                        <td>${deduction?.salary_structure_grades_id}</td>
                        <td>${deduction?.description}</td>
                        <td>${deduction?.amount}</td>
                        <td>${deduction?.is_active ? "Yes" : "No"}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editDeduction(${deduction.id})">Update</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteDeduction(${deduction.id})">Delete</button>
                        </td>
                    `;
          deductionsTable.appendChild(row);
        });
        updatePagination(data?.totalPages, page, loadDeductions);
      });
  }

  deductionForm.addEventListener("submit", (event) => {
    event.preventDefault();

    const formData = new FormData(deductionForm);
    const action = formData.get("id") ? "update" : "create";
    formData.append("action", action);

    fetch(url, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          deductionForm.reset();
          showToast("Deduction saved successfully!", "success");
          loadDeductions();
        } else {
          showToast(
            "An error occurred while saving the deduction.",
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
          loadDeductions();
          alertContainer.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
        } else {
          alertContainer.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
        }
      });
  });

  window.editDeduction = function (id) {
    fetch(`${url}?action=read&id=${id}`)
      .then((response) => response.json())
      .then((data) => {
        document.getElementById("id").value = data?.id;
        document.getElementById("salary_structure_grades_id").value =
          data?.salary_structure_grades_id;
        document.getElementById("description").value = data?.description;
        document.getElementById("amount").value = data?.amount;
        document.getElementById("is_active").value = data?.is_active;
      });
  };

  window.deleteDeduction = function (id) {
    if (confirm("Are you sure you want to delete this deduction?")) {
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
            showToast("Deduction deleted successfully!", "success");
            loadDeductions();
          } else {
            showToast("Failed to delete the deduction.", "danger");
          }
        });
    }
  };

  loadDeductions();
});
