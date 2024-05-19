<?php
    $con = mysqli_connect("localhost", "root", "", "crud");
    if(!$con){
        die(mysqli_connect_error());
    }
    // else{
    //     echo "connected successfully";
    // }
?>