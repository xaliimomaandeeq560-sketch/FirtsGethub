<?php
include 'db.php';

// Debug: Check connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Handle form submission
if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    $phone = $_POST['phone'];

    // Prepare statement
    $stmt = $conn->prepare("INSERT INTO students (name, email, course, phone) VALUES (?, ?, ?, ?)");
    
    // Debug: Check prepare
    if(!$stmt){
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssss", $name, $email, $course, $phone);

    if($stmt->execute()){
        header("Location: index.php");
        exit;
    } else {
        $error = "Execute failed: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Add Student</h2>
    <?php if(isset($error)) echo '<div class="alert alert-danger">'.$error.'</div>'; ?>
    <form method="POST">
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Course</label>
            <input type="text" name="course" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control">
        </div>
        <button type="submit" name="submit" class="btn btn-success">Add Student</button>
        <a href="index.php" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>
