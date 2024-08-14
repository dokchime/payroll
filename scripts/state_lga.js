const url_states = "../loaders/states.php";
const url_lga = "../loaders/local_govt.php";


$(document).ready(function() {
    // Load states into the state select field
    $.ajax({
        url: url_states,
        method: 'POST',
        success: function(data) {
            let states = JSON.parse(data).states;
            let $stateSelect = $('#state');
            $stateSelect.empty();
            $stateSelect.append('<option value="">Select State</option>');
            $.each(states, function(id, name) {
                $stateSelect.append('<option value="' + id + '">' + name + '</option>');
            });
        }
    });

    // Event handler for state selection change
    $('#state').change(function() {
        var stateId = $(this).val();
        if (stateId) {
            $.ajax({
                url: url_lga,
                method: 'POST',
                data: { state_id: stateId },
                success: function(data) {
                    var lgas = JSON.parse(data).lgas;
                    var $lgaSelect = $('#local_govt');
                    $lgaSelect.empty();
                    $lgaSelect.append('<option value="">Select Local Government</option>'); // Default option
                    $.each(lgas, function(index, lga) {
                        $lgaSelect.append('<option value="' + lga.id + '">' + lga.name + '</option>');
                    });
                }
            });
        } else {
            $('#local_govt').empty().append('<option value="">Select Local Government</option>');
        }
    });
});