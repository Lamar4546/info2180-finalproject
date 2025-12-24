<?php
session_start();
require_once 'database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Dolphin CRM</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard-container">
        <header>
            <h1>Dolphin CRM Dashboard</h1>
            <div class="user-info">
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['user_firstname'] . ' ' . $_SESSION['user_lastname']); ?></span>
                <a href="logout.php">Logout</a>
            </div>
        </header>
        
        <?php if ($_SESSION['user_role'] === 'Admin'): ?>
        <div class="users-container">
            <h2>Users</h2>
            <button id="addUserBtn" onclick="location.href='add_user.html'">Add User</button>
            
            <table id="usersTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody id="usersTableBody">
                    <tr>
                        <td colspan="4">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="content">
            <h2>Welcome to Dolphin CRM</h2>
            <p>You are logged in as a <?php echo htmlspecialchars($_SESSION['user_role']); ?>.</p>
        </div>
        <?php endif; ?>
    </div>

    <?php if ($_SESSION['user_role'] === 'Admin'): ?>
    <script src="js/users.js"></script>
    <?php endif; ?>
</body>
</html>