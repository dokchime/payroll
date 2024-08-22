const url = "../routes/salary_schedule.php";

document.addEventListener("DOMContentLoaded", () => {
  const salaryScheduleForm = document.getElementById("salaryScheduleForm");
  const salaryScheduleTable = document
    .getElementById("salaryScheduleTable")
    .querySelector("tbody");

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
                        <td>${schedule?.salary_structure_grades_id}</td>
                        <td>${schedule?.staff_id}</td>
                        <td>${schedule?.grade_based_additions}</td>
                        <td>${schedule?.grade_based_deductions}</td>
                        <td>${schedule?.individual_based_additions}</td>
                        <td>${schedule?.individual_based_deductions}</td>
                        <td>${schedule?.net_take_home_pay}</td>
                        <td>${schedule?.due_date}</td>
                        <td>${schedule?.is_active ? 'Yes' : 'No'}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editSalarySchedule(${schedule.id})">Update</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteSalarySchedule(${schedule.id})">Delete</button>
                        </td>
                    `;
          salaryScheduleTable.appendChild(row);
        });
        updatePagination(data?.totalPages, page, loadSalarySchedules);
      });
  }

  function loadSalaryStructuresDropdown() {
    fetch('../routes/salary_structures.php?action=read')  // Endpoint to get salary structures
      .then(response => response.json())
      .then(data => {
        structNameSelect.innerHTML = '<option value="">Select Salary Structure</option>';
        data.forEach(struct => {
          const option = document.createElement('option');
          option.value = struct.id;
          option.textContent = struct.struct_name;
          structNameSelect.appendChild(option);
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
          showToast("Salary schedule saved successfully!", "success");
          loadSalarySchedules();
        } else {
          showToast(
            "An error occurred while saving the salary schedule.",
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
        document.getElementById("grade_based_additions").value = data?.grade_based_additions;
        document.getElementById("grade_based_deductions").value = data?.grade_based_deductions;
        document.getElementById("individual_based_additions").value = data?.individual_based_additions;
        document.getElementById("individual_based_deductions").value = data?.individual_based_deductions;
        document.getElementById("net_take_home_pay").value = data?.net_take_home_pay;
        document.getElementById("due_date").value = data?.due_date;
        document.getElementById("is_active").value = data?.is_active ? '1' : '0';
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
            showToast("Salary schedule deleted successfully!", "success");
            loadSalarySchedules();
          } else {
            showToast("Failed to delete the salary schedule.", "danger");
          }
        });
    }
  };

  loadSalarySchedules();
  loadSalaryStructuresDropdown();
});
