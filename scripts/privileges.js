const url = "../routes/privileges.php";

$(document).ready(function () {
    // Load all privileges when the page loads
    loadPrivileges();

    // Function to load all privileges
    function loadPrivileges() {
        $.post(url, { action: 'get_all_privileges' }, function (response) {
            if (response.status === 'success') {
                let privileges = response.data;
                let html = '';
                privileges.forEach(function (privilege) {
                    html += `<tr>
                                <td>${privilege.categ_id}</td>
                                <td>${privilege.categ_name}</td>
                                <td><button class="edit btn btn-primary" data-id="${privilege.categ_id}">Edit</button></td>
                                <td><button class="delete btn btn-danger" data-id="${privilege.categ_id}">Delete</button></td>
                             </tr>`;
                });
                $('#privilegesTable').html(html);
            } else {
                alert('Failed to load privileges.');
            }
        }, 'json');
    }

    // Event to create or update a privilege
    $('#createPrivilegeForm').submit(function (e) {
        e.preventDefault();
        let categ_id = $('#categ_id').val();
        let categ_name = $('#categ_name').val();

        // Determine action based on presence of categ_id
        let action = categ_id ? 'update_privilege' : 'create_privilege';
        let data = { action: action, categ_name: categ_name };

        // Include categ_id if updating
        if (categ_id) {
            data.categ_id = categ_id;
        }

        $.post(url, data, function (response) {
            if (response.status === 'success') {
                loadPrivileges(); // Reload the list after update or creation
                $('#categ_id').val(''); // Clear the hidden id field
                $('#categ_name').val(''); // Clear the input field
                $('button[type="submit"]').text('ADD PRIVILEGE'); // Reset the button text
            } else {
                alert('Failed to process request.');
            }
        }, 'json');
    });

    // Handle Edit button click
    $(document).on('click', '.edit', function () {
        let categ_id = $(this).data('id');
        $.post(url, { action: 'get_privilege_by_id', categ_id: categ_id }, function (response) {
            if (response.status === 'success') {
                let privilege = response.data;
                $('#categ_id').val(privilege.categ_id);
                $('#categ_name').val(privilege.categ_name);
                $('button[type="submit"]').text('Update Privilege');
            } else {
                alert('Failed to fetch privilege.');
            }
        }, 'json');
    });

    // Handle Delete button click
    $(document).on('click', '.delete', function () {
        let categ_id = $(this).data('id');
        if (confirm('Are you sure you want to delete this privilege?')) {
            $.post(url, { action: 'delete_privilege', categ_id: categ_id }, function (response) {
                if (response.status === 'success') {
                    loadPrivileges(); // Reload the list after deletion
                } else {
                    alert('Failed to delete privilege.');
                }
            }, 'json');
        }
    });
});
