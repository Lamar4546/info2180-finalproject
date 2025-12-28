document.addEventListener('DOMContentLoaded', function() {
    // Assign to me button
    const assignBtn = document.getElementById('assign-btn');
    if (assignBtn) {
        assignBtn.addEventListener('click', function() {
            assignToMe();
        });
    }
    
    // Switch type button
    const switchBtn = document.getElementById('switch-type-btn');
    if (switchBtn) {
        switchBtn.addEventListener('click', function() {
            switchContactType();
        });
    }
});

function assignToMe() {
    const contactId = document.body.dataset.contactId;
    if (!contactId) {
        alert('Contact ID not found');
        return;
    }
    
    const btn = document.getElementById('assign-btn');
    const originalText = btn.textContent;
    btn.textContent = 'Assigning...';
    btn.classList.add('ajax-loading');
    
    fetch('assign_contact.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'contact_id=' + encodeURIComponent(contactId)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('assigned-to').textContent = 'Me';
            alert('Contact assigned to you successfully!');
        } else {
            alert(data.message || 'Failed to assign contact');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error assigning contact. Please try again.');
    })
    .finally(() => {
        btn.textContent = originalText;
        btn.classList.remove('ajax-loading');
    });
}

function switchContactType() {
    const contactId = document.body.dataset.contactId;
    if (!contactId) {
        alert('Contact ID not found');
        return;
    }
    
    const btn = document.getElementById('switch-type-btn');
    const originalText = btn.textContent;
    btn.textContent = 'Switching...';
    btn.classList.add('ajax-loading');
    btn.disabled = true;
    
    fetch('switch_type.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'contact_id=' + encodeURIComponent(contactId)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            btn.textContent = data.new_type === 'Sales Lead' ? 'Switch to Support' : 'Switch to Sales Lead';
            alert('Contact type updated successfully!');
        } else {
            alert(data.message || 'Failed to switch type');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error switching type. Please try again.');
    })
    .finally(() => {
        btn.disabled = false;
        btn.classList.remove('ajax-loading');
    });
}