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

    switch ($user) {
        case 'Master':
            header("Location: master.php");
            break;
        case 'Admin':
            header("Location: user.php");
            break;
        case 'User':
            header("Location: user.php");
            break;
        default:
            header("Location: login.php");
            break;
    }

    exit();
} else {
    header("Location: login.php?error=incorrect_password");
    exit();
}

$conn->close();
?>
