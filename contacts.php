<?php
session_start();
require_once 'database.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$conn = getConnection();
$user_id = $_SESSION['user_id'];
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

try {
    // Build the SQL query based on filter
    $sql = "SELECT id, title, firstname, lastname, email, company, type, assigned_to 
            FROM Contacts 
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
    
    echo json_encode($contacts);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>