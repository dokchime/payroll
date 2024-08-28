const url = "../routes/monthly_salary_schedule.php";

document.addEventListener("DOMContentLoaded", () => {
  const salaryScheduleForm = document.getElementById("salaryScheduleForm");
  const salaryScheduleTable = document
    .getElementById("salaryScheduleTable")
    .querySelector("tbody");
    const csvUploadForm = document.getElementById("csvUploadForm");
    const gradeSelect = document.getElementById("salary_structure_grades_id");
  
  function loadSalarySchedules(page = 1) {
    fetch(`${url}?action=read&page=${page}`)
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
        salaryScheduleTable.innerHTML = "";
        data?.data?.forEach((schedule) => {
          const row = document.createElement("tr");
          row.innerHTML = `
                        <td>${schedule?.year}</td>
                        <td>${schedule?.month}</td>
                        <td>${schedule?.ss_struct_name}</td>
                        <td>${schedule?.staff_id}</td>
                        <td>${schedule?.grade_based_additions}</td>
                        <td>${schedule?.grade_based_deductions}</td>
                        <td>${schedule?.individual_based_additions}</td>
                        <td>${schedule?.individual_based_deductions}</td>
                        <td>${schedule?.net_take_home_pay}</td>
                        <td>${schedule?.due_date}</td>
                        <td>${schedule?.is_active ? 'Yes' : 'No'}</td>
                        <td>${schedule?.comment}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editSalarySchedule(${schedule.mss_id})">Update</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteSalarySchedule(${schedule.mss_id})">Delete</button>
                        </td>
                    `;
          salaryScheduleTable.appendChild(row);
        });
        updatePagination(data?.totalPages, page, loadSalarySchedules);
      });
  }

  function loadSalaryStructuresDropdown() {
    fetch('../routes/monthly_salary_schedule.php?action=read2')  // Endpoint to get salary structures
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


  salaryScheduleForm.addEventListener("submit", (event) => {
    event.preventDefault();

    const formData = new FormData(salaryScheduleForm);
    const action = formData.get("id") ? "update" : "create";
    formData.append("action", action);

    // Fetch calculated data before form submission
    fetch(url, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          salaryScheduleForm.reset();
          alertContainer.innerHTML = `<div class="alert alert-success">Salary schedule saved successfully!</div>`;
          loadSalarySchedules();
        } else {
          alertContainer.innerHTML = `<div class="alert alert-danger">An error occurred while saving the salary schedule.</div>`;
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
          loadSalarySchedules();
          alertContainer.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
        } else {
          alertContainer.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
        }
      });
  });

  window.editSalarySchedule = function (id) {
    fetch(`${url}?action=read&id=${id}`)
      .then((response) => response.json())
      .then((data) => {
        document.getElementById("id").value = data?.id;
        document.getElementById("year").value = data?.year;
        document.getElementById("month").value = data?.month;
        document.getElementById("salary_structure_grades_id").value = data?.salary_structure_grades_id;
        document.getElementById("staff_id").value = data?.staff_id;
        document.getElementById("due_date").value = data?.due_date;
        document.getElementById("is_active").value = data?.is_active ? '1' : '0';
        document.getElementById("comment").value = data?.comment;
      });
  };

  window.deleteSalarySchedule = function (id) {
    if (confirm("Are you sure you want to delete this salary schedule?")) {
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
            alertContainer.innerHTML = `<div class="alert alert-success">Salary schedule deleted successfully!</div>`;
            loadSalarySchedules();
          } else {
            alertContainer.innerHTML = `<div class="alert alert-danger">Failed to delete the salary schedule.</div>`;
          }
        });
    }
  };

  loadSalarySchedules();
  loadSalaryStructuresDropdown();
});
