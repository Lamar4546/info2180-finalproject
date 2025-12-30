<?php
session_start();

// Try to find the correct database connection file
if (file_exists(__DIR__ . '/init.php')) {
    require_once __DIR__ . '/init.php';
} elseif (file_exists(__DIR__ . '/database.php')) {
    require_once __DIR__ . '/database.php';
} else {
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Configuration error: database connection file not found']);
    exit;
}

// Force JSON response and clear any previous output
header('Content-Type: application/json');
if (ob_get_level()) { ob_clean(); }

// Disable displaying errors to user, log instead
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

// Check login
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized. Please log in.']);
    exit;
}

// Only POST allowed
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Collect and sanitize inputs
$title       = trim($_POST['title'] ?? '');
$first_name  = trim($_POST['first_name'] ?? '');
$last_name   = trim($_POST['last_name'] ?? '');
$email       = trim($_POST['email'] ?? '');
$phone       = trim($_POST['telephone'] ?? '');
$company     = trim($_POST['company'] ?? '');
$type        = trim($_POST['type'] ?? '');
$assigned_to = intval($_POST['assigned_to'] ?? 0);

// Validate required fields
if (!$title || !$first_name || !$last_name || !$email || !$phone || !$company || !$type || !$assigned_to) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email format']);
    exit;
}

// Validate title and type
$valid_titles = ['Mr', 'Ms', 'Mrs', 'Dr', 'Prof'];
$valid_types  = ['Sales Lead', 'Support'];

if (!in_array($title, $valid_titles)) {
    echo json_encode(['success' => false, 'message' => 'Invalid title']);
    exit;
}

if (!in_array($type, $valid_types)) {
    echo json_encode(['success' => false, 'message' => 'Invalid contact type']);
    exit;
}

try {
    // Get database connection - check which variable is available
    if (isset($pdo)) {
        $conn = $pdo;
    } elseif (isset($conn)) {
        // $conn already exists from init/database file
    } else {
        throw new Exception('Database connection not available');
    }

    // Check for existing email
    $stmt = $conn->prepare("SELECT id FROM contacts WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        echo json_encode(['success' => false, 'message' => 'A contact with this email already exists']);
        exit;
    }

    // Check assigned user exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE id = ?");
    $stmt->execute([$assigned_to]);
    if (!$stmt->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Invalid assigned user']);
        exit;
    }

    // Insert contact
    $stmt = $conn->prepare("
        INSERT INTO contacts 
        (title, first_name, last_name, email, phone, company, type, assigned_to, created_by, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
    ");

    $stmt->execute([$title, $first_name, $last_name, $email, $phone, $company, $type, $assigned_to, $_SESSION['user_id']]);

    echo json_encode(['success' => true, 'message' => 'Contact added successfully', 'contact_id' => $conn->lastInsertId()]);

} catch (PDOException $e) {
    error_log("Database error in add_contact.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error']);
} catch (Exception $e) {
    error_log("Error in add_contact.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
exit;
?>