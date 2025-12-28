<?php
session_start();
require_once '../database.php';

// Check if user is logged in and is Admin
if (!isset($_SESSION['user_id']) || strtolower($_SESSION['user_role']) !== 'admin') {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">
    <title>Users - Dolphin CRM</title>
</head>

<body>

    <?php include_once 'layouts/header.php' ?>
    <?php include_once 'layouts/menu.php' ?>
    
    <main>
        <div class="page-header">
            <h1>Users</h1>
            <button class="btn-add-user" onclick="location.href='../add_user.html'">
                <span>+</span> Add User
            </button>
        </div>
        
        <div class="wrapper">
            <table class="contacts-table">
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
                        <td colspan="4">Loading users...</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </main>

    <?php include_once 'layouts/footer.php' ?>
    <script src="../js/users.js"></script>

</body>

</html>