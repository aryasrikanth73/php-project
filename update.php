<?php

include('connection.php');

$id = $_GET['updateid'];
$sql = "SELECT * FROM `customer` WHERE id=$id";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
$cname = $row['name'];
$cemail = $row['email'];
$cmobile = $row['mobile'];
$cphoto = $row['photo'];

if (isset($_POST['submit'])) {
    $name = $_POST['fname'];
    $email = $_POST['femail'];
    $mobile = $_POST['fmobile'];

    $photo = $_FILES['photo']['name'];
    $temp_name = $_FILES['photo']['tmp_name'];
    $folder = "uploads/";
    if (!empty($photo)) {
        move_uploaded_file($temp_name, $folder . $photo);
    } else {
        $photo = $cphoto;
    }
    
    $sql = "SELECT * FROM `customer` WHERE (email='$email' OR mobile='$mobile') AND id !=$id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $num = mysqli_num_rows($result);
        if ($num > 0) {
            $error_message = "Another user has the same Email or Mobile, so you can't save.";
        } else {
            $sql = "UPDATE `customer` SET name='$name', email='$email', mobile='$mobile', photo='$photo' WHERE id=$id";
            $result = mysqli_query($con, $sql);
            if ($result) {
                session_start();
                $_SESSION['name'] = $name;
                $_SESSION['email'] = $email;
                $_SESSION['mobile'] = $mobile;
                $_SESSION['photo'] = $photo;
                header('location:welcome.php?updated=1');
            } else {
                die(mysqli_connect_error());
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPDATE</title>
    <link rel="stylesheet" href="style.css">
    <script>
    function validateForm() {
        var name = document.forms["signupForm"]["fname"].value;
        var email = document.forms["signupForm"]["femail"].value;
        var mobile = document.forms["signupForm"]["fmobile"].value;
        var mobilePattern = /^\d{10}$/;
        var message = "";

        if (name == "" || email == "" || mobile == "") {
            message = "All fields must be filled out";
        } else if (!mobilePattern.test(mobile)) {
            message = "Please enter a valid 10-digit mobile number";
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
        <h1>UPDATE HERE</h1>
        <form name="signupForm" method="post" onsubmit="return validateForm()" enctype="multipart/form-data">

            
            <input type="file"  name="photo" accept="image/*">
            <input type="text" name="fname" placeholder="Enter Your Name Here...." value="<?php echo htmlspecialchars($cname); ?>"><br>
            <input type="email" name="femail" placeholder="Enter Your Email Here...." value="<?php echo htmlspecialchars($cemail); ?>"><br>
            <input type="text" name="fmobile" placeholder="Enter Your Mobile Number Here...." value="<?php echo htmlspecialchars($cmobile); ?>"><br>
            <button name="submit">Update</button>
            <h3 id="message"></h3>
            <?php if (isset($error_message)) : ?>
                <h3 class="error"><?php echo $error_message; ?></h3>
            <?php endif; ?>
        </form>
    </center>
</body>
</html>
