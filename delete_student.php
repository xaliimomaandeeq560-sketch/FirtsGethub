<?php
include 'db.php';

if(!isset($_GET['id'])){
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

// Delete student
$stmt = $conn->prepare("DELETE FROM students WHERE id=?");
$stmt->bind_param("i", $id);

if($stmt->execute()){
    header("Location: index.php");
    exit;
} else {
    echo "Error deleting student: " . $conn->error;
}
?>
