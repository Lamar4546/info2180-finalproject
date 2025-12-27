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

        <div class="flex space-between">
            <h1>Users</h1>
            <button>Add User</button>
        </div>
        
        <div class="box">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>Ms. Jan Levinson</td>
                        <td>jan.levinson@paper.co</td>
                        <td>Member</td>
                        <td>2022-11-13 11:00</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </main>

    <?php include_once 'layouts/footer.php' ?>

</body>

</html>