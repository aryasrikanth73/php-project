<?php

    include('connection.php');

    $id = $_GET['updateid'];
    $sql="SELECT * FROM `customer` WHERE id=$id";
    $result=mysqli_query($con, $sql);
    $row=mysqli_fetch_assoc($result);
    $cname = $row['name'];
    $cemail = $row['email'];
    $cmobile = $row['mobile'];
    // $cpassword = $row['password'];

    if(isset($_POST['submit'])){   
    $name = $_POST['fname'];
    $email = $_POST['femail'];
    $mobile = $_POST['fmobile'];
    // $password = $_POST['fpassword'];


    $sql="SELECT * FROM `customer` WHERE (email='$email' OR mobile='$mobile') AND id !=$id";
    $result=mysqli_query($con, $sql);
    if($result){
        $num=mysqli_num_rows($result);
        if($num>0){
            $error_message = "Another user has the same Email or Mobile, so you can't save.";
            // echo '<script>document.getElementById("message").innerHTML="<h3 class=\"error\">Another User have same Email or Mobile so you can not save</h3>";</script>';
        }else{
            $sql="UPDATE `customer` SET name='$name', email='$email', mobile='$mobile' WHERE id=$id";
    $result=mysqli_query($con, $sql);
    if($result){
                session_start();
                $_SESSION['name'] = $name;
                $_SESSION['email'] = $email;
                $_SESSION['mobile'] = $mobile;
                // $_SESSION['password'] = $password;
        header('location:welcome.php?updated=1');
    }else{
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
</head>
<body>
    <center>
        <h1>UPDATE HERE</h1>
        <form method="post">
            <input type="text" name="fname" placeholder="Enter Your Name Here...." value=<?php echo htmlspecialchars($cname) ?>><br>
            <input type="text" name="femail" placeholder="Enter Your Email Here...." value=<?php echo htmlspecialchars($cemail) ?>><br>
            <input type="text" name="fmobile" placeholder="Enter Your Mobile Number Here...." value=<?php echo htmlspecialchars($cmobile) ?>><br>
            <!-- <input type="text" name="fpassword" placeholder="Enter Your Password Here...." value=<?php echo htmlspecialchars($cpassword) ?>><br> -->
            <button name="submit">Update </button>
            <?php if (isset($error_message)) : ?>
                <h3 class="error"><?php echo $error_message; ?></h3>
            <?php endif; ?>        
        </form>
    </center>

</body>
</html>