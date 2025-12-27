<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styling.css">
    <title>Document</title>

</head>

<body class="login">

    <?php include_once 'layouts/header.php' ?>
    
    <main>

        <h1>Login</h1>

        <form action="" method="post">

            <label for="email-address">Email:</label>
            <input type="email" id="email-address" name="email-address" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button>Login</button>

        </form>

    </main>

    <?php include_once 'layouts/footer.php' ?>

</body>

</html>