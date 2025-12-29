document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form.box');
    if (!form) return console.error('Form not found');

    // Message div
    let messageDiv = document.getElementById('message');
    if (!messageDiv) {
        messageDiv = document.createElement('div');
        messageDiv.id = 'message';
        form.prepend(messageDiv);
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        messageDiv.textContent = '';
        messageDiv.className = '';

        const formData = new FormData(form);

        fetch('add_contact.php', { method: 'POST', body: formData })
        .then(response => response.text())
        .then(text => {
            console.log('Raw response:', text); // Debug log
            
            let data;
            try {
                data = JSON.parse(text);
            } catch (err) {
                console.error('Invalid JSON response:', text);
                messageDiv.textContent = 'Server error. Check console.';
                messageDiv.className = 'error';
                return;
            }

            if (data.success) {
                messageDiv.textContent = data.message;
                messageDiv.className = 'success';
                form.reset();
                // Fixed the redirect path - removed extra slash and dots
                setTimeout(() => { 
                    window.location.href = 'dashboard.php'; 
                }, 1500);
            } else {
                messageDiv.textContent = data.message;
                messageDiv.className = 'error';
            }
        })
        .catch(err => {
            console.error(err);
            messageDiv.textContent = 'Network error. Try again.';
            messageDiv.className = 'error';
        });
    });
});