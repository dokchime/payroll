const url = "../routes/salary_structure_details.php";

document.addEventListener("DOMContentLoaded", () => {
  const salaryStructureForm = document.getElementById("salaryStructureForm");
  const salaryStructureTable = document.getElementById("salaryStructureTable").querySelector("tbody");
  const csvUploadForm = document.getElementById("csvUploadForm");
  // const structNameSelect = document.getElementById("struct_name");
  const gradeSelect = document.getElementById("salary_structure_grades_id");

  function loadSalaryStructures(page = 1) {
    fetch(`${url}?action=read&page=${page}`)
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
        salaryStructureTable.innerHTML = "";
        data?.data?.forEach((structure) => {
          const row = document.createElement("tr");
          row.innerHTML = `
            <td>${structure?.ss_struct_name}</td>
            <td>${structure?.annual_basic}</td>
            <td>${structure?.annual_gross}</td>
            <td>${structure?.monthly_basic}</td>
            <td>${structure?.monthly_gross}</td>
            <td>
                <button class="btn btn-warning btn-sm" onclick="editSalaryStructure(${structure.ssd_id})">Update</button>
                <button class="btn btn-danger btn-sm" onclick="deleteSalaryStructure(${structure.ssd_id})">Delete</button>
            </td>
          `;
          salaryStructureTable.appendChild(row);
        });
        updatePagination(data?.totalPages, page, loadSalaryStructures);
      });
  }

  function loadSalaryStructuresDropdown() {
    fetch('../routes/salary_structure_details.php?action=read2')  // Endpoint to get salary structures
      .then(response => response.json())
      .then(data => {
        console.log(gradeSelect);
        gradeSelect.innerHTML = '<option value="">Select Salary Structure Grade and Step</option>';
        data.forEach(struct => {
          const option = document.createElement('option');
          option.value = struct.ssg_id;
          option.textContent = struct.ss_struct_name;
          gradeSelect.appendChild(option);
        });
      });
  }

  /*function loadGrades(structId) {
    fetch(`../routes/salary_structure_grades.php?action=read&salary_structure_id=${structId}`)  // Endpoint to get grades
      .then(response => response.json())
      .then(data => {
        gradeSelect.innerHTML = '<option value="">Select Grade</option>';
        data.forEach(grade => {
          const option = document.createElement('option');
          option.value = grade.id;
          option.textContent = `${grade.grade_level} - ${grade.step}`;
          gradeSelect.appendChild(option);
        });
      });
  }*/

  salaryStructureForm.addEventListener("submit", (event) => {
    event.preventDefault();

    const formData = new FormData(salaryStructureForm);
    const action = formData.get("id") ? "update" : "create";
    formData.append("action", action);

    fetch(url, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          salaryStructureForm.reset();
          alertContainer.innerHTML = `<div class="alert alert-success">Salary structure details saved successfully!</div>`;
          loadSalaryStructures();
        } else {
          alertContainer.innerHTML = `<div class="alert alert-danger">An error occurred while saving the salary structure details.</div>`;
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

  window.editSalaryStructure = function (id) {
    fetch(`${url}?action=read&id=${id}`)
      .then((response) => response.json())
      .then((data) => {
        document.getElementById("id").value = data?.id;
        gradeSelect.value = data?.salary_structure_grades_id;
        document.getElementById("annual_basic").value = data?.annual_basic;
        document.getElementById("annual_gross").value = data?.annual_gross;
        document.getElementById("monthly_basic").value = data?.monthly_basic;
        document.getElementById("monthly_gross").value = data?.monthly_gross;
      });
  };

  window.deleteSalaryStructure = function (id) {
    if (confirm("Are you sure you want to delete this salary structure detail?")) {
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
            alertContainer.innerHTML = `<div class="alert alert-success">Salary structure detail deleted successfully!</div>`;
            loadSalaryStructures();
          } else {
            alertContainer.innerHTML = `<div class="alert alert-danger">Failed to delete the salary structure detail.</div>`;
          }
        });
    }
  };

  // structNameSelect.addEventListener('change', () => {
  //   const structId = structNameSelect.value;
  //   if (structId) {
  //     loadGrades(structId);
  //   } else {
  //     gradeSelect.innerHTML = '<option value="">Select Grade</option>';
  //   }
  // });

  loadSalaryStructuresDropdown();
  loadSalaryStructures();
});
