<?php
session_start();
include 'connection.php';

$studentName = "";
$studentDepartment = "";
$studentSchool = "";
$studentImage = "";
$studentScan = "";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredID = $_POST['idInput'];

    $sql = "SELECT * FROM students WHERE roll_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $enteredID);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $studentName = $row['name'];
        $studentDepartment = $row['department'];
        $studentSchool = $row['school'];
        $studentScan = "";
        $studentImage = base64_encode($row['image']);
    } else {
        $studentName = "Not Found";
        $studentDepartment = "";
        $studentSchool = "";
        $studentScan = "";
        $studentImage = base64_encode(file_get_contents("2.jpg"));
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

        .left-panel,
        .middle-panel,
        .right-panel,
        .upper-left-panel,
        .lower-left-panel {
            flex-basis: calc(33.33% - 40px);
            margin: 20px;
            box-sizing: border-box;
        }

        .left-panel,
        .middle-panel,
        .right-panel,
        .upper-left-panel,
        .lower-left-panel {
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            color: #333;
        }

        .middle-panel,
        .right-panel {
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

        .user-details {
            text-align: center;
            font-size: 25px;
        }

        .user-details img {
            width: 100%;
            max-width: 100%;
            height: auto;
            border-radius: 10%;
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
                <div class="live-time-section" id="liveTime">00:00:00</div>
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

            <div class="user-details">
                <p>Welcome to Presidency University Library</p>
            </div>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="text" name="idInput" id="idInput" placeholder="Enter Roll Number" autofocus="true">
            </form>

            <div class="user-details">
                <h3><?php echo $studentName; ?></h3>
                <p><span id="userDepartment"><?php echo $studentDepartment; ?></span></p>
                <p><span id="userSchool"><?php echo $studentSchool; ?></span></p>
                <p><span id="userScan"><?php echo $studentScan; ?></span></p>
            </div>
        </section>

        <aside class="right-panel">
            <div class="user-details">
                <img src="<?php echo 'data:image/jpeg;base64,' . $studentImage; ?>" alt="Scan your ID Card or Enter your Roll Number">
            </div>
        </aside>

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

        function fetchStudentData(rollNumber) {
            fetch('fetch_student_data.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `rollNumber=${rollNumber}`,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        displayStudentData(data);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function displayStudentData(data) {
            const userDetails = document.querySelector('.user-details h3');
            const userDepartment = document.querySelector('#userDepartment');
            const userSchool = document.querySelector('#userSchool');
            const userImage = document.querySelector('.user-details img');
            const timeOfScan = document.querySelector('#userScan');

            userDetails.innerHTML = `Welcome,<br>${data.name}`;
            userDepartment.textContent = `Department: ${data.department}`;
            userSchool.textContent = `School: ${data.school}`;
            timeOfScan.textContent = `Time of Scan: ${getCurrentTime()}`;
            userImage.src = data.imageSrc;
        }

        function getCurrentTime() {
            const now = new Date();
            const hours = now.getHours() % 12 || 12;
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');
            const amPm = now.getHours() < 12 ? 'AM' : 'PM';

            return `${hours}:${minutes}:${seconds} ${amPm}`;
        }

        document.querySelector('.middle-panel form').addEventListener('submit', function(event) {
            event.preventDefault();
            const rollNumber = document.getElementById('idInput').value;
            fetchStudentData(rollNumber);
        });

        updateLiveTime();
    </script>
</body>

</html>
