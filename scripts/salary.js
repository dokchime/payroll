const url = './routes/salary.php';

$(document).ready(function() {

    const salaryForm = document.getElementById("salaryForm");
    if (salaryForm) {
        salaryForm.addEventListener("submit", function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            formData.append("action", "create_salary_structure");
        
            $.ajax({
                url,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    let result = JSON.parse(response);
                    if (result.status === 'success') {
                        alert('salary structure saved successfully!');
                        $('#salaryForm')[0].reset();
                        loadMinistries();
                    } else {
                        alert('Error saving salary structure.');
                    }
                }
            });
      })
    }
});
