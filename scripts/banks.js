const url = "../routes/banks.php";

document.addEventListener("DOMContentLoaded", () => {
    const bankForm = document.getElementById("bankForm");
    const csvUploadForm = document.getElementById("csvUploadForm");
    const bankTable = document.querySelector("#bankTable tbody");
    const submitButton = bankForm.querySelector("button[type='submit']");
    let isUpdating = false;

    function loadBanks(page = 1) {
        fetch(`${url}?action=read&page=${page}`)
            .then(response => response.json())
            .then(data => {
                bankTable.innerHTML = "";
                data.data.forEach(bank => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${bank.id}</td>
                        <td>${bank.bank_name}</td>
                        <td>${bank.sort_code}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editBank(${bank.id})">Update</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteBank(${bank.id})">Delete</button>
                        </td>
                    `;
                    bankTable.appendChild(row);
                });
                updatePagination(data.totalPages, page);
            })
            .catch(error => console.error('Error loading banks:', error));
    }

    function updatePagination(totalPages, currentPage) {
        const paginationContainer = document.getElementById("pagination");
        paginationContainer.innerHTML = "";

        for (let i = 1; i <= totalPages; i++) {
            const pageButton = document.createElement("button");
            pageButton.className = "btn btn-primary mx-1";
            pageButton.innerText = i;
            if (i === currentPage) {
                pageButton.disabled = true;
            }
            pageButton.addEventListener("click", () => loadBanks(i));
            paginationContainer.appendChild(pageButton);
        }
    }

    bankForm.addEventListener("submit", event => {
        event.preventDefault();

        const formData = new FormData(bankForm);
        const action = isUpdating ? "update" : "create";
        formData.append('action', action);

        fetch(url, {
            method: "POST",
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    bankForm.reset();
                    submitButton.textContent = "Add Bank";
                    isUpdating = false;
                    loadBanks();
                } else {
                    alert("An error occurred.");
                }
            });
    });

    csvUploadForm.addEventListener("submit", event => {
        event.preventDefault();

        const formData = new FormData(csvUploadForm);
        formData.append('action', 'bulkUpload');

        fetch(url, {
            method: "POST",
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    csvUploadForm.reset();
                    loadBanks();
                } else {
                    alert("An error occurred during the CSV upload.");
                }
            });
    });

    window.editBank = function (id) {
        fetch(`${url}?action=read&id=${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById("id").value = data.id;
                document.getElementById("bank_name").value = data.bank_name;
                document.getElementById("sort_code").value = data.sort_code;
                submitButton.textContent = "Update Bank";
                isUpdating = true;
            })
            .catch(error => {
                console.error('Unable to fetch the bank details:', error);
                alert('Unable to fetch the bank details');
            });
    };

    window.deleteBank = function (id) {
        if (confirm("Are you sure you want to delete this bank?")) {
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
                        loadBanks();
                    } else {
                        alert("Failed to delete the bank.");
                    }
                });
        }
    };

    loadBanks();
});
