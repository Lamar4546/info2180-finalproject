<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>View Contact</title>

</head>

<body>

    <?php include_once 'layouts/header.php' ?>
    <?php include_once 'layouts/menu.php' ?>
    
    <main>

        <h1>Mr. Michael Scott</h1>
        <button>Assign to me</button>
        <button>Switch to Sales Lead</button>

        <div class="wrapper">

            <div>
                <span>Email</span>
                michael.scott@paper.co
            </div>

            <div>
                <span>Telephone</span>
                876-999-9999
            </div>

            <div>
                <span>Company</span>
                The Paper Company
            </div>

            <div>
                <span>Assigned To</span>
                Jen Levinson
            </div>

        </div>

        <div class="box">

            <div class="wrapper">

                <ul>

                    <li>

                        <div class="title">Notes</div>

                            <div class="note">

                                <span class="user">Jane Doe</span>

                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed nisl lectus, viverra id risus ac,
                                    ornare rutrum quam. In rhoncus.
                                </p>

                                <span class="date">November 10, 2022 at 4pm</span>

                            </div>

                    </li>

                </ul>

            </div>

            Add a note about Michael

            <textarea name="note" id="note"></textarea>
            <button>Add Note</button>

        </div>

    </main>

    <?php include_once 'layouts/footer.php' ?>

</body>

</html>