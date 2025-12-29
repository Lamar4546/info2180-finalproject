<?php
session_start();
require_once 'init.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styling.css">
    <title>Dashboard</title>

    <script src="js/contact/dashboard.js"></script>

</head>

<body class="app">

    <?php include_once 'layouts/header.php' ?>
    <?php include_once 'layouts/menu.php' ?>
    
    <main>

        <div class="flex space-between">
            <h1>Dashboard</h1>
            <a href="new_contact.php">Add Contact</a>
        </div>

        <div class="box">
            <div id="filter">
                Filter by: 
                <button class="filter-btn active" data-filter="all">All</button>
                <button class="filter-btn" data-filter="sales">Sales Leads</button>
                <button class="filter-btn" data-filter="support">Support</button>
                <button class="filter-btn" data-filter="assigned">Assigned to me</button>
            </div>

            <table id="contacts-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Company</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody id="contacts-tbody">
                    <!-- Static example data that stays -->
                    <tr>
                        <td>Ms. Jan Levinson</td>
                        <td>jan.levinson@paper.co</td>
                        <td>The Paper Company</td>
                        <td><span class="sales">SALES LEAD</span></td>
                        <td><a href="#" class="purple">View</a></td>
                    </tr>

                    <tr>
                        <td>Ms. Jan Levinson</td>
                        <td>jan.levinson@paper.co</td>
                        <td>The Paper Company</td>
                        <td><span class="support">SUPPORT</span></td>
                        <td><a href="#" class="purple">View</a></td>
                    </tr>
                    <!-- Dynamic contacts will be added below -->
                </tbody>
            </table>
        </div>

    </main>

    <?php include_once 'layouts/footer.php' ?>
    
    <script>
        const userId = <?php echo $user_id; ?>;
    </script>

</body>

</html>