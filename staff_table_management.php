<?php
$con = mysqli_connect("localhost", "root", "", "canteen");
if (!$con) {
    die("Database not connected: " . mysqli_connect_error());
}

if (isset($_POST['add_table'])) {
    $table_number = $_POST['table_number'];
    $capacity = $_POST['capacity'];
    $status = $_POST['status'];

    $sql = "INSERT INTO tables (table_number, capacity, status) VALUES ('$table_number', '$capacity', '$status')";
    if (mysqli_query($con, $sql)) {
        echo "New table added!";
        header('Location: staff_table_management.php');
        exit();
    } else {
        echo "Error: " . mysqli_error($con);
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $deleteSql = "DELETE FROM tables WHERE id='$id'";
    if (mysqli_query($con, $deleteSql)) {
        echo "Table deleted!";
        header('Location: staff_table_management.php');
        exit();
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Tables</title>
    <link rel="stylesheet" href="table_management.css">
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
    <h1>Manage Tables</h1>
    <form method="post">
        <input type="number" placeholder="Table Number" name="table_number" required><br>
        <input type="number" placeholder="Capacity" name="capacity" required><br>
        <select name="status" required>
            <option value="">Select Status</option>
            <option value="Available">Available</option>
            <option value="Booked">Booked</option>
        </select><br>
        <button type="submit" name="add_table">Add Table</button>
    </form>

    <h3>Current Tables</h3>
    <table>
        <thead>
            <tr>
                <th>Table Number</th>
                <th>Capacity</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $tables = mysqli_query($con, "SELECT * FROM tables");
            if (mysqli_num_rows($tables) > 0) {
                while ($row = mysqli_fetch_assoc($tables)) {
                    echo "<tr>
                            <td>{$row['table_num']}</td>
                            <td>{$row['capacity']}</td>
                            <td>{$row['status']}</td>
                            <td><a href='?delete={$row['id']}' onclick='return confirm(\"Are you sure you want to delete this table?\");'>Delete</a></td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No tables found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>

</html>
