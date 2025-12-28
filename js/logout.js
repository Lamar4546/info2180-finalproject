function logout() {
    if (confirm('Are you sure you want to logout?')) {
        fetch('api/logout.php', {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = 'login.html';
            }
        })
        .catch(error => {
            console.error('Logout error:', error);
            // Still redirect to login on error
            window.location.href = 'login.html';
        });
    }
}

// Add to your logout button
// <button onclick="logout()">Logout</button>