<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CREATE | SIGNUP</title>
    <link rel="stylesheet" href="style.css">
    <script>
    function validateForm() {
        var name = document.forms["signupForm"]["fname"].value;
        var email = document.forms["signupForm"]["femail"].value;
        var mobile = document.forms["signupForm"]["fmobile"].value;
        var password = document.forms["signupForm"]["fpassword"].value;
        var cpassword = document.forms["signupForm"]["fcpassword"].value;
        var passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/;
        var mobilePattern = /^\d{10}$/; 

        var message = "";

        if (name == "" || email == "" || mobile == "" || password == "" || cpassword == "") {
            message = "All fields must be filled out";
        } else if (!mobilePattern.test(mobile)) { 
            message = "Please enter a valid 10-digit mobile number";
        } else if (password !== cpassword) {
            message = "Passwords do not match";
        } else if (!passwordPattern.test(password)) {
            message = "Password must be at least 6 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character";
        }
        
        if (message) {
            document.getElementById('message').innerHTML = '<h3 class="error">' + message + '</h3>';
            return false;
        }
        return true;
    }
</script>

</head>
<body>
    <center>
        <h1>SIGN UP HERE</h1>
        <form name="signupForm" method="post" onsubmit="return validateForm()">
            <input type="text" name="fname" placeholder="Enter Your Name Here...." required><br>
            <input type="email" name="femail" placeholder="Enter Your Email Here...." required>
            <input type="text" name="fmobile" placeholder="Enter Your Mobile Number Here...." required><br>
            <input type="password" name="fpassword" placeholder="Enter Password Here...." required><br>
            <input type="password" name="fcpassword" placeholder="Enter Confirm Password Here...." required><br>
            <button type="submit" name="submit">Sign Up</button>
            <a href="login.php"><strong>Already a user?</strong></a>
            <div id="message"></div>
        </form>
    </center>
</body>
</html>
<?php
include('connection.php');

if(isset($_POST['submit'])){
    $name = trim($_POST['fname']);
    $email = trim($_POST['femail']);
    $mobile = trim($_POST['fmobile']);
    $password = trim(md5($_POST['fpassword']));
    $cpassword = trim(md5($_POST['fcpassword']));
    
    // Basic validation
    if(empty($name) || empty($email) || empty($mobile) || empty($password) || empty($cpassword)){
        echo "<script>document.getElementById('message').innerHTML = '<h3 class=\"error\">All fields must be filled out</h3>';</script>";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>document.getElementById('message').innerHTML = '<h3 class=\"error\">Invalid email format</h3>';</script>";
    } elseif($password !== $cpassword) {
        echo "<script>document.getElementById('message').innerHTML = '<h3 class=\"error\">Passwords not matched</h3>';</script>";
    } elseif(strlen($password) < 6) {
        echo "<script>document.getElementById('message').innerHTML = '<h3 class=\"error\">Password must be at least 6 characters long</h3>';</script>";
    } else {
        // Hash the password
        // $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "SELECT * FROM `customer` WHERE email='$email' OR mobile='$mobile'";
        $result = mysqli_query($con, $sql);

        if($result){
            $num = mysqli_num_rows($result);
            if($num > 0){
                echo "<script>document.getElementById('message').innerHTML = '<h3 class=\"error\">Email or Mobile Number already used! Please try another one</h3>';</script>";
            } else {
                $sql = "INSERT INTO `customer` (name, email, mobile, password) VALUES('$name', '$email', '$mobile', '$password')";
                $result = mysqli_query($con, $sql);
                if($result){
                    echo "<script>document.getElementById('message').innerHTML = '<h3 class=\"success\">Successfully Registered</h3>';</script>";
                } else {
                    echo "<script>document.getElementById('message').innerHTML = '<h3 class=\"error\">Registration failed. Please try again later.</h3>';</script>";
                }
            }
        } else {
            echo "<script>document.getElementById('message').innerHTML = '<h3 class=\"error\">Database query failed. Please try again later.</h3>';</script>";
        }
    }
}
?>
