<?php
session_start();
require_once '../../init.php';

ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/app_errors.log'); // path to your log file

header('Content-Type: application/json');

// Check if user is logged in and is an Admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'Admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $firstname = trim(filter_input(INPUT_POST, 'firstname', FILTER_UNSAFE_RAW));
    $lastname = trim(filter_input(INPUT_POST, 'lastname', FILTER_UNSAFE_RAW));
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $role = trim(filter_input(INPUT_POST, 'role', FILTER_UNSAFE_RAW));
    
    // Validate inputs
    if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($role)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit;
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email format']);
        exit;
    }
    
    if (!in_array($role, ['Admin', 'Member'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid role: ' . $role]);
        exit;
    }
    
    try {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            echo json_encode(['success' => false, 'message' => 'Email already exists']);
            exit;
        }
        
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert new user
        $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, password_hash, role, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$firstname, $lastname, $email, $hashedPassword, $role]);
        
        echo json_encode(['success' => true, 'message' => 'User added successfully']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error occurred']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>