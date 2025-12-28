document.getElementById('addUserForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const messageDiv = document.getElementById('message');
    
    fetch('add_user.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            messageDiv.textContent = data.message + ' Redirecting to dashboard...';
            messageDiv.className = 'message success';
            messageDiv.style.display = 'block';
            
            // Redirect to dashboard after 1.5 seconds
            setTimeout(() => {
                window.location.href = 'dashboard.php';
            }, 1500);
        } else {
            messageDiv.textContent = data.message;
            messageDiv.className = 'message error';
            messageDiv.style.display = 'block';
        }
    })
    .catch(error => {
        messageDiv.textContent = 'An error occurred. Please try again.';
        messageDiv.className = 'message error';
        messageDiv.style.display = 'block';
    });
});