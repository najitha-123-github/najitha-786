<?php
$con = mysqli_connect("localhost", "root", "", "canteen");
if (!$con) {
    echo "Database not connected";
}

// Fetch users
$users = mysqli_query($con, "SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="admindash.css">
</head>

<body>
<nav>
        <ul>
            <li><a href="admindash.php">Dashboard</a></li>
            <li><a href="user_management.php">User Management</a></li>
            <li><a href="staff_management.php">Staff Management</a></li>
            <li><a href="#orders">Order Management</a></li>
            <li><a href="m.php">Menu Management</a></li>
            <li><a href="Tablemanage.php">Table Management</a></li>
            <li><a href="index.html">Logout</a></li>
        </ul>
    </nav>

    <div class="container">
        <!-- User Management Section -->
        <section id="users">
            <h2>User Management</h2>
            <table>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Email</th>
                        <th>User Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($users) > 0) {
                        while ($row = mysqli_fetch_assoc($users)) {
                            echo "<tr>
                                    <td>{$row['userid']}</td>
                                    <td>{$row['email']}</td>
                                    <td>{$row['usertype']}</td>
                                    <td>
                                        <form method='post'>
                                            <input type='hidden' name='user_id' value='{$row['userid']}'>
                                            <button type='submit' name='delete_user'>Delete</button>
                                        </form>
                                    </td>
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

<?php
// Handle User Deletion
if (isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];
    $deleteSql = "DELETE FROM users WHERE userid='$user_id'";
    if (mysqli_query($con, $deleteSql)) {
        echo "User deleted!";
        header('Location: admindash.php');
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>
