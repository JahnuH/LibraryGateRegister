<?php
session_start();

$studentName = "";
$studentDepartment = "";
$studentSchool = "";
$studentImage = "default.jpg";
$studentScan = "";

$inputSubmitted = isset($_GET['idInput']);

if(isset($_GET['idInput'])) {
   
    $rollNumber = $_GET['idInput'];

    if ($rollNumber === '1') {
        $studentName = "Jahnu Tanai";
        $studentDepartment = "Department";
        $studentSchool = "School of CSE";
        $studentScan = date("Y-m-d H:i:s");
        $imagePath = '1.jpg';
        $imageData = file_get_contents($imagePath);
        $studentImage = base64_encode($imageData);
    } else {
        echo "Student not found";
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library In/Out Register</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        header {
            background: radial-gradient(circle, hsla(225, 78%, 59%, 1) 0%, hsla(197, 85%, 51%, 1) 100%);
            color: #fff;
            text-align: center;
            padding: 20px;
            position: relative;
        }
        #logo {
            width: 1000px;
            height: auto;
            display: block;
            margin: 0 auto;
            border-radius: 15px;
        }
        header h1 {
            margin: 10px 0 0;
            font-size: 24px;
        }
        .logout-button {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        main {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }
        .left-panel, .middle-panel, .right-panel, .upper-left-panel, .lower-left-panel {
            flex: 1;
            margin: 20px;
            box-sizing: border-box;
        }
        .left-panel, .middle-panel, .right-panel, .upper-left-panel, .lower-left-panel {
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            color: #333;
        }
        .middle-panel, .right-panel {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .real-time-stats {
            margin-bottom: 25px;
            text-align: center;
        }
        .stat-label {
            font-size: 25px;
            margin-bottom: 10px;
            text-align: center;
        }
        .stat-value {
            font-size: 25px;
            font-weight: bold;
        }
        .instructions {
            text-align: center;
            font-size: 25px;
        }
        .user-details {
            text-align: center;
            font-size: 25px;
        }
        .user-details img {
            width: 100%;
            max-width: 100%;
            height: auto;
            border-radius: 10%;
            transform: scale(2.5);
        }
        #idInput {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            box-sizing: border-box;
            font-size: 16px;
            text-align: center;
        }
        footer {
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
            background: radial-gradient(circle, hsla(225, 78%, 59%, 1) 0%, hsla(197, 85%, 51%, 1) 100%);
            color: #fff;
        }
        .live-time-section {
            font-size: 50px;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <img id="logo" src="logo.jpg" alt="University Logo">
        <form method="post" class="logout-button">
            <button type="submit" name="logout">Logout</button>
        </form>
    </header>

    <main>
        <section class="left-panel">
            <section class="upper-left-panel">
                <div class="live-time-section" id="liveTime"><?php echo date("h:i:s A"); ?></div>
            </section>

            <section class="lower-left-panel">
                <h2 class="real-time-stats">Summary</h2>
                <div class="stat-label">Total Users: <span class="stat-value" id="totalUsers">0</span></div>
                <div class="stat-label">Male Users: <span class="stat-value" id="maleUsers">0</span></div>
                <div class="stat-label">Female Users: <span class="stat-value" id="femaleUsers">0</span></div>
                <div class="stat-label">Faculty: <span class="stat-value" id="facultyUsers">0</span></div>
                <div class="stat-label">Students: <span class="stat-value" id="studentUsers">0</span></div>
                <div class="stat-label">Research Scholars: <span class="stat-value" id="researchUsers">0</span></div>
            </section>
        </section>

        <section class="middle-panel">
            <div class="instructions" id="instructions">
                <h3>SCAN YOUR ID CARD</h3>
                <p>or</p>
                <h3>TYPE YOUR ID NUMBER</h3>
            </div>

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
                <b><input type='text' name='idInput' autofocus="autofocus" id="idInput"></b>
            </form>

            <div class="user-details" id="userDetails">
                <h3><?php echo $studentName; ?></h3>
                <p><span id="userDepartment"><?php echo $studentDepartment; ?></span></p>
                <p><span id="userSchool"><?php echo $studentSchool; ?></span></p>
                <p><span id="userScan"><?php echo $studentScan; ?></span></p>
            </div>
        </section>

        <section class="right-panel">
            <div class="user-details" id="userDetails">
                <img src="data:image/jpeg;base64,<?php echo $studentImage; ?>">
            </div>
        </section>
    </main>

    <footer>
        &copy; 2024 Presidency University Library Gate Register
    </footer>

    <script>

        function updateLiveTime() {
            const liveTimeElement = document.getElementById("liveTime");
            setInterval(() => {
                liveTimeElement.textContent = getCurrentTime();
            }, 1000);
        }

        function getCurrentTime() {
            const now = new Date();
            const hours = now.getHours() % 12 || 12;
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');
            const amPm = now.getHours() < 12 ? 'AM' : 'PM';

            return `${hours}:${minutes}:${seconds} ${amPm}`;
        }

        updateLiveTime();

        function toggleUserDetails() {
            var instructions = document.getElementById("instructions");
            var idInput = document.getElementById("idInput");
            var userDetails = document.getElementById("userDetails");

            instructions.style.display = "none";
            idInput.style.display = "none";
            userDetails.style.display = "block";

            setTimeout(function() {
                instructions.style.display = "block";
                idInput.style.display = "block";
                userDetails.style.display = "none";

                idInput.value = '';
                idInput.focus();

                var rightPanelContents = document.querySelector(".right-panel .user-details");
                rightPanelContents.innerHTML = "";
            }, 5000);
        }

        <?php
        if($inputSubmitted) {
            echo 'toggleUserDetails();';
        }
        ?>

    </script>
</body>
</html>
