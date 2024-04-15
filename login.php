<?php
session_start();

if (isset($_SESSION['user'])) {
    header("Location: main.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Library Gate Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <header>
        <img id="logo" src="logo.jpg" alt="University Logo">
    </header>

    <div id="login-container">
        <h2 id="login-heading">Welcome</h2>

        <?php
        if(isset($_GET['error']) && $_GET['error'] == 'incorrect_password') {
            echo '<p style="color: red;">Incorrect password. Please try again.</p>';
        }
        ?>

        <form id="login-form" action="login_verify.php" method="post">
            <div class="form-group">
                <label for="user"><i class="fa fa-user"></i>User:</label>
                <select id="user" name="user" class="larger-text" onchange="updateLoginButtonStatus()">
                    <option value="" selected disabled>Select User</option>
                    <option value="Master">Master</option>
                    <option value="Admin">Admin</option>
                    <option value="User">User</option>
                </select>
            </div>

            <div class="form-group">
                <label for="password"><i class="fa fa-lock"></i>Password:</label>
                <input type="password" id="password" name="password" required oninput="updateLoginButtonStatus()">
            </div>

            <div class="form-group">
                <label for="location"><i class="fa fa-map-marker"></i>Location:</label>
                <select id="location" name="location" class="larger-text" onchange="updateLoginButtonStatus()" disabled>
                    <option value="" selected disabled>Select Location</option>
                    <option value="lib1">Library 1</option>
                    <option value="lib2">Library 2</option>
                    <option value="lib3">Library 3</option>
                </select>
            </div>
            <button type="submit" id="loginButton" disabled>Login</button>
        </form>
    </div>

    <footer>
        &copy; 2024 Presidency University Library Gate Register
    </footer>

    <script src="login.js"></script>
</body>
</html>
