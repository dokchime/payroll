const url = "../routes/grade_based_additions.php";

document.addEventListener("DOMContentLoaded", () => {
  const gradeAdditionForm = document.getElementById("gradeAdditionForm");
  const gradeAdditionTable = document
    .getElementById("gradeAdditionTable")
    .querySelector("tbody");
    const csvUploadForm = document.getElementById("csvUploadForm");
    const gradeSelect = document.getElementById("salary_structure_grades_id");

  function loadGradeAdditions(page = 1) {
    fetch(`${url}?action=read&page=${page}`)
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
        gradeAdditionTable.innerHTML = "";
        data?.data?.forEach((addition) => {
          const row = document.createElement("tr");
          row.innerHTML = `
                        <td>${addition?.year}</td>
                        <td>${addition?.month}</td>
                        <td>${addition?.ss_struct_name}</td>
                        <td>${addition?.gba_description}</td>
                        <td>${addition?.amount}</td>
                        <td>${addition?.is_active ? 'Yes' : 'No'}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editGradeAddition(${addition.gba_id})">Update</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteGradeAddition(${addition.gba_id})">Delete</button>
                        </td>
                    `;
          gradeAdditionTable.appendChild(row);
        });
        updatePagination(data?.totalPages, page, loadGradeAdditions);
      });
  }

  function loadSalaryStructuresDropdown() {
    fetch('../routes/grade_based_additions.php?action=read2')  // Endpoint to get salary structures
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

  gradeAdditionForm.addEventListener("submit", (event) => {
    event.preventDefault();

    const formData = new FormData(gradeAdditionForm);
    const action = formData.get("id") ? "update" : "create";
    formData.append("action", action);

    fetch(url, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          gradeAdditionForm.reset();
          alertContainer.innerHTML = `<div class="alert alert-success">Grade Addition saved successfully!</div>`;
          loadGradeAdditions();
        } else {
          alertContainer.innerHTML = `<div class="alert alert-danger">An error occurred while saving the grade addition.</div>`;
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
          loadGradeAdditions();
          alertContainer.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
        } else {
          alertContainer.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
        }
      });
  });

  window.editGradeAddition = function (id) {
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

  window.deleteGradeAddition = function (id) {
    if (confirm("Are you sure you want to delete this grade addition?")) {
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
            alertContainer.innerHTML = `<div class="alert alert-success">Grade Addition deleted successfully!</div>`;
            loadGradeAdditions();
          } else {
            alertContainer.innerHTML = `<div class="alert alert-danger">Failed to delete the grade addition.</div>`;
          }
        });
    }
  };

  loadGradeAdditions();
  loadSalaryStructuresDropdown();
});
