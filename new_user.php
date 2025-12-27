<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styling.css">
    <title>Document</title>

</head>

<body class="app">

    <?php include_once 'layouts/header.php' ?>
    <?php include_once 'layouts/menu.php' ?>
    
    <main>

        <h1>New User</h1>

        <form action="" method="post" class="box">

            <div class="form-field no-margin">
                <label for="first-name">First Name:</label>
                <input type="text" id="first-name" name="first-name" required>
            </div>

            <div class="form-field no-margin">
                <label for="last-name">Last Name:</label>
                <input type="text" id="last-name" name="last-name" required>
            </div>
                
            <div class="form-field">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
                
            <div class="form-field">
                <label for="password">Password:</label> 
                <input type="password" id="password" name="password" required>
            </div>
                
            <div class="form-field">
                <label for="role">Role</label>
                <select id="role" name="role">
                    <option value="admin">Admin</option>
                    <option value="member">Member</option>
                </select>
            </div>

            <div class="form-field full">
                <button class="auto-right" type="submit">Save</button>
            </div>

        </form>

    </main>

    <?php include_once 'layouts/footer.php' ?>

</body>

</html>