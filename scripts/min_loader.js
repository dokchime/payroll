$(document).ready(function() {
    const url_ministries = "../loaders/ministry.php";

    // Load ministries into the ministry select field
    $.ajax({
        url: url_ministries,
        method: 'POST',
        success: function(data) {
            try {
                let response = JSON.parse(data);
                if (response.status === 'success') {
                    let ministries = response.ministries;
                    let $ministrySelect = $('#minist_parast_id');
                    $ministrySelect.empty();
                    $ministrySelect.append('<option value="">Select Ministry</option>');
                    
                    // Ensure ministries is an array
                    if (Array.isArray(ministries)) {
                        console.log('Raw data:', ministries);
                        $.each(ministries, function(index, ministry) {
                            $ministrySelect.append('<option value="' + ministry.id + '">' + ministry.name + '</option>');
                        });
                    } else {
                        console.error('Ministries data is not an array:', ministries);
                    }
                } else {
                    alert('Failed to load ministries: ' + response.message);
                }
            } catch (e) {
                console.error('JSON parsing error:', e);
                alert('Failed to parse JSON response.');
            }
        },
        error: function() {
            alert('Error loading ministries.');
        }
    });
});
