document.addEventListener('DOMContentLoaded', function () {
    fetch('../routes/dashboard.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('ministryCount').innerText = data.ministryCount;
            document.getElementById('unitsCount').innerText = data.unitsCount;
            document.getElementById('usersCount').innerText = data.usersCount;
            document.getElementById('employeesCount').innerText = data.employeesCount;
            document.getElementById('capturedStaffCount').innerText = data.capturedStaffCount;
            document.getElementById('pendingStaffCount').innerText = data.pendingStaffCount;
        })
        .catch(error => console.error('Error:', error));
});
