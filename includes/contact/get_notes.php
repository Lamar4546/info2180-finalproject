<?php
    header('Content-Type: application/json');
    session_start();
    require_once 'database.php';

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
        exit();
    }

    // Get contact ID from query parameter
    if (!isset($_GET['contact_id']) || !is_numeric($_GET['contact_id'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid contact ID']);
        exit();
    }

    $contact_id = (int)$_GET['contact_id'];

    try {
        // Check if contact exists and user has access
        $stmt = $pdo->prepare("SELECT id FROM contacts WHERE id = ?");
        $stmt->execute([$contact_id]);
        
        if (!$stmt->fetch()) {
            echo json_encode(['success' => false, 'message' => 'Contact not found']);
            exit();
        }
        
        // Get notes with author information
        $stmt = $pdo->prepare(
            "SELECT n.id, n.comment, n.created_at, 
                CONCAT(u.first_name, ' ', u.last_name) as author_name,
                u.id as author_id
            FROM notes n
            JOIN users u ON n.created_by = u.id
            WHERE n.contact_id = ?
            ORDER BY n.created_at DESC"
        );

        $stmt->execute([$contact_id]);
        $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode(['success' => true, 'notes' => $notes]);
    } catch (PDOException $e) {
        error_log('Database error in get_notes.php: ' . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error occurred']);
    }
?>