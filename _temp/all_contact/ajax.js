document.addEventListener('DOMContentLoaded', function() {
    const contactId = document.body.dataset.contactId;
    
    if (!contactId) {
        console.error('Contact ID not found');
        return;
    }

    // Load notes when page loads
    loadNotes();

    // Set up event listeners
    const assignBtn = document.getElementById('assign-btn');
    if (assignBtn) {
        assignBtn.addEventListener('click', assignToMe);
    }

    const switchBtn = document.getElementById('switch-type-btn');
    if (switchBtn) {
        switchBtn.addEventListener('click', switchContactType);
    }

    const addNoteBtn = document.getElementById('add-note-btn');
    if (addNoteBtn) {
        addNoteBtn.addEventListener('click', addNote);
    }

    function loadNotes() {
        const notesList = document.getElementById('notes-list');
        
        fetch(`includes/contact/get_notes.php?contact_id=${contactId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    displayNotes(data.notes);
                } else {
                    console.error('Error loading notes:', data.message);
                    notesList.innerHTML = '<li><p style="color: #d32f2f;">Error loading notes</p></li>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                notesList.innerHTML = '<li><p style="color: #d32f2f;">Failed to load notes</p></li>';
            });
    }

    function displayNotes(notes) {
        const notesList = document.getElementById('notes-list');
        
        if (!notes || notes.length === 0) {
            notesList.innerHTML = '<li><p style="color: #999;">No notes yet</p></li>';
            return;
        }

        let html = '';
        notes.forEach(note => {
            html += `<li>
                <div class="note">
                    <span class="user">${escapeHtml(note.author_name)}</span>
                    <p>${escapeHtml(note.comment)}</p>
                    <span class="date small-font">${formatDate(note.created_at)}</span>
                </div>
            </li>`;
        });

        notesList.innerHTML = html;
    }

    function addNote() {
        const noteText = document.getElementById('note').value.trim();
        
        if (!noteText) {
            alert('Please enter a note');
            return;
        }

        const addNoteBtn = document.getElementById('add-note-btn');
        const originalText = addNoteBtn.textContent;
        addNoteBtn.textContent = 'Adding...';
        addNoteBtn.disabled = true;

        fetch('includes/contact/add_notes.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `contact_id=${encodeURIComponent(contactId)}&comment=${encodeURIComponent(noteText)}`
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                document.getElementById('note').value = '';
                loadNotes();
                alert('Note added successfully!');
            } else {
                alert(data.message || 'Failed to add note');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error adding note. Please try again.');
        })
        .finally(() => {
            addNoteBtn.textContent = originalText;
            addNoteBtn.disabled = false;
        });
    }

    function assignToMe() {
        const btn = document.getElementById('assign-btn');
        const originalText = btn.textContent;
        btn.textContent = 'Assigning...';
        btn.disabled = true;

        fetch('includes/contact/assign_contact.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `contact_id=${encodeURIComponent(contactId)}`
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                document.getElementById('assigned-to').textContent = data.assigned_to || 'Me';
                alert('Contact assigned successfully!');
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
            btn.disabled = false;
        });
    }

    function switchContactType() {
        const btn = document.getElementById('switch-type-btn');
        const originalText = btn.textContent;
        btn.textContent = 'Switching...';
        btn.disabled = true;

        fetch('includes/contact/switch_type.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `contact_id=${encodeURIComponent(contactId)}`
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const newType = data.new_type === 'Sales Lead' ? 'Support' : 'Sales Lead';
                btn.textContent = `Switch to ${newType}`;
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
            btn.textContent = originalText;
            btn.disabled = false;
        });
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
        return date.toLocaleDateString('en-US', options);
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
});