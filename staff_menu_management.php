<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Menu</title>
    <link rel="stylesheet" href="menu_management.css">
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
    <h1>Manage Menu</h1>
    <form method="post" enctype="multipart/form-data">
        <input type="text" placeholder="Name" name="name" required><br>
        <input type="text" placeholder="Price" name="price" required><br>
        <input type="text" placeholder="Description" name="description" required><br>
        <select name="category" id="category" required>
            <option value="">Select Category</option>
            <option value="Breakfast">Breakfast</option>
            <option value="Lunch">Lunch</option>
            <option value="Dinner">Dinner</option>
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
                <th>Category</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- PHP code to fetch and display menu items -->
            <?php
            $con = mysqli_connect("localhost", "root", "", "canteen");
            if (!$con) {
                echo "Database not connected";
            }

            $menuItems = mysqli_query($con, "SELECT * FROM menu");
            if (mysqli_num_rows($menuItems) > 0) {
                while ($row = mysqli_fetch_assoc($menuItems)) {
                    echo "<tr>
                            <td>{$row['name']}</td>
                            <td>{$row['price']}</td>
                            <td>{$row['description']}</td>
                            <td>{$row['quantity']}</td>
                            <td>{$row['category']}</td>
                            <td><img src='{$row['image']}' alt='{$row['name']}' style='width: 100px; height: auto;'></td>
                            <td><a href='?delete={$row['id']}' onclick='return confirm(\"Are you sure you want to delete this item?\");'>Delete</a></td>
                          </tr>";
                }
            }
            ?>
        </tbody>
    </table>
</body>

</html>
