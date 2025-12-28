<!DOCTYPE html>
<html lang="en">

<head>
<<<<<<< HEAD
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styling.css">
    <link rel="stylesheet" href="notes.css">
    <link rel="stylesheet" href="more_styles.css">
    <title>View Contact</title>
</head>

<body class="app" data-contact-id="<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id']) : ''; ?>">
=======

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styling.css">
    <title>View Contact</title>

</head>

<body class="app">
>>>>>>> main

    <?php include_once 'layouts/header.php' ?>
    <?php include_once 'layouts/menu.php' ?>
    
    <main>
<<<<<<< HEAD
        <div class="flex space-between">
            <h1>Mr. Michael Scott</h1>
            <div>
                <button id="assign-btn">Assign to me</button>
                <button id="switch-type-btn">Switch to Sales Lead</button>
            </div>
=======

        <div class="flex space-between">

            <h1>Mr. Michael Scott</h1>

            <div>

                <button>Assign to me</button>
                <button>Switch to Sales Lead</button>

            </div>

>>>>>>> main
        </div>

        <p class="small-font">
            Created on November 9, 2022 by David Wallace <br>
            Updated on November 13, 2022
        </p>

        <div class="box wrapper">
<<<<<<< HEAD
=======

>>>>>>> main
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
<<<<<<< HEAD
                <span id="assigned-to">Jen Levinson</span>
            </div>
        </div>

        <div class="box">
            <h2>Notes</h2>

            <ul class="notes" id="notes-list">
                <!-- Notes will be loaded here via AJAX -->
                <li>
                    <div class="note">
                        <p>Loading notes...</p>
                    </div>
                </li>
            </ul>

            <div id="add-note">
                <span class="bold">Add a note about Michael</span>
                <textarea name="note" id="note" placeholder="Enter your note here..."></textarea>
                <button class="auto-right" id="add-note-btn">Add Note</button>
            </div>
=======
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

>>>>>>> main
        </div>

    </main>

    <?php include_once 'layouts/footer.php' ?>
<<<<<<< HEAD
    
    <script src="notes.js"></script>
    <script src="contact_ajax.js"></script>
</body>
=======

</body>

>>>>>>> main
</html>