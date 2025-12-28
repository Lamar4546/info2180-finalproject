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
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized. Please log in.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Get and sanitize input
$title = isset($_POST['title']) ? trim($_POST['title']) : '';
$first_name = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
$last_name = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone = isset($_POST['telephone']) ? trim($_POST['telephone']) : ''; // Form uses 'telephone' but DB uses 'phone'
$company = isset($_POST['company']) ? trim($_POST['company']) : '';
$type = isset($_POST['type']) ? trim($_POST['type']) : '';
$assigned_to = isset($_POST['assigned_to']) ? intval($_POST['assigned_to']) : 0;

// Validation
if (empty($title) || empty($first_name) || empty($last_name) || empty($email) || 
    empty($phone) || empty($company) || empty($type) || $assigned_to <= 0) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email format']);
    exit;
}

// Validate type
if (!in_array($type, ['Sales Lead', 'Support'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid contact type']);
    exit;
}

// Validate title
if (!in_array($title, ['Mr', 'Mrs', 'Ms', 'Dr', 'Prof'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid title']);
    exit;
}

try {
    $conn = getConnection();
    
    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM contacts WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->fetch()) {
        echo json_encode(['success' => false, 'message' => 'A contact with this email already exists']);
        exit;
    }
    
    // Check if assigned user exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE id = ?");
    $stmt->execute([$assigned_to]);
    
    if (!$stmt->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Invalid assigned user']);
        exit;
    }
    
    // Insert new contact - match your exact table structure
    $stmt = $conn->prepare("INSERT INTO contacts 
                            (title, first_name, last_name, email, phone, company, type, assigned_to, created_by, created_at, updated_at) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
    
    $created_by = $_SESSION['user_id'];
    
    $stmt->execute([
        $title, 
        $first_name, 
        $last_name, 
        $email, 
        $phone, 
        $company, 
        $type, 
        $assigned_to, 
        $created_by
    ]);
    
    echo json_encode([
        'success' => true, 
        'message' => 'Contact added successfully',
        'contact_id' => $conn->lastInsertId()
    ]);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
exit;
?>