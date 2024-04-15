<?php
include('connection.php');
session_start();

$user = $_POST['user'];
$inputPassword = $_POST['password'];

$stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
$stmt->bind_param("s", $user);
$stmt->execute();
$stmt->bind_result($storedPassword);
$stmt->fetch();
$stmt->close();

if ($inputPassword === $storedPassword) {
    $_SESSION['user'] = $user;
    header("Location: main.php");
    exit();
} else {
    header("Location: login.php?error=incorrect_password");
    exit();
}

$conn->close();
?>
