<?php
session_start();
require_once 'init.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styling.css">
    <title>Document</title>

    <script src="js/user/users.js"></script>

</head>

<body class="app">

    <?php include_once 'layouts/header.php' ?>
    <?php include_once 'layouts/menu.php' ?>
    
    <main>

        <div class="flex space-between">
            <h1>Users</h1>
            <a href="new_user.php">Add User</a>
        </div>
        
        <div class="box">
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
                        <td colspan="4">Loading</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </main>

    <?php include_once 'layouts/footer.php' ?>

</body>

</html>