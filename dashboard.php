<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styling.css">
    <title>Dashboard</title>

</head>

<body>

    <?php include_once 'layouts/header.php' ?>
    <?php include_once 'layouts/menu.php' ?>
    
    <main>

        <h1>Users</h1>
        <button>Add User</button>

        <div class="wrapper">

            <div id="filter">
                Filter by: 
                <button>All</button>
                <button>Sales Leads</button>
                <button>Support</button>
                <button>Assigned to me</button>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Company</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>Ms. Jan Levinson</td>
                        <td>jan.levinson@paper.co</td>
                        <td>The Paper Company</td>
                        <td><span class="sales">SALES LEAD</span></td>
                        <td><a href="#">View</a></td>
                    </tr>
                </tbody>
            </table>
        </div>

    </main>

    <?php include_once 'layouts/footer.php' ?>

</body>

</html>