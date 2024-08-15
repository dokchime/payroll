const url_bank = "../loaders/banker.php";
$(document).ready(function() {
    $.ajax({
        url: url_bank,
        method: 'POST',
        success: function(data) {
            let banks = JSON.parse(data)?.banks;
            let $bankSelect = $('#bank_id');
            $bankSelect.empty();
            $bankSelect.append('<option value="">Select State</option>');
            $.each(banks, function(id, bank_name) {
                $bankSelect.append('<option value="' + id + '">' + bank_name + '</option>');
            });
        }
    });
});