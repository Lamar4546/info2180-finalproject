document.addEventListener('DOMContentLoaded', function() {
    loadContacts();
    setupFilters();
});

let allContacts = [];
let currentFilter = 'all';

function loadContacts(filter = 'all') {
    const tableBody = document.getElementById('contactsTableBody');
    
    // Build the URL with filter parameter
    let url = '../contacts.php?filter=' + encodeURIComponent(filter);
    
    fetch(url)
        .then(response => response.json())
        .then(data => {
            allContacts = data;
            displayContacts(data);
        })
        .catch(error => {
            console.error('Error loading contacts:', error);
            tableBody.innerHTML = '<tr><td colspan="5">Error loading contacts</td></tr>';
        });
}

function displayContacts(contacts) {
    const tableBody = document.getElementById('contactsTableBody');
    
    if (contacts.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="5" style="text-align: center; padding: 40px; color: #999;">No contacts found</td></tr>';
        return;
    }
    
    tableBody.innerHTML = contacts.map(contact => {
        const badgeClass = contact.type === 'Sales Lead' ? 'sales-lead' : 'support';
        const typeName = contact.type === 'Sales Lead' ? 'SALES LEAD' : 'SUPPORT';
        
        return `
            <tr>
                <td><strong>${escapeHtml(contact.title)} ${escapeHtml(contact.firstname)} ${escapeHtml(contact.lastname)}</strong></td>
                <td>${escapeHtml(contact.email)}</td>
                <td>${escapeHtml(contact.company)}</td>
                <td><span class="badge ${badgeClass}">${typeName}</span></td>
                <td><a href="view_contact.php?id=${contact.id}" class="view-link">View</a></td>
            </tr>
        `;
    }).join('');
}

function setupFilters() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Get filter value
            const filter = this.getAttribute('data-filter');
            currentFilter = filter;
            
            // Load contacts with filter
            loadContacts(filter);
        });
    });
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}