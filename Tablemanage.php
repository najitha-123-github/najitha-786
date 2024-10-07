<?php
$con = mysqli_connect("localhost", "root", "", "canteen");
if (!$con) {
    echo "Database not connected";
}

// Adding a new table
if (isset($_POST['add_table'])) {
    $table_num = $_POST['table_num'];
    $capacity = $_POST['capacity'];
    $status = $_POST['status'];

    $sql = "INSERT INTO tables (table_num, capacity, status) VALUES ('$table_num', '$capacity', '$status')";
    if (mysqli_query($con, $sql)) {
        echo "New table added!";
        header('Location: Tablemanage.php');
    } else {
        echo "Error: " . mysqli_error($con);
    }
}

// Fetch all tables
$allTables = mysqli_query($con, "SELECT * FROM tables");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table Management</title>
    <link rel="stylesheet" href="tablemanage.css">
</head>

<body>
    <nav>
        <ul>
            <li><a href="admindash.php">Dashboard</a></li>
            <li><a href="user_management.php">User Management</a></li>
            <li><a href="staff_management.php">Staff Management</a></li>
            <li><a href="#orders">Order Management</a></li>
            <li><a href="Tablemanage.php">Table Management</a></li>
            <li><a href="m">Menu Management</a></li>
            <li><a href="index.html">Logout</a></li>

        </ul>
    </nav>

    <div class="container">
        <!-- Table Management Section -->
        <section id="tables">
            <h2>Table Management</h2>
            <form method="post">
                <input type="number" placeholder="Table Number" name="table_num" required><br>
                <input type="number" placeholder="Capacity" name="capacity" required><br>
                <select name="status" required>
                    <option value="unbooked">Unbooked</option>
                    <option value="booked">Booked</option>
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
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($allTables) > 0) {
                        while ($row = mysqli_fetch_assoc($allTables)) {
                            echo "<tr>
                                    <td>{$row['table_num']}</td>
                                    <td>{$row['capacity']}</td>
                                    <td>{$row['status']}</td>
                                  </tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </div>

</body>

</html>
