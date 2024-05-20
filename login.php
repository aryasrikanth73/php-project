<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHECK | LOGIN</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <center>
        <h1>LOGIN HERE</h1>
        <form method="post">
            <input type="text" name="femailormobile" placeholder="Enter Your Email or Mobile...."><br>
            <input type="password" name="fpassword" placeholder="Enter Your Password...."><br>
            <button name="submit">login </button>
            <a href="signup.php"><strong> New User?</strong></a>
            <div id="message"></div>
        </form>
    </center>
</body>
</html>
<?php
    include('connection.php');

    if(isset($_POST['submit'])){
        $emailormobile = $_POST['femailormobile'];
        $password = md5($_POST['fpassword']);

        $sql="SELECT * FROM `customer` WHERE (email='$emailormobile' OR mobile='$emailormobile') AND password='$password'";
        $result=mysqli_query($con, $sql);
        
        if($result){
            $num=mysqli_num_rows($result);
            if($num>0){
                $row=mysqli_fetch_assoc($result);
                session_start();
                $_SESSION['id']=$row['id'];
                $_SESSION['name']=$row['name'];
                $_SESSION['email']=$row['email'];
                $_SESSION['mobile']=$row['mobile'];
                $_SESSION['password']=$row['password'];
                $_SESSION['photo']=$row['photo'];
                header('location:welcome.php');
            }else{
                echo "<script>document.getElementById('message').innerHTML = '<h3 class=\"error\">Invalid Credentials</h3>';</script>";
            }
        }else{
            die(mysqli_connect_error());
        }
    
    }
?>
