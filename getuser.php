<?php
session_start();
require_once 'database.php';

header('Content-Type: application/json');

$stmt = $pdo->query("SELECT id, first_name, last_name FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($users);

?>