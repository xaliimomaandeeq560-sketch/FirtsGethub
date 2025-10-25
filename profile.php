<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>Profile</title></head>
<body>
<h2>User Profile</h2>
<p>Welcome, <strong><?php echo $_SESSION['username']; ?></strong></p>
<a href="index.php">Home</a> | <a href="logout.php">Logout</a>
</body>
</html>
