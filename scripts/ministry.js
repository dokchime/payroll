const url = "../routes/ministry_routes.php";

$(document).ready(function () {
  loadMinistries();

  $("#ministryForm").on("submit", function (event) {
    event.preventDefault();
    let formData = new FormData(this);
    const action = formData.get("id") ? "update" : "create";
    formData.append("action", action);

    $.ajax({
      url,
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        console.log(response);
        if (response.success) {
          $("#alertContainer").html(
            `<div class="alert alert-success">${response.message}</div>`
          );
          $("#ministryForm")[0].reset();
          loadMinistries();
        } else {
          $("#alertContainer").html(
            `<div class="alert alert-danger">${response.message}</div>`
          );
        }
      },
      error: function () {
        $("#alertContainer").html(
          '<div class="alert alert-danger">Error saving ministry.</div>'
        );
      },
    });
  });
});

function loadMinistries(page = 1) {
  $.post(
    `${url}?action=read&page=${page}`,
    function (response) {
      let result = JSON.parse(response);
      if (result.status) {
        let ministryList = $("#ministryList");
        ministryList.empty();
        result.data.forEach((ministry) => {
          ministryList.append(`
                    <tr>
                        <td>${ministry?.name}</td>
                        <td>${ministry?.description}</td>
                        <td>${ministry?.address}</td>
                        <td>
                            <button class="btn btn-warning" onclick="editMinistry(${ministry.id})">Edit</button>
                            <button class="btn btn-danger" onclick="deleteMinistry(${ministry.id})">Delete</button>
                        </td>
                    </tr>
                `);
          updatePagination(result?.totalPages, page, loadMinistries);
        });
      } else {
        alert("Error loading ministries.");
      }
    }
  );
}

function editMinistry(id) {
  $.post(url, { action: "getById", id: id }, function (response) {
    let result = JSON.parse(response);
    if (result.status === "success") {
      let ministry = result.data;
      $("#action").val("update");
      $("#id").val(ministry?.id);
      $("#name").val(ministry?.name);
      $("#description").val(ministry?.description);
      $("#address").val(ministry?.address);
    } else {
      alert("Error fetching ministry details.");
    }
  });
}

function deleteMinistry(id) {
  if (confirm("Are you sure you want to delete this ministry?")) {
    $.post(url, { action: "delete", id: id }, function (response) {
      let result = JSON.parse(response);
      if (result.status === "success") {
        alert("Ministry deleted successfully!");
        loadMinistries();
      } else {
        alert("Error deleting ministry.");
      }
    });
  }
}
