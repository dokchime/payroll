const url = "../routes/individual_based_deductions.php";

document.addEventListener("DOMContentLoaded", () => {
  const deductionForm = document.getElementById("deductionForm");
  const deductionTable = document.getElementById("deductionTable").querySelector("tbody");

  // Load Salary Structure Grades for the select field
  function loadSalaryStructureGrades() {
    fetch("../routes/salary_structure_grades.php?action=getGrades")
      .then((response) => response.json())
      .then((data) => {
        const salaryStructureGradeSelect = document.getElementById("salary_structure_grade");
        salaryStructureGradeSelect.innerHTML = "";
        data.forEach((grade) => {
          const option = document.createElement("option");
          option.value = grade.id;
          option.text = `${grade.struct_name} - Level ${grade.grade_level}, Step ${grade.step}`;
          salaryStructureGradeSelect.appendChild(option);
        });
      });
  }

  loadSalaryStructureGrades();

  function loadDeductions(page = 1) {
    fetch(`${url}?action=read&page=${page}`)
      .then((response) => response.json())
      .then((data) => {
        deductionTable.innerHTML = "";
        data?.data?.forEach((deduction) => {
          const row = document.createElement("tr");
          row.innerHTML = `
            <td>${deduction?.staff_id}</td>
            <td>${deduction?.salary_structure_grade}</td>
            <td>${deduction?.description}</td>
            <td>${deduction?.amount}</td>
            <td>${deduction?.is_active ? "Yes" : "No"}</td>
            <td>
              <button class="btn btn-warning btn-sm" onclick="editDeduction(${deduction.id})">Update</button>
              <button class="btn btn-danger btn-sm" onclick="deleteDeduction(${deduction.id})">Delete</button>
            </td>
          `;
          deductionTable.appendChild(row);
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
          showToast("An error occurred while saving the deduction.", "danger");
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
        document.getElementById("staff_id").value = data?.staff_id;
        document.getElementById("salary_structure_grade").value = data?.salary_structure_grade_id;
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
            showToast("An error occurred while deleting the deduction.", "danger");
          }
        });
    }
  };

  loadDeductions();
});

function updatePagination(totalPages, currentPage, callback) {
  const paginationDiv = document.getElementById("pagination");
  paginationDiv.innerHTML = "";

  for (let i = 1; i <= totalPages; i++) {
    const button = document.createElement("button");
    button.textContent = i;
    button.classList.add("btn", "btn-primary", "mx-1");
    if (i === currentPage) button.classList.add("active");
    button.addEventListener("click", () => callback(i));
    paginationDiv.appendChild(button);
  }
}
