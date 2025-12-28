document.addEventListener('DOMContentLoaded', function() {
    const tbody = document.getElementById('contacts-tbody');
    const filterButtons = document.querySelectorAll('.filter-btn');
    let currentFilter = 'all';

    // Load contacts on page load
    loadContacts(currentFilter);

    // Add click handlers to filter buttons
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Get filter value and load contacts
            currentFilter = this.getAttribute('data-filter');
            loadContacts(currentFilter);
        });
    });

    function loadContacts(filter) {
        tbody.innerHTML = '<tr><td colspan="5" style="text-align: center; padding: 2rem;">Loading contacts...</td></tr>';

        // Try relative path first
        fetch(`get_contacts.php?filter=${filter}`)
            .then(response => {
                console.log('Response status:', response.status); // Debug log
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Data received:', data); // Debug log
                if (data.success) {
                    displayContacts(data.contacts);
                } else {
                    tbody.innerHTML = `<tr><td colspan="5" style="text-align: center; padding: 2rem; color: #d32f2f;">Error: ${data.message}</td></tr>`;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                tbody.innerHTML = '<tr><td colspan="5" style="text-align: center; padding: 2rem; color: #d32f2f;">Failed to load contacts. Check console for details.</td></tr>';
            });
    }

    function displayContacts(contacts) {
        if (contacts.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" style="text-align: center; padding: 2rem;">No contacts found</td></tr>';
            return;
        }

        let html = '';

        contacts.forEach(contact => {
            const typeClass = contact.type === 'Sales Lead' ? 'sales' : 'support';
            const typeText = contact.type === 'Sales Lead' ? 'SALES LEAD' : 'SUPPORT';
            
            html += '<tr>';
            html += `<td>${contact.title}. ${contact.first_name} ${contact.last_name}</td>`;
            html += `<td>${contact.email}</td>`;
            html += `<td>${contact.company}</td>`;
            html += `<td><span class="${typeClass}">${typeText}</span></td>`;
            html += `<td><a href="view_contact.php?id=${contact.id}" class="purple">View</a></td>`;
            html += '</tr>';
        });

        tbody.innerHTML = html;
    }
});
