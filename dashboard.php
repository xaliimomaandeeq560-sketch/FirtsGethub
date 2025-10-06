<?php
session_start();

// ===== DATABASE CONNECTION =====
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "user_portal";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ===== REGISTRATION =====
if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $msg = "<p style='color:red;'>Email already registered!</p>";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        if ($stmt->execute()) {
            $msg = "<p style='color:green;'>Registration successful! You can login now.</p>";
        } else {
            $msg = "<p style='color:red;'>Error: " . $conn->error . "</p>";
        }
    }
}

// ===== LOGIN =====
if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $user = $res->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $msg = "<p style='color:green;'>Welcome back, " . htmlspecialchars($user['username']) . " 👋</p>";
        } else {
            $msg = "<p style='color:red;'>Invalid password!</p>";
        }
    } else {
        $msg = "<p style='color:red;'>No user found!</p>";
    }
}

// ===== LOGOUT =====
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>UserPortal Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e6f0ff;
            text-align: center;
            margin-top: 40px;
        }
        .container {
            width: 420px;
            background: white;
            margin: auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 10px gray;
        }
        input {
            width: 90%;
            padding: 10px;
            margin: 5px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #0b3d91;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        button:hover {
            background-color: #094080;
        }
        a {
            color: #0b910b;
            text-decoration: none;
        }
        h2 {
            color: #0b3d91;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>UserPortal Dashboard</h1>
    <?php if(isset($msg)) echo $msg; ?>

    <?php if(!isset($_SESSION['username'])): ?>
        <!-- Registration Form -->
        <h2>Register</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit" name="register">Register</button>
        </form>

        <hr>

        <!-- Login Form -->
        <h2>Login</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit" name="login">Login</button>
        </form>

    <?php else: ?>
        <!-- Profile Section -->
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> 👋</h2>
        <p>You are successfully logged in to your dashboard.</p>
        <a href="dashboard.php?logout=true">Logout</a>
    <?php endif; ?>
</div>

</body>
</html>
