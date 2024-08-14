$(document).ready(function () {
    let currentStep = 0;
    const formSteps = $(".form-step");

    function showStep(step) {
        formSteps.hide();
        formSteps.eq(step).show();
    }

    $("#nextStep").click(function () {
        currentStep++;
        showStep(currentStep);
    });

    $("#prevStep").click(function () {
        currentStep--;
        showStep(currentStep);
    });

    $("#nextStep2").click(function () {
        currentStep++;
        showStep(currentStep);
    });

    $("#prevStep2").click(function () {
        currentStep--;
        showStep(currentStep);
    });

    $("#registrationForm").submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: 'submit_registration.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                $("#alertContainer").html(`<div class="alert alert-success">${response}</div>`);
            },
            error: function () {
                $("#alertContainer").html('<div class="alert alert-danger">Registration failed. Please try again.</div>');
            }
        });
    });

    showStep(currentStep);
});
