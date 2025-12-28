document.addEventListener('DOMContentLoaded', function() {
    loadUsers();
});

function loadUsers() {
    const tableBody = document.getElementById('usersTableBody');
    
    fetch('../users.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('HTTP error ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }
            displayUsers(data);
        })
        .catch(error => {
            console.error('Error loading users:', error);
            tableBody.innerHTML = '<tr><td colspan="4">Error loading users: ' + error.message + '</td></tr>';
        });
}

function displayUsers(users) {
    const tableBody = document.getElementById('usersTableBody');
    
    if (users.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="4" style="text-align: center; padding: 40px; color: #999;">No users found</td></tr>';
        return;
    }
    
    tableBody.innerHTML = users.map(user => {
        // Format the date
        const createdDate = new Date(user.created_at);
        const formattedDate = createdDate.toLocaleDateString('en-US', { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        });
        
        return `
            <tr>
                <td><strong>${escapeHtml(user.firstname)} ${escapeHtml(user.lastname)}</strong></td>
                <td>${escapeHtml(user.email)}</td>
                <td>${escapeHtml(user.role)}</td>
                <td>${formattedDate}</td>
            </tr>
        `;
    }).join('');
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}