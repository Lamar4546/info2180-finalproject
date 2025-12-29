<?php
    header('Content-Type: application/json');
    session_start();
    require_once '../../config/database.php';

    // Check if user logged in
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'error' => 'Unauthorized access']);
        exit();
    }
    
    // Only accept POST requests
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['success' => false, 'error' => 'Invalid request']);
        exit();
    }
    
    // Get and validate input
    $contact_id = filter_input(INPUT_POST, 'contact_id', FILTER_VALIDATE_INT);
    $comment = trim(filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING));

    // Validate inputs
    if (!$contact_id) {
        echo json_encode(['success' => false, 'message' => 'Invalid contact ID']);
        exit();
    }

    if ($comment === '') {
        echo json_encode(['success' => false, 'message' => 'Note cannot be empty']);
        exit();
    }

    try {
        // Insert note
        $stmt = $pdo->prepare(
            "INSERT INTO notes (contact_id, comment, created_by)
            VALUES (?, ?, ?)"
        );
        
        $stmt->execute([
            $contact_id,
            $comment,
            $_SESSION['user_id']
        ]); 

        echo json_encode(['success' => true, 'message' => 'Note added']);
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
?>