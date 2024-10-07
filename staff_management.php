<?php
$con = mysqli_connect("localhost", "root", "", "canteen");
if (!$con) {
    echo "Database not connected";
}

// Fetch staff
$staff = mysqli_query($con, "SELECT * FROM staff");

// Initialize variables for editing
$editMode = false;
$staffToEdit = null;

// Handle Staff Addition
if (isset($_POST['add_staff'])) {
    $staff_name = $_POST['staff_name'];
    $staff_email = $_POST['staff_email'];
    $staff_pass = $_POST['staff_pass'];
    $addStaffSql = "INSERT INTO staff (name, email, spass) VALUES ('$staff_name', '$staff_email','$staff_pass')";
    $addStaffSql1 = "INSERT INTO `login`(`email`, `password`, `usercode`) VALUES('$staff_email', '$staff_pass', 1)";
    if (mysqli_query($con, $addStaffSql) && mysqli_query($con, $addStaffSql1)) {
        echo "New staff added!";
        header('Location: staff_management.php');
    } else {
        echo "Error: " . mysqli_error($con);
    }
}

// Handle Staff Edit
if (isset($_POST['edit_staff'])) {
    $staff_id = $_POST['staff_id'];
    $editMode = true; // Enable edit mode
    $staffToEdit = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM staff WHERE id='$staff_id'"));
}

// Handle Staff Update
if (isset($_POST['update_staff'])) {
    $staff_id = $_POST['staff_id'];
    $staff_name = $_POST['staff_name'];
    $staff_email = $_POST['staff_email'];
    $staff_pass = $_POST['password'];
    $oldemail=$_POST['email'];
    $updateSql = "UPDATE staff SET name='$staff_pass', email='$staff_email' WHERE id='$staff_id'";
    $updateSql1 = "UPDATE `login` SET `password`='$staff_pass', `email`='$staff_email' WHERE `email`='$oldemail'";
    if (mysqli_query($con, $updateSql) && mysqli_query($con, $updateSql1)) {
        echo "Staff updated!";
        header('Location: staff_management.php');
    } else {
        echo "Error: " . mysqli_error($con);
    }
}

if (isset($_POST['activate_staff'])) {
    $staff_id = $_POST['staff_id'];
    $activateSql = "UPDATE staff SET active=1 WHERE id='$staff_id'";
    if (mysqli_query($con, $activateSql)) {
        echo "Staff activated!";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}

// Handle Staff Deactivation
if (isset($_POST['deactivate_staff'])) {
    $staff_id = $_POST['staff_id'];
    $deactivateSql = "UPDATE staff SET active=0 WHERE id='$staff_id'";
    if (mysqli_query($con, $deactivateSql)) {
        echo "Staff deactivated!";
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
    <title>Staff Management</title>
    <link rel="stylesheet" href="staffmanage.css">
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
        <!-- Staff Management Section -->
        <section id="staff">
            <h2>Staff Management</h2>

            <!-- Staff Edit Form -->
            <?php if ($editMode): ?>
                <form method="post">
                    <input type="hidden" name="staff_id" value="<?= $staffToEdit['id'] ?>">
                    <input type="text" placeholder="Staff Name" name="staff_name" value="<?= $staffToEdit['name'] ?>" required><br>
                    <input type="hidden" placeholder="Staff Name" name="email" value="<?= $staffToEdit['email'] ?>" required><br>
                    <input type="email" placeholder="Staff Email" name="staff_email" value="<?= $staffToEdit['email'] ?>" required><br>
                    <input type="text" placeholder="Staff Password" name="password" value="<?= $staffToEdit['spass'] ?>" required><br>
                    <button type="submit" name="update_staff">Update Staff</button>
                </form>
            <?php else: ?>
                <form method="post">
                    <input type="text" placeholder="Staff Name" name="staff_name" required><br>
                    <input type="email" placeholder="Staff Email" name="staff_email" required><br>
                    <input type="password" placeholder="Staff Password" name="staff_pass" required><br>
                    <button type="submit" name="add_staff">Add Staff</button>
                </form>
            <?php endif; ?>

            <h3>Current Staff</h3>
            <table>
                <thead>
                    <tr>
                        <th>Staff ID</th>
                        <th>Staff Name</th>
                        <th>Staff Email</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($staff) > 0) {
                        while ($row = mysqli_fetch_assoc($staff)) {
                            $status = $row['active'] ? "Active" : "Inactive";
                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['name']}</td>
                                    <td>{$row['email']}</td>
                                    <td>$status</td>
                                    <td>
                                        <form method='post'>
                                            <input type='hidden' name='staff_id' value='{$row['id']}'>
                                            <button type='submit' name='activate_staff'>Activate</button>
                                            <button type='submit' name='deactivate_staff'>Deactivate</button>
                                            <button type='submit' name='edit_staff'>Edit</button>
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
