<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="parent">
        <form class="test" method="post">
            <span class="head">Login</span>
            <input class="input1" type="email" placeholder="Enter your email" name="email" required><br>
            <input class="input1" type="password" placeholder="Enter your password" name="password" required><br>
            <button type="submit" name="submit" class="button1">SUBMIT</button>
        </form>
    </div>
</body>
</html>

<?php
$con = mysqli_connect("localhost", "root", "", "canteen");
if (!$con) {
    echo "Database not connected";
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM login WHERE email='$email' AND password='$password'";
    $data = mysqli_query($con, $sql);
    
    if ($data) {
        if (mysqli_num_rows($data) > 0) {
            $value = mysqli_fetch_assoc($data);
            
            $usercode = $value['usercode'];
            
            if ($usercode == 1) {
                $staffQuery = "SELECT active FROM staff WHERE email='$email'";
                $staffData = mysqli_query($con, $staffQuery);
                
                if ($staffData && mysqli_num_rows($staffData) > 0) {
                    $staffValue = mysqli_fetch_assoc($staffData);
                    
                    if ($staffValue['active'] == '0') {
                        echo "<script>alert('Your account is inactive. Please contact admin.');</script>";
                        exit();
                    } else {
                        header('Location: staffdash.php');
                        exit();
                    }
                } else {
                    echo "<script>alert('Staff not found.');</script>";
                }
            } else if ($usercode == 0) {
                header('Location: userdash.php');
                exit();
            } else {
                header('Location: admindash.php');
                exit();
            }
        } else {
            echo "<script>alert('User not found');</script>";
        }
    } else {
        echo "<script>alert('Error in query execution');</script>";
    }
}
?>
