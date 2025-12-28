
document.addEventListener('DOMContentLoaded', function() {
    const contactId = getContactId(); // Get contact ID from URL or data attribute
    
    if (contactId) {
        loadNotes(contactId);
        setupNoteForm(contactId);
    }
});

// Extract contact ID from URL or data attribute
function getContactId() {
    // Check if contact ID is in a data attribute
    const contactElement = document.querySelector('[data-contact-id]');
    if (contactElement && contactElement.dataset.contactId)
        return contactElement.dataset.contactId;
    
    // Extract from URL (e.g., view_contact.php?id=1)
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get('id');
}

// Load notes for a contact via AJAX
function loadNotes(contactId) {
    const notesList = document.getElementById('notes-list') || document.querySelector('.notes');
    if (notesList)
        notesList.classList.add('loading');
    
    fetch(`get_notes.php?contact_id=${contactId}`)
        .then(response => {
            if (!response.ok)
                throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                displayNotes(data.notes);
            } else {
                alert(data.message || 'Failed to load notes');
            }
        })
        .catch(error => {
            console.error('Error loading notes:', error);
            alert('Error loading notes. Please try again.');
        })
        .finally(() => {
            if (notesList)
                notesList.classList.remove('loading');
        });
}

// Display notes in the notes list
function displayNotes(notes) {
    const notesList = document.getElementById('notes-list') || document.querySelector('.notes');
    if (!notesList) return;
    
    notesList.innerHTML = '';
    
    if (!notes || notes.length === 0) {
        notesList.innerHTML = '<ul><div class="note"><p>No notes yet.</p></div></ul>';
        return;
    }
    
    notes.forEach(note => {
        const noteElement = createNoteElement(note);
        notesList.appendChild(noteElement);
    });
}

// Create HTML element for a single note
function createNoteElement(note) {
    const ulElement = document.createElement('ul');
    const date = new Date(note.created_at).toLocaleString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
    
    ulElement.innerHTML = `
        <div class="note">
            <span class="user bold">${escapeHTML(note.author_name)}</span>
            <p>${escapeHTML(note.comment)}</p>
            <span class="date small-font">${date}</span>
        </div>
    `;
    
    return ulElement;
}

// Set up note form with AJAX submission
function setupNoteForm(contactId) {
    const form = document.getElementById('add-note');
    const textarea = document.getElementById('note');
    const submitBtn = document.querySelector('#add-note button');
    
    if (!form || !textarea || !submitBtn) return;
    
    // Get fresh references after clone
    const newTextarea = document.getElementById('note');
    const newSubmitBtn = document.querySelector('#add-note button');
    
    newSubmitBtn.addEventListener('click', function(e) {
        e.preventDefault();
        addNote(contactId, newTextarea.value.trim());
    });
    
    // Allow Ctrl+Enter or Cmd+Enter to submit
    newTextarea.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
            e.preventDefault();
            addNote(contactId, newTextarea.value.trim());
        }
    });
}

// Add new note via AJAX
function addNote(contactId, comment) {
    if (!comment.trim()) {
        alert('Please enter a note before submitting.');
        return;
    }
    
    const submitBtn = document.querySelector('#add-note button');
    const originalText = submitBtn.textContent;
    submitBtn.textContent = 'Adding...';
    submitBtn.disabled = true;
    
    const formData = new FormData();
    formData.append('contact_id', contactId);
    formData.append('comment', comment);
    
    fetch('add_notes.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('note').value = ''; // Clear textarea
            loadNotes(contactId); // Reload notes
            alert('Note added successfully!');
        } else {
            alert(data.message || 'Failed to add note');
        }
    })
    .catch(error => {
        console.error('Error adding note:', error);
        alert('Error adding note. Please try again.');
    })
    .finally(() => {
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
    });
}

// Escape HTML to prevent XSS
function escapeHTML(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}