<?php
header('Content-Type: application/json');
session_start();
require_once 'database.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit();
}

$contact_id = filter_input(INPUT_POST, 'contact_id', FILTER_VALIDATE_INT);
if (!$contact_id) {
    echo json_encode(['success' => false, 'message' => 'Invalid contact ID']);
    exit();
}

try {
    // Get current type
    $stmt = $pdo->prepare("SELECT type FROM contacts WHERE id = ?");
    $stmt->execute([$contact_id]);
    $contact = $stmt->fetch();
    
    if (!$contact) {
        echo json_encode(['success' => false, 'message' => 'Contact not found']);
        exit();
    }
    
    // Toggle type
    $new_type = ($contact['type'] === 'Sales Lead') ? 'Support' : 'Sales Lead';
    
    $stmt = $pdo->prepare(
        "UPDATE contacts 
         SET type = ?, updated_at = NOW() 
         WHERE id = ?"
    );
    $stmt->execute([$new_type, $contact_id]);
    
    echo json_encode(['success' => true, 'new_type' => $new_type]);
} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
?>