<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Portal</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Welcome to UserPortal</h1>

    <?php if(isset($_SESSION['username'])): ?>
        <p>Hello, <strong><?php echo $_SESSION['username']; ?></strong></p>
        <a href="profile.php">View Profile</a> | 
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="register.php">Register</a> | 
        <a href="login.php">Login</a>
    <?php endif; ?>
</body>
</html>
