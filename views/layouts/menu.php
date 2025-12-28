<?php
// Make sure session is started if not already
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="menu">
    <a href="dashboard.php">Home</a>
    <a href="new_contact.php">New Contact</a>

    <?php if (!empty($_SESSION['user_role']) && strtolower($_SESSION['user_role']) === 'admin'): ?>
        <a href="user_list.php">Users</a>
    <?php endif; ?>

    <a href="../logout.php">Logout</a>
</nav>