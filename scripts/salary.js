const url = "../routes/salary.php";

$(document).ready(function () {
  const salaryForm = document.getElementById("salaryForm");
  if (salaryForm) {
    salaryForm.addEventListener("submit", function (e) {
      e.preventDefault();
      let formData = new FormData(this);
      formData.append("action", "create_salary_structure");

      $.ajax({
        url:url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          let result = JSON.parse(response);
          if (result.status === "success") {
            alert("salary structure saved successfully!");
            $("#salaryForm")[0].reset();
            loadStructure();
          } else {
            alert("Error saving salary structure.");
          }
        },
      });
    });
  }
  const structTable = document
    .getElementById("structTable")
    .querySelector("tbody");

  function loadStructure(page = 1) {
    fetch(`${url}?action=read&page=${page}`)
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
        structTable.innerHTML = "";
        data?.data?.forEach((structure) => {
          const row = document.createElement("tr");
          row.innerHTML = `
                        <td>${structure?.name}</td>
                        <td>${structure?.description}</td>
                        <td>${structure?.highest_grade_level}</td>
                        <td>${structure?.min_step}</td>
                        <td>
                        </td>
                        `;
                        // <button class="btn btn-warning btn-sm" onclick="editAssociation(${association.id})">Update</button>
                        // <button class="btn btn-danger btn-sm" onclick="deleteAssociation(${association.id})">Delete</button>
          structTable.appendChild(row);
        });
        updatePagination(data?.totalPages, page, loadStructure);
      });
  }

});
