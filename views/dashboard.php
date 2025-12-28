<?php
session_start();
require_once '../database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.html');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">
    <title>Dashboard - Dolphin CRM</title>
</head>
<body>
    <?php include_once 'layouts/header.php' ?>
    <?php include_once 'layouts/menu.php' ?>
    
    <main>
        <div class="page-header">
            <h1>Dashboard</h1>
            <button class="btn-add-contact" onclick="location.href='new_contact.php'">
                <span>+</span> Add Contact
            </button>
        </div>

        <div class="wrapper">
            <div id="filter">
                <span class="filter-icon">▼</span> Filter by: 
                <button class="filter-btn active" data-filter="all">All</button>
                <button class="filter-btn" data-filter="Sales Lead">Sales Leads</button>
                <button class="filter-btn" data-filter="Support">Support</button>
                <button class="filter-btn" data-filter="assigned">Assigned to me</button>
            </div>

            <table class="contacts-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Company</th>
                        <th>Type</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody id="contactsTableBody">
                    <tr>
                        <td colspan="5">Loading contacts...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <?php include_once 'layouts/footer.php' ?>
    <script src="../js/dashboard.js"></script>
</body>
</html>