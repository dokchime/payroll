const url = "../routes/salary_structure_grades.php";
const salaryStructureSelect = document.getElementById("struct_name");

document.addEventListener("DOMContentLoaded", () => {
  const salaryStructureForm = document.getElementById("salaryStructureForm");
  const salaryStructureTable = document
    .getElementById("salaryStructureTable")
    .querySelector("tbody");
  const csvUploadForm = document.getElementById("csvUploadForm");

  function loadSalaryStructures(page = 1) {
    fetch(`${url}?action=read&page=${page}`)
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
        salaryStructureTable.innerHTML = "";
        data?.data?.forEach((grade) => {
          const row = document.createElement("tr");
          row.innerHTML = `
            <td>${grade?.struct_name}</td>
            <td>${grade?.grade_level}</td>
            <td>${grade?.step}</td>
            <td>
              <button class="btn btn-warning btn-sm" onclick="editGrade(${grade.id})">Update</button>
              <button class="btn btn-danger btn-sm" onclick="deleteGrade(${grade.id})">Delete</button>
            </td>
          `;
          salaryStructureTable.appendChild(row);
        });
        updatePagination(data?.totalPages, page, loadSalaryStructures);
      });
  }

  function loadSalaryStructuresDropdown() {
    fetch("../routes/salary_structure_grades.php?action=read2")
      .then((response) => response.json())
      .then((data) => {
        console.log(salaryStructureSelect);
        salaryStructureSelect.innerHTML = '<option value="">Select Salary Structure</option>';
        data.forEach((structure) => {
          const option = document.createElement("option");
          option.value = structure.id;
          option.textContent = structure.struct_name;
          salaryStructureSelect.appendChild(option);
        });
      });
  }

  salaryStructureForm.addEventListener("submit", (event) => {
    event.preventDefault();
    
    const formData = new FormData(salaryStructureForm);
    const action = formData.get("id") ? "update" : "create";
    formData.append("action", action);

    // Convert struct_name to salary_structure_id
    const selectedStructName = formData.get("struct_name");
    const salaryStructureId = Array.from(salaryStructureSelect.options)
      .find(option => option.text === selectedStructName)?.value;
    formData.set("salary_structure_id", salaryStructureId);
    
    fetch(url, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          salaryStructureForm.reset();
          showToast("Salary Structure Grade saved successfully!", "success");
          loadSalaryStructures();
        } else {
          showToast("An error occurred while saving the Salary Structure Grade.", "danger");
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
          loadSalaryStructures();
          alertContainer.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
        } else {
          alertContainer.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
        }
      });
  });

  window.editGrade = function (id) {
    fetch(`${url}?action=read&id=${id}`)
      .then((response) => response.json())
      .then((data) => {
        document.getElementById("id").value = data?.id;
        salaryStructureSelect.value = data?.salary_structure_id;
        document.getElementById("grade_level").value = data?.grade_level;
        document.getElementById("step").value = data?.step;
      });
  };

  window.deleteGrade = function (id) {
    if (confirm("Are you sure you want to delete this Salary Structure Grade?")) {
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
            showToast("Salary Structure Grade deleted successfully!", "success");
            loadSalaryStructures();
          } else {
            showToast("Failed to delete the Salary Structure Grade.", "danger");
          }
        });
    }
  };

  loadSalaryStructures();
  loadSalaryStructuresDropdown(); // Load dropdown options
});
