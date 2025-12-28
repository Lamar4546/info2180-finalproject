<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Document</title>

</head>

<body>

    <?php include_once 'layouts/header.php' ?>
    <?php include_once 'layouts/menu.php' ?>
    
    <main>

        <h1>New User</h1>

        <form action="" method="post">

            <label for="first-name">First Name:</label>
            <input type="text" id="first-name" name="first-name" required>

            <br>

            <label for="last-name">Last Name:</label>
            <input type="text" id="last-name" name="last-name" required>

            <br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <br>

            <label for="role">Role</label>
            <select id="role" name="role">
                <option value="admin">Admin</option>
                <option value="member">Member</option>
            </select>

            <br>

            <button type="submit">Save</button>

        </form>

    </main>

    <?php include_once 'layouts/footer.php' ?>

</body>

</html>