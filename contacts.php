<?php
session_start();
require_once 'database.php';

header('Content-Type: application/json');

// Clean output buffer
if (ob_get_level()) {
    ob_clean();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized - Please log in']);
    exit;
}

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$user_id = $_SESSION['user_id'];

try {
    $conn = getConnection();
    
    // Build the SQL query - use aliases to match JavaScript expectations
    $sql = "SELECT id, 
                   title,
                   first_name as firstname, 
                   last_name as lastname, 
                   email, 
                   company, 
                   type, 
                   assigned_to 
            FROM contacts 
            WHERE 1=1";
    
    $params = [];
    
    if ($filter === 'Sales Lead') {
        $sql .= " AND type = ?";
        $params[] = 'Sales Lead';
    } elseif ($filter === 'Support') {
        $sql .= " AND type = ?";
        $params[] = 'Support';
    } elseif ($filter === 'assigned') {
        $sql .= " AND assigned_to = ?";
        $params[] = $user_id;
    }
    // If filter is 'all', no additional conditions needed
    
    $sql .= " ORDER BY created_at DESC";
    
    $stmt = $conn->prepare($sql);
    
    if (!empty($params)) {
        $stmt->execute($params);
    } else {
        $stmt->execute();
    }
    
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Return the contacts array
    echo json_encode($contacts);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    exit;
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
    exit;
}
exit;
?>