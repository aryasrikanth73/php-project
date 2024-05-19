<?php
session_start();
if(!isset($_SESSION['name'], $_SESSION['id'],$_SESSION['email'],$_SESSION['mobile'])){
    header('location:login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <center>
        <h1>User Dashboard</h1>
        <div class="dashboard">
            <div class="card">
                <h2>User Details</h2>
                <p><strong>Name:</strong> <span id="userName"><?php echo $_SESSION['name'] ?></span></p>
                <p><strong>Email:</strong> <span id="userEmail"><?php echo $_SESSION['email'] ?></span></p>
                <p><strong>Mobile:</strong> <span id="userMobile"><?php echo $_SESSION['mobile'] ?></span></p>
                <div class="buttons">
                    <button id="updateBtn"><a href="update.php?updateid=<?php echo $_SESSION['id'];  ?>">Update</a></button>
                    <button id="deleteBtn"><a href="delete.php?deleteid=<?php echo $_SESSION['id'];  ?>" onclick="return confirmDelete()">Delete</a></button>
                    <button id="logoutBtn"><a href="logout.php">Logout</a></button>
                </div>
            </div>
        </div>
    </center>
    <script>
        function confirmDelete(){
            return confirm("Are you sure you want to delete your account? This action cannot be undone.");
        }

        document.addEventListener('DOMContentLoaded', function() {
            const params = new URLSearchParams(window.location.search);
            if (params.has('updated')) {
                alert('Your details have been updated successfully.');
            }
        });
    </script>
</body>
</html>