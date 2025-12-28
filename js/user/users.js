// Load users when page loads
document.addEventListener('DOMContentLoaded', function() {
    loadUsers();
});

function loadUsers() {
    fetch('includes/user/users.php')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            displayUsers(data.users);
        } else {
            document.getElementById('usersTableBody').innerHTML = 
                `<tr><td colspan="4">Error: ${data.message}</td></tr>`;
        }
    })
    .catch(error => {
        document.getElementById('usersTableBody').innerHTML = 
            '<tr><td colspan="4">Error loading users</td></tr>';
    });
}

function displayUsers(users) {
    const tbody = document.getElementById('usersTableBody');
    
    if (users.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4">No users found</td></tr>';
        return;
    }
    
    tbody.innerHTML = users.map(user => `
        <tr>
            <td>${escapeHtml(user.first_name)} ${escapeHtml(user.last_name)}</td>
            <td>${escapeHtml(user.email)}</td>
            <td>${escapeHtml(user.role)}</td>
            <td>${formatDate(user.created_at)}</td>
        </tr>
    `).join('');
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    });
}