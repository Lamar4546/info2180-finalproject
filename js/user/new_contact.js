document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    const messageDiv = document.getElementById('message');

    if (!form) {
        console.error('Contact form not found');
        return;
    }

    console.log('Contact form loaded successfully');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        console.log('Form submitted');

        // Clear previous messages
        messageDiv.textContent = '';
        messageDiv.className = '';

        // Get form data
        const formData = new FormData();
        formData.append('title', document.getElementById('title').value);
        formData.append('first_name', document.getElementById('first_name').value.trim());
        formData.append('last_name', document.getElementById('last_name').value.trim());
        formData.append('email', document.getElementById('email').value.trim());
        formData.append('telephone', document.getElementById('telephone').value.trim());
        formData.append('company', document.getElementById('company').value.trim());
        formData.append('type', document.getElementById('type').value);
        formData.append('assigned_to', document.getElementById('assigned_to').value);

        console.log('Form data prepared:', {
            title: document.getElementById('title').value,
            first_name: document.getElementById('first_name').value,
            last_name: document.getElementById('last_name').value,
            email: document.getElementById('email').value,
            telephone: document.getElementById('telephone').value,
            company: document.getElementById('company').value,
            type: document.getElementById('type').value,
            assigned_to: document.getElementById('assigned_to').value
        });

        // Send request to add contact - use absolute path
        fetch('/info2180-finalproject/add_contact.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.text();
        })
        .then(text => {
            console.log('Raw response:', text);
            const data = JSON.parse(text);
            console.log('Parsed response:', data);
            
            if (data.success) {
                messageDiv.textContent = data.message || 'Contact added successfully!';
                messageDiv.className = 'success';
                
                // Clear form
                form.reset();
                
                // Redirect to dashboard after 1.5 seconds
                setTimeout(() => {
                    window.location.href = 'dashboard.php';
                }, 1500);
            } else {
                messageDiv.textContent = data.message || 'Failed to add contact';
                messageDiv.className = 'error';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            messageDiv.textContent = 'An error occurred. Please try again. ' + error.message;
            messageDiv.className = 'error';
        });
    });
});