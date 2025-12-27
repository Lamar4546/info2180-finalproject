// Keep track of the currently selected contact
let currentContactId = null;

// Load all notes for a contact
function loadNotes(contactId) {
    currentContactId = contactId;
    fetch(`get_notes.php?contact_id=${contactId}`)
        .then(response => response.json())
        .then(data => {
            const notesList = document.getElementById('notes-list');
            notesList.innerHTML = '';

            if (!data.success) {
                notesList.innerHTML = '<p>Error loading notes.</p>';
                return;
            }

            if (data.notes.length === 0) {
                notesList.innerHTML = '<p>No notes yet.</p>';
                return;
            }

            data.notes.forEach(note => {
                const noteDiv = document.createElement('div');
                noteDiv.classList.add('note');

                noteDiv.innerHTML = `
                    <p>${escapeHTML(note.comment)}</p>
                    <small>
                        By ${note.author_name} on 
                        ${new Date(note.created_at).toLocaleString()}
                    </small>
                `;

                notesList.appendChild(noteDiv);
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

// Add a new note for the current contact
function addNote() {
    if (!currentContactId) {
        alert('No contact selected.');
        return;
    }

    const textarea = document.getElementById('note-text');
    const comment = textarea.value.trim();

    if (comment === '') {
        alert('Note cannot be empty.');
        return;
    }

    fetch('add_note.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            contact_id: currentContactId,
            comment: comment
        })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            alert('Failed to add note.');
            return;
        }

        textarea.value = '';
        loadNotes(currentContactId);
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Prevent XSS when rendering user input
function escapeHTML(str) {
    return str.replace(/[&<>"']/g, function (match) {
        const escape = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#39;'
        };
        return escape[match];
    });
}

// Event listener for Add Note button
document.addEventListener('DOMContentLoaded', () => {
    const addBtn = document.getElementById('add-note-btn');
    if (addBtn) {
        addBtn.addEventListener('click', addNote);
    }
});
