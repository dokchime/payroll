const url = "../routes/grade_based_deductions.php";

document.addEventListener("DOMContentLoaded", () => {
  const deductionForm = document.getElementById("deductionForm");
  const deductionsTable = document
    .getElementById("deductionsTable")
    .querySelector("tbody");
    const csvUploadForm = document.getElementById("csvUploadForm");
    const gradeSelect = document.getElementById("salary_structure_grades_id");

  function loadDeductions(page = 1) {
    fetch(`${url}?action=read&page=${page}`)
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
        deductionsTable.innerHTML = "";
        data?.data?.forEach((deduction) => {
          const row = document.createElement("tr");
          row.innerHTML = `
                        <td>${deduction?.year}</td>
                        <td>${deduction?.month}</td>
                        <td>${deduction?.ss_struct_name}</td>
                        <td>${deduction?.gbd_description}</td>
                        <td>${deduction?.amount}</td>
                        <td>${deduction?.is_active ? "Yes" : "No"}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editDeduction(${deduction.gbd_id})">Update</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteDeduction(${deduction.gbd_id})">Delete</button>
                        </td>
                    `;
          deductionsTable.appendChild(row);
        });
        updatePagination(data?.totalPages, page, loadDeductions);
      });
  }

  function loadSalaryStructuresDropdown() {
    fetch('../routes/grade_based_deductions.php?action=read2')  // Endpoint to get salary structures
      .then(response => response.json())
      .then(data => {
        gradeSelect.innerHTML = '<option value="">Select Salary Structure Grade and Step</option>';
        data.forEach(struct => {
          const option = document.createElement('option');
          option.value = struct.ssg_id;
          option.textContent = struct.ss_struct_name;
          gradeSelect.appendChild(option);
        });
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
          alertContainer.innerHTML = `<div class="alert alert-success">Deduction saved successfully!</div>`;
          loadDeductions();
        } else {
          alertContainer.innerHTML = `<div class="alert alert-danger">An error occurred while saving the deduction.</div>`;
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
        document.getElementById("year").value = data?.year;
        document.getElementById("month").value = data?.month;
        gradeSelect.value = data?.salary_structure_grades_id;
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
            alertContainer.innerHTML = `<div class="alert alert-success">Deduction deleted successfully!</div>`;
            loadDeductions();
          } else {
            alertContainer.innerHTML = `<div class="alert alert-danger">Failed to delete the deduction.</div>`;
          }
        });
    }
  };

  loadDeductions();
  loadSalaryStructuresDropdown();
});
