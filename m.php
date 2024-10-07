<?php
$con = mysqli_connect("localhost", "root", "", "canteen");
if (!$con) {
    echo "Database not connected";
}

if (isset($_POST['add_menu_item'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity']; 
    $category = $_POST['category']; 

    $targetDir = "uploads/"; 
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $sql = "INSERT INTO menu (name, price, description, image, quantity, category) VALUES ('$name', '$price', '$description', '$targetFile', '$quantity', '$category')";
            if (mysqli_query($con, $sql)) {
                echo "New menu item added!";
                header('Location: admindash.php');
            } else {
                echo "Error: " . mysqli_error($con);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $deleteSql = "DELETE FROM menu WHERE id='$id'";
    if (mysqli_query($con, $deleteSql)) {
        echo "Menu item deleted!";
        header('Location: admindash.php');
    } else {
        echo "Error: " . mysqli_error($con);
    }
}

$allOrders = mysqli_query($con, "SELECT * FROM orders");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canteen Admin Panel</title>
    <link rel="stylesheet" href="admindash.css">
</head>

<body>
    <nav>
        <ul>
            <li><a href="admindash.php">Dashboard</a></li>
            <li><a href="user_management.php">User Management</a></li>
            <li><a href="staff_management.php">Staff Management</a></li>
            <li><a href="Tablemanage.php">Table Management</a></li>
            <li><a href="m.php">Menu Management</a></li>
            <li><a href="#orders">Order Management</a></li>
            <li><a href="index.html">Logout</a></li>

        </ul>
    </nav>

    <div class="container">
        <section id="menu">
            <h2>Menu Management</h2>
            <form method="post" enctype="multipart/form-data">
    <input type="text" placeholder="Name" name="name" required><br>
    <input type="text" placeholder="Price" name="price" required><br>
    <input type="text" placeholder="Description" name="description" required><br>
    
    <label for="category">Category:</label>
    <select name="category" id="category" required>
        <option value="">Select Category</option>
        <option value="Breakfast">Breakfast</option>
        <option value="Lunch">Lunch</option>
        <option value="Snacks">Snacks</option>
        <option value="Drinks">Drinks</option>
        <option value="Others">Others</option> 
    </select><br>
    
    <input type="number" placeholder="Quantity" name="quantity" required><br>
    <input type="file" name="image" required><br>
    <button type="submit" name="add_menu_item">Add Menu Item</button>
</form>


            <h3>Current Menu Items</h3>
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Quantity</th> 
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $menuItems = mysqli_query($con, "SELECT * FROM menu");
                    if (mysqli_num_rows($menuItems) > 0) {
                        while ($row = mysqli_fetch_assoc($menuItems)) {
                            echo "<tr>
                                    <td>{$row['name']}</td>
                                    <td>{$row['price']}</td>
                                    <td>{$row['description']}</td>
                                    <td>{$row['quantity']}</td> <!-- Display Quantity -->
                                    <td><img src='{$row['image']}' alt='{$row['name']}' style='width: 200px; height: auto;'></td>
                                    <td><a href='?delete={$row['id']}' onclick='return confirm(\"Are you sure you want to delete this item?\");'>Delete</a>
                                    <a href='edit_menu.php?id={$row['id']}'>Edit</a>
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
