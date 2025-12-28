<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">
    <title>New Contact</title>

</head>

<body>

    <?php include_once 'layouts/header.php' ?>
    <?php include_once 'layouts/menu.php' ?>
    
    <main>

        <h1>New Contact</h1>

        <div class="wrapper">

            <form action="" method="post">
                <label for="title">Title:</label>
                <select id="title" name="title">
                    <option value="Mr">Mr</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Ms">Ms</option>
                </select>

                <br>

                <label for="first-name">First Name:</label>
                <input type="text" id="first-name" name="first-name" required>

                <br>

                <label for="last-name">Last Name:</label>
                <input type="text" id="last-name" name="last-name" required>

                <br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <br>

                <label for="telephone">Telephone:</label>
                <input type="tel" id="telephone" name="telephone" required>

                <br>

                <label for="company">Company:</label>
                <input type="text" id="company" name="company" required>

                <br>

                <label for="type">Type</label>
                <select id="type" name="type">
                    <option value="sales-lead">Sales Lead</option>
                    <option value="support">Support</option>
                </select>

                <br>

                <label for="assigned-to">Assigned To</label>
                <select id="assigned-to" name="assigned-to">
                    <option value="Andy">Andy Bernard</option>
                    <option value="Joshua">Joshua Smith</option>
                </select>

                <br>

                <button type="submit">Save</button>

            </form>

        </div>

    </main>

    <?php include_once 'layouts/footer.php' ?>

</body>

</html>