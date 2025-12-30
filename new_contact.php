<?php
session_start();
require_once 'init.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
try {
    $stmt = $pdo->query("SELECT id, first_name, last_name FROM users ORDER BY first_name, last_name");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $users = [];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styling.css">
    <title>New Contact</title>

</head>

<body class="app">

    <?php include_once 'layouts/header.php' ?>
    <?php include_once 'layouts/menu.php' ?>
    
    <main>

        <h1>New Contact</h1>

        <div id="message"></div>

        <form action="" method="post" class="box">

            <div class="form-field full no-margin">
                <label for="title">Title</label>
                <select id="title" name="title" class="auto-left auto-width">
                    <option value="Mr">Mr</option>
                    <option value="Ms">Ms</option>
                    <option value="Mrs">Mrs</option>
                </select>
            </div>

            <div class="form-field">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" required>
            </div>

            <div class="form-field">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" required>
            </div>

            <div class="form-field">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-field">
                <label for="telephone">Telephone:</label>
                <input type="tel" id="telephone" name="telephone" required>
            </div>

            <div class="form-field">
                <label for="company">Company:</label>
                <input type="text" id="company" name="company" required>
            </div>

            <div class="form-field">
                <label for="type">Type</label>
                <select id="type" name="type">
                    <option value="Sales Lead">Sales Lead</option>
                    <option value="Support">Support</option>
                </select>
            </div>

         
                <div class="form-field">
                <label for="assigned_to">Assigned To</label>
                <select id="assigned_to" name="assigned_to" required>
                    <option value="">Select a user</option>
                    <!-- Hardcoded options -->
                    <option value="4">Andy Bernard</option>
                    <option value="5">Joshua Smith</option>
                    <!-- Dynamic users from database -->
                    <?php foreach ($users as $user): ?>
                        <?php 
                        // Skip if ID is 1 or 2 to avoid duplicates
                        if ($user['id'] == 4 || $user['id'] == 5) continue;
                        ?>
                        <option value="<?php echo htmlspecialchars($user['id']); ?>">
                            <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-field full">    
                <button type="submit" class="auto-right">Save</button>
            </div>

        </form>

    </main>

    <?php include_once 'layouts/footer.php' ?>
    <script src="js/user/new_contact.js"></script>

</body>

</html>
