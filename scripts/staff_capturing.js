const url = "../routes/staff.php";

$(document).ready(function () {
  let currentStep = 0;
  const formSteps = $(".form-step");
  const totalSteps = formSteps.length;

  function showStep(step) {
    formSteps.hide();
    formSteps.eq(step).show();

    // Disable the "Next" button if on the last step
    if (step === totalSteps - 1) {
      $("#nextStep, #nextStep2").prop("disabled", true);
    } else {
      $("#nextStep, #nextStep2").prop("disabled", false);
    }

    // Disable the "Back" button if on the first step
    if (step === 0) {
      $("#prevStep, #prevStep2").prop("disabled", true);
    } else {
      $("#prevStep, #prevStep2").prop("disabled", false);
    }
  }

  function validateStep(step) {
    let isValid = true;
    formSteps
      .eq(step)
      .find("input[required], select[required]")
      .each(function () {
        if (!$(this).val()) {
          isValid = false;
          $(this).addClass("is-invalid");
        } else {
          $(this).removeClass("is-invalid");
        }
      });
    return isValid;
  }

  function validateAllSteps() {
    let allValid = true;
    formSteps.each(function (index, step) {
      $(step)
        .find("input[required], select[required]")
        .each(function () {
          if (!$(this).val()) {
            allValid = false;
            $(this).addClass("is-invalid");
          } else {
            $(this).removeClass("is-invalid");
          }
        });
    });
    return allValid;
  }

  $("#nextStep, #nextStep2").click(function () {
    if (validateStep(currentStep) && currentStep < totalSteps - 1) {
      currentStep++;
      showStep(currentStep);
    }
  });

  $("#prevStep, #prevStep2").click(function () {
    if (currentStep > 0) {
      currentStep--;
      showStep(currentStep);
    }
  });

  $("#registrationForm").submit(function (e) {
    if (!validateAllSteps()) {
      e.preventDefault();
      alert("Please fill in all required fields before submitting.");
      return;
    }

    e.preventDefault();

    // Create a FormData object
    let formElement = document.getElementById("registrationForm");
    let formData = new FormData(formElement);
    formData.append("action", "create");

    $.ajax({
      url: url,
      method: "POST",
      data: formData,
      processData: false, // Important for FormData
      contentType: false, // Important for FormData
      dataType: "json", // Expecting a JSON response
      success: function (response) {
        if (response.success) {
          $("#alertContainer").html(
            `<div class="alert alert-success">${response.message}</div>`
          );
        } else {
          $("#alertContainer").html(
            `<div class="alert alert-danger">${response.message}</div>`
          );
        }
      },
      error: function () {
        $("#alertContainer").html(
          '<div class="alert alert-danger">Registration failed. Please try again.</div>'
        );
      },
    });
  });

  showStep(currentStep);
});
