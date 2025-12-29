window.addEventListener('load', initialize);

function initialize()
{
    document.getElementById('login-button').addEventListener('click', function(e) {
    e.preventDefault();
    
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const errorDiv = document.getElementById('error-message');
    
    // Create form data
    const formData = new FormData();
    formData.append('email', email);
    formData.append('password', password);
    
    // Send AJAX request
    fetch('includes/user/login.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Redirect to dashboard
            window.location.href = 'dashboard.php';
        } else {
            errorDiv.textContent = data.message;
            errorDiv.style.display = 'block';
        }
    })
    .catch(error => {
        errorDiv.textContent = 'An error occurred. Please try again.';
        errorDiv.style.display = 'block';
    });
});
}