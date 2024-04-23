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

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('login.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #333;
        }

        header {
            background-color: #007BFF;
            text-align: center;
            padding: 0;
        }

        #logo {
            width: 100%;
            max-height: 250px;
            height: auto;
            max-width: 100%;
            display: block;
        }

        #login-container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        #login-container form {
            text-align: left;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            text-align: left;
        }

        select, input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .larger-text {
            font-size: 16px;
        }

        .fa {
            margin-right: 10px;
        }

        button {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 30px;
            font-size: 18px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            display: block;
            margin: 0 auto;
        }

        button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        button:hover:enabled {
            background-color: #0056b3;
        }

        footer {
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #007BFF;
            color: #fff;
        }
    </style>
</head>
<body>
<header>
    <img id="logo" src="logo.jpg" alt="University Logo">
</header>

<div id="login-container">
    <h2 id="login-heading">Welcome</h2>

    <?php
    if (isset($_GET['error']) && $_GET['error'] == 'incorrect_password') {
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
                <option value="lib1">Main Library</option>
                <option value="lib2">SoM Library</option>
                <option value="lib3">Law Library</option>
            </select>
        </div>
        <button type="submit" id="loginButton" disabled>Login</button>
    </form>
</div>

<footer>
    &copy; 2024 Presidency University Library Gate Register
</footer>

<script>
    function updateLoginButtonStatus() {
        var user = document.getElementById('user').value;
        var password = document.getElementById('password').value;
        var location = document.getElementById('location').value;
        var locationButton = document.getElementById('location');
        var loginButton = document.getElementById('loginButton');

        if (user === "Master") {
            locationButton.selectedIndex = 0;
            locationButton.disabled = true;
            loginButton.disabled = password === "";
        } else if (user === "Admin" || user === "User") {
            locationButton.disabled = false;
            loginButton.disabled = password === "" || location === "";
        } else {
            locationButton.disabled = true;
            loginButton.disabled = true;
        }
    }
</script>

</body>
</html>
