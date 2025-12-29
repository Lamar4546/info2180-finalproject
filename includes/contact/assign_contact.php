<?php
header('Content-Type: application/json');
session_start();
require_once '../../config/database.php';

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
    // Get user's name
    $stmt = $pdo->prepare("SELECT CONCAT(first_name, ' ', last_name) as full_name FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    $assigned_to = $user['full_name'] ?? 'Me';
    
    $stmt = $pdo->prepare(
        "UPDATE contacts 
         SET assigned_to = ?, updated_at = NOW() 
         WHERE id = ?"
    );
    $stmt->execute([$_SESSION['user_id'], $contact_id]);
    
    echo json_encode(['success' => true, 'message' => 'Contact assigned', 'assigned_to' => $assigned_to]);
} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
?>