const url_priv = "../loaders/priviledges.php";
$(document).ready(function() {
    $.ajax({
        url: url_priv,
        method: 'POST',
        success: function(data) {
            let privs = JSON.parse(data)?.priv;
            let $privSelect = $('#categ_id');
            $privSelect.empty();
            $privSelect.append('<option value="">Select privilege</option>');
            $.each(privs, function(categ_id, categ_name) {
                $privSelect.append('<option value="' + categ_id + '">' + categ_name + '</option>');
            });
        }
    });
});