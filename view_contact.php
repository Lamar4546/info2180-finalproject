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
    <title>View Contact</title>

</head>

<body class="app">

    <?php include_once 'layouts/header.php' ?>
    <?php include_once 'layouts/menu.php' ?>
    
    <main>

        <div class="flex space-between">

            <h1>Mr. Michael Scott</h1>

            <div>

                <button>Assign to me</button>
                <button>Switch to Sales Lead</button>

            </div>

        </div>

        <p class="small-font">
            Created on November 9, 2022 by David Wallace <br>
            Updated on November 13, 2022
        </p>

        <div class="box wrapper">

            <div class="wrap-item no-margin">
                <span>Email</span>
                michael.scott@paper.co
            </div>

            <div class="wrap-item no-margin">
                <span>Telephone</span>
                876-999-9999
            </div>

            <div class="wrap-item">
                <span>Company</span>
                The Paper Company
            </div>

            <div class="wrap-item">
                <span>Assigned To</span>
                Jen Levinson
            </div>

        </div>

        <div class="box">

            <h2>Notes</h2>

            <ul class="notes">

                <li>

                    <div class="note">

                        <span class="user">Jane Doe</span>

                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed nisl lectus, viverra id risus ac,
                            ornare rutrum quam. In rhoncus.
                        </p>

                        <span class="date small-font">November 10, 2022 at 4pm</span>

                    </div>

                </li>

                <li>

                    <div class="note">

                        <span class="user">Jane Doe</span>

                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed nisl lectus, viverra id risus ac,
                            ornare rutrum quam. In rhoncus.
                        </p>

                        <span class="date small-font">November 10, 2022 at 4pm</span>

                    </div>

                </li>

            </ul>

            <div id="add-note">

                <span class="bold">Add a note about Michael</span>

                <textarea name="note" id="note"></textarea>
                <button class="auto-right">Add Note</button>

            </div>

        </div>

    </main>

    <?php include_once 'layouts/footer.php' ?>

</body>

</html>