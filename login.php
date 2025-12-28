<?php
session_start();
require_once 'init.php';

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
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

    <script src="js/user/login.js"></script>

</head>

<body class="login">

    <?php include_once 'layouts/header.php' ?>
    
    <main>

        <h1>Login</h1>

        <form>

            <label for="email-address">Email:</label>
            <input type="email" id="email" name="email-address" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button id="login-button">Login</button>

            <div id="error-message"></div>

        </form>

    </main>

    <?php include_once 'layouts/footer.php' ?>

</body>

</html>