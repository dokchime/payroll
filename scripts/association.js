const url = "../routes/association.php";

document.addEventListener("DOMContentLoaded", () => {
    const associationForm = document.getElementById("associationForm");
    const associationTable = document.getElementById("associationTable").querySelector("tbody");

    function loadAssociations() {
        fetch(`${url}?action=read`)
            .then(response => response.json())
            .then(data => {
                associationTable.innerHTML = "";
                data.forEach(association => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${association.name}</td>
                        <td>${association.description}</td>
                        <td>${association.dues_type}</td>
                        <td>${association.fixed_amount}</td>
                        <td>${association.percentage_of_gross}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editAssociation(${association.id})">Update</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteAssociation(${association.id})">Delete</button>
                        </td>
                    `;
                    associationTable.appendChild(row);
                });
            });
    }

    associationForm.addEventListener("submit", event => {
        event.preventDefault();

        const formData = new FormData(associationForm);
        const action = formData.get("id") ? "update" : "create";
        formData.append('action', action);

        fetch(url, {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                associationForm.reset();
                showToast("Association saved successfully!", "success");
                loadAssociations();
            } else {
                showToast("An error occurred while saving the association.", "danger");
            }
        });
    });

    window.editAssociation = function (id) {
        fetch(`${url}?action=read&id=${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById("id").value = data.id;
                document.getElementById("name").value = data.name;
                document.getElementById("description").value = data.description;
                document.getElementById("dues_type").value = data.dues_type;
                document.getElementById("fixed_amount").value = data.fixed_amount;
                document.getElementById("percentage_of_gross").value = data.percentage_of_gross;
            });
    };

    window.deleteAssociation = function (id) {
        if (confirm("Are you sure you want to delete this association?")) {
            fetch(url, {
                method: "POST",
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    id: id,
                    action: 'delete'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast("Association deleted successfully!", "success");
                    loadAssociations();
                } else {
                    showToast("Failed to delete the association.", "danger");
                }
            });
        }
    };

    loadAssociations();
});
