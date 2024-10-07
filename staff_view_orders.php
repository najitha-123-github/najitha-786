<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders</title>
    <link rel="stylesheet" href="view_orders.css">
</head>

<body>
<nav>
            <ul>
                <li><a href="staffdash.php">Dashboard</a></li>
                <li><a href="staff_menu_management.php">Manage Menu</a></li>
                <li><a href="staff_table_management.php">Manage Tables</a></li>
                <li><a href="staff_view_orders.php">View Orders</a></li>
                <li><a href="index.html">Logout</a></li>
            </ul>
        </nav>
    <h1>View Orders</h1>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Items</th>
                <th>Status</th>
                <th>Customer</th>
                <th>Table Number</th>
            </tr>
        </thead>
        <tbody>
            <!-- PHP code to fetch and display orders -->
            <?php
            $orders = mysqli_query($con, "SELECT * FROM orders");
            if (mysqli_num_rows($orders) > 0) {
                while ($row = mysqli_fetch_assoc($orders)) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['items']}</td>
                            <td>{$row['status']}</td>
                            <td>{$row['customer']}</td>
                            <td>{$row['table_number']}</td>
                          </tr>";
                }
            }
            ?>
        </tbody>
    </table>
</body>

</html>
