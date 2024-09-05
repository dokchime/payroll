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
      // formData.append("action", "create_salary_structure");
      const action = formData.get("id") ? "update" : "create_salary_structure";
      formData.append("action", action);

      $.ajax({
        url: url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          let result = JSON.parse(response);
          if (result.success) {
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

  window.editStructure = function (id) {
    $.post(`${url}?action=read&id=${id}`, function (response) {
      let result = JSON.parse(response);
      if (result) {
        // let structure = result.data;
        // $("#action").val("update");
        $("#id").val(result?.id);
        $("#name").val(result?.struct_name);
        $("#description").val(result?.description);
      } else {
        alert("Error fetching structure details.");
        console.log(response)
      }
    });
  };

  function loadStructure(page = 1) {
    fetch(`${url}?action=read&page=${page}`)
      .then((response) => response.json())
      .then((data) => {
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
