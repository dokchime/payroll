const url = "../routes/salary_struct.php";

$(document).ready(function () {
  const salaryForm = document.getElementById("salaryForm");
  const structTable = document
    .getElementById("structTable")
    .querySelector("tbody");
  if (salaryForm) {
    salaryForm.addEventListener("submit", function (e) {
      e.preventDefault();
      let formData = new FormData(this);
      formData.append("action", "create_salary_structure");

      $.ajax({
        url: url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          let result = JSON.parse(response);
          if (result.status === "success") {
            alertContainer.innerHTML = `<div class="alert alert-success">salary structure saved successfully!</div>`;
            $("#salaryForm")[0].reset();
            loadStructure();
          } else {
            alertContainer.innerHTML = `<div class="alert alert-danger"> Error saving salary structure. </div>`;
          }
        },
      });
    });
  }

  function editStructure(id) {
    $.post(url, { action: "getById", id: id }, function (response) {
      let result = JSON.parse(response);
      if (result.status === "success") {
        let structure = result.data;
        $("#action").val("update");
        $("#id").val(structure?.id);
        $("#name").val(structure?.struct_name);
        $("#description").val(structure?.description);
      } else {
        alert("Error fetching structure details.");
        
      }
    });
  }

  function loadStructure(page = 1) {
    fetch(`${url}?action=read&page=${page}`)
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
        structTable.innerHTML = "";
        data?.data?.forEach((struct) => {
          const row = document.createElement("tr");
          row.innerHTML = `
                        <td>${struct?.struct_name}</td>
                        <td>${struct?.description}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editStructure(${struct.id})">Update</button>
                            
                        </td>
                    `;
          structTable.appendChild(row);
        });
        updatePagination(data?.totalPages, page, loadStructure);
      });
  }

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
          loadStructure();
          alertContainer.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
        } else {
          alertContainer.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
        }
      });
  });


  loadStructure();
});
