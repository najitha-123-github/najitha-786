</html>

<head>
    <link rel="stylesheet" href="reg.css">
</head>

<body>
    <div class="parent">
        <form class="test" method="post">
            <span  class="head">User Registration</span>
           <label>Name:</label> <input  class="input1"type="text" placeholder="Enter Fullname" name="name"><br>
           <label>Email:</label> <input  class="input1"type="text" placeholder="Enter Email" name="email"><br>
           <label>Ph No:</label><input class="input1" type="number" placeholder="Enter your Ph No" name="phno"><br>
            <select name="usertype" id="" class="input1">
                <option value="">Select User Type</option>
                <option value="Teaching Staff">Teaching Staff</option>
                <option value="Non Teaching Staff">Non Teaching Staff</option>
                <option value="Students">Students</option>
            </select>
           <label>Password:</label><input class="input1" type="password" placeholder="Enter Password" name="pwd"><br>
            <button name="submit" type="submit" class="button1">SUBMIT</button>
            <p>If you have an account. <a href="login.php">Login</a></p>
        </form>
    </div>

</body>

</html>


<?php
$con=mysqli_connect("localhost","root","","canteen");
if(!$con){
    echo "db not connected";
}
if(isset($_POST['submit'])){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $phno=$_POST['phno'];
    $pwd=$_POST['pwd'];
    $usert=$_POST['usertype'];
    $sql="INSERT INTO `users`(`name`, `email`, `phno`, `password`, `usertype`) VALUES ('$name','$email','$phno','$pwd','$usert')";
    $sql1="INSERT INTO `login`(`email`, `password`, `usercode`) VALUES ('$email','$pwd',0)";
    $data=mysqli_query($con,$sql);
    $data1=mysqli_query($con,$sql1);
    if($data && $data1){
        echo"<script>alert('User registration Success')</script>";
    }
    else{
        echo"<script>alert('User registration not Success')</script>";

    }
}