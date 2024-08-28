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
              <button class="btn btn-warning btn-sm" onclick="editGrade(${grade.ssg_id})">Update</button>
              <button class="btn btn-danger btn-sm" onclick="deleteGrade(${grade.ssg_id})">Delete</button>
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

    console.log("Form submission triggered");

    const formData = new FormData(salaryStructureForm);
    const action = formData.get("id") ? "update" : "create";
    formData.append("action", action);
/*
    console.log("Form Data before struct_name conversion:", Array.from(formData.entries()));

    // Convert struct_name to salary_structure_id
    const selectedStructName = formData.get("struct_name");
    console.log("Selected Salary Structure vvv:", selectedStructName);
    
    const salaryStructureId = Array.from(salaryStructureSelect.options)
      .find(option => option.text === selectedStructName)?.value;

    console.log("Selected Salary Structure ID:", salaryStructureId);

    if (salaryStructureId) {
        formData.set("salary_structure_id", salaryStructureId);
        formData.delete("struct_name"); // Optional: Remove the struct_name if it's no longer needed
    }

    console.log("Form Data after struct_name conversion:", Array.from(formData.entries()));
*/

    fetch(url, {
      method: "POST",
      body: formData,
    })
    .then((response) => response.json())
    .then((data) => {
        console.log("Server Response:", data);

        if (data.success) {
            salaryStructureForm.reset();
            alertContainer.innerHTML = `<div class="alert alert-success">Salary Structure Grade saved successfully!</div>`;
            loadSalaryStructures();
        } else {
          alertContainer.innerHTML = `<div class="alert alert-danger">An error occurred while saving the Salary Structure Grade.</div>`;
        }
    })
    .catch((error) => {
        console.error("Error submitting form:", error);
        alertContainer.innerHTML = `<div class="alert alert-danger">An error occurred while saving the Salary Structure Grade.</div>`;
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
        // document.getElementById("struct_name").value = data?.struct_name;
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
            alertContainer.innerHTML = `<div class="alert alert-success">Salary Structure Grade deleted successfully!</div>`;
            loadSalaryStructures();
          } else {
            alertContainer.innerHTML = `<div class="alert alert-danger">Failed to delete the Salary Structure Grade.</div>`;
          }
        });
    }
  };

  loadSalaryStructures();
  loadSalaryStructuresDropdown(); // Load dropdown options
});
