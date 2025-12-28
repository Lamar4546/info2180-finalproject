document.addEventListener('DOMContentLoaded', function () {

    const form = document.querySelector('form.box');
    if (!form) {
        console.error('Form not found');
        return;
    }

    let messageDiv = document.getElementById('message');
    if (!messageDiv) {
        messageDiv = document.createElement('div');
        messageDiv.id = 'message';
        form.prepend(messageDiv);
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        messageDiv.textContent = '';
        messageDiv.className = '';

        const formData = new FormData();
        formData.append('title', document.getElementById('title').value);
        formData.append('first_name', document.getElementById('first_name').value.trim());
        formData.append('last_name', document.getElementById('last_name').value.trim());
        formData.append('email', document.getElementById('email').value.trim());
        formData.append('telephone', document.getElementById('telephone').value.trim());
        formData.append('company', document.getElementById('company').value.trim());
        formData.append('type', document.getElementById('type').value);
        formData.append('assigned_to', document.getElementById('assigned-to').value);

        fetch('/info2180-finalproject/add_contact.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                messageDiv.textContent = data.message || 'Contact added successfully!';
                messageDiv.className = 'success';
                form.reset();

                setTimeout(() => {
                    window.location.href = 'dashboard.php';
                }, 1500);
            } else {
                messageDiv.textContent = data.message || 'Failed to add contact';
                messageDiv.className = 'error';
            }
        })
        .catch(error => {
            console.error(error);
            messageDiv.textContent = 'An error occurred. Please try again.';
            messageDiv.className = 'error';
        });
    });
});
