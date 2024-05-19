<?php
$delete=0;
include('connection.php');
if(isset($_GET['deleteid'])){
    $id=$_GET['deleteid'];

    $sql="DELETE FROM `customer` WHERE id=$id";
    $result=mysqli_query($con, $sql);
    if($result){
        $delete=1;
        header('location:login.php');
    }else{
        die(mysqli_connect_error());
    }
}
?>