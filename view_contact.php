<?php
session_start();
require_once 'init.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get contact ID from query parameter
$contact_id = isset($_GET['id']) ? (int)$_GET['id'] : null;

if (!$contact_id) {
    header('Location: dashboard.php');
    exit;
}

// Fetch contact details
require_once 'config/database.php';

try {
    $stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = ?");
    $stmt->execute([$contact_id]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$contact) {
        header('Location: dashboard.php');
        exit;
    }
} catch (PDOException $e) {
    error_log('Database error: ' . $e->getMessage());
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styling.css">
    <title>View Contact</title>
</head>

<body class="app" data-contact-id="<?php echo htmlspecialchars($contact_id); ?>">

    <?php include_once 'layouts/header.php' ?>
    <?php include_once 'layouts/menu.php' ?>
    
    <main>
        <div class="flex space-between">
            <h1><?php echo htmlspecialchars($contact['title']); ?>. <?php echo htmlspecialchars($contact['first_name']); ?> <?php echo htmlspecialchars($contact['last_name']); ?></h1>
            <div>
                <button id="assign-btn">Assign to me</button>
                <button id="switch-type-btn">Switch to <?php echo $contact['type'] === 'Sales Lead' ? 'Support' : 'Sales Lead'; ?></button>
            </div>
        </div>

        <p class="small-font">
            Created on <span id="created-date"><?php echo isset($contact['created_at']) ? date('F j, Y', strtotime($contact['created_at'])) : 'N/A'; ?></span> by <span id="created-by">N/A</span> <br>
            Updated on <span id="updated-date"><?php echo isset($contact['updated_at']) ? date('F j, Y', strtotime($contact['updated_at'])) : 'N/A'; ?></span>
        </p>

        <div class="box wrapper">
            <div class="wrap-item no-margin">
                <span>Email</span>
                <?php echo htmlspecialchars($contact['email']); ?>
            </div>

            <div class="wrap-item no-margin">
                <span>Telephone</span>
                <?php echo htmlspecialchars($contact['phone']); ?>
            </div>

            <div class="wrap-item">
                <span>Company</span>
                <?php echo htmlspecialchars($contact['company']); ?>
            </div>

            <div class="wrap-item">
                <span>Assigned To</span>
                <span id="assigned-to"><?php echo isset($contact['assigned_to']) ? htmlspecialchars($contact['assigned_to']) : 'Unassigned'; ?></span>
            </div>
        </div>

        <div class="box">
            <h2>Notes</h2>
            <ul class="notes" id="notes-list">
            </ul>

            <div id="add-note">
                <span class="bold">Add a note about <?php echo htmlspecialchars($contact['first_name']); ?></span>
                <textarea name="note" id="note"></textarea>
                <button class="auto-right" id="add-note-btn">Add Note</button>
            </div>
        </div>
    </main>

    <?php include_once 'layouts/footer.php' ?>
    <script src="_temp/all_contact/ajax.js"></script>
</body>

</html>