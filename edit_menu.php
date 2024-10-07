<?php
$con = mysqli_connect("localhost", "root", "", "canteen");
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Check if menu item ID is provided
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Retrieve current item details
    $result = mysqli_query($con, "SELECT * FROM menu WHERE id='$id'");
    $item = mysqli_fetch_assoc($result);

    if (!$item) {
        echo "Menu item not found!";
        exit();
    }
}

// Update the menu item
if (isset($_POST['update_menu_item'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $category = $_POST['category'];
    
    // Image upload logic
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // If a new image is uploaded, update the image path
    if (!empty($_FILES["image"]["name"])) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $image = $targetFile;
        } else {
            echo "Error uploading the new image.";
            $image = $item['image']; // Use old image if upload fails
        }
    } else {
        $image = $item['image']; // Use the existing image if no new one is uploaded
    }

    // Update the database
    $sql = "UPDATE menu SET name='$name', price='$price', description='$description', image='$image', quantity='$quantity', category='$category' WHERE id='$id'";
    if (mysqli_query($con, $sql)) {
        echo "Menu item updated!";
        header('Location: admindash.php');
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
    <title>Edit Menu Item</title>
    <link rel="stylesheet" href="admindash.css">
</head>
<body>

<h2>Edit Menu Item</h2>

<form method="post" enctype="multipart/form-data">
    <input type="text" name="name" value="<?php echo $item['name']; ?>" required><br>
    <input type="text" name="price" value="<?php echo $item['price']; ?>" required><br>
    <input type="text" name="description" value="<?php echo $item['description']; ?>" required><br>
    
    <label for="category">Category:</label>
    <select name="category" id="category" required>
        <option value="Breakfast" <?php if($item['category'] == 'Breakfast') echo 'selected'; ?>>Breakfast</option>
        <option value="Lunch" <?php if($item['category'] == 'Lunch') echo 'selected'; ?>>Lunch</option>
        <option value="Snacks" <?php if($item['category'] == 'Snacks') echo 'selected'; ?>>Snacks</option>
        <option value="Drinks" <?php if($item['category'] == 'Drinks') echo 'selected'; ?>>Drinks</option>
        <option value="Others" <?php if($item['category'] == 'Others') echo 'selected'; ?>>Others</option>
    </select><br>
    
    <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" required><br>
    <input type="file" name="image"><br> <!-- Optional image upload -->
    
    <button type="submit" name="update_menu_item">Update Menu Item</button>
</form>

</body>
</html>
