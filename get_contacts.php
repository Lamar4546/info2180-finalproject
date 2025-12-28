<?php
ob_start();
session_start();

// Include the database configuration
require_once 'config/database.php';

header('Content-Type: application/json');

// Clean output buffer
if (ob_get_level()) {
    ob_clean();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Unauthorized - Please log in']);
    exit;
}

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$user_id = $_SESSION['user_id'];

try {
    // Use $pdo from config/database.php
    $conn = $pdo;
    
    // Build the SQL query
    $sql = "SELECT id, 
                   title,
                   first_name, 
                   last_name, 
                   email, 
                   company, 
                   type, 
                   assigned_to 
            FROM contacts 
            WHERE 1=1";
    
    $params = [];
    
    // Apply filters
    if ($filter === 'sales') {
        $sql .= " AND type = ?";
        $params[] = 'Sales Lead';
    } elseif ($filter === 'support') {
        $sql .= " AND type = ?";
        $params[] = 'Support';
    } elseif ($filter === 'assigned') {
        $sql .= " AND assigned_to = ?";
        $params[] = $user_id;
    }
    
    $sql .= " ORDER BY created_at DESC";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Return success response
    echo json_encode([
        'success' => true,
        'contacts' => $contacts,
        'filter' => $filter,
        'count' => count($contacts)
    ]);
    
} catch (PDOException $e) {
    error_log("Database error in get_contacts.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'error' => 'Database error occurred'
    ]);
} catch (Exception $e) {
    error_log("Error in get_contacts.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'error' => 'Server error occurred'
    ]);
}
exit;
?>