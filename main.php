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
    <link rel="stylesheet" type="text/css" href="main.css">
</head>

<body>
    <header>
        <img id="logo" src="logo.jpg" alt="University Logo">
        <form method="post" class="logout-button">
            <button type="submit" name="logout">Logout</button>
        </form>
    </header>

    <main>
        <div class="container">
            <section class="left-panel">
                <div class="summary">
                    <h2>Summary</h2>
                    <div class="summary-details">
                        <div>Total Users: <span id="totalUsers">0</span></div>
                        <div>Male Users: <span id="maleUsers">0</span></div>
                        <div>Female Users: <span id="femaleUsers">0</span></div>
                        <div>Faculty: <span id="facultyUsers">0</span></div>
                        <div>Students: <span id="studentUsers">0</span></div>
                        <div>Research Scholars: <span id="researchUsers">0</span></div>
                    </div>
                </div>
            </section>

            <section class="middle-panel">
                <div class="user-form">
                    <h2>Welcome to Presidency University Library</h2>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <input type="text" name="idInput" id="idInput" placeholder="Enter Roll Number" autofocus>
                    </form>
                </div>

                <div class="user-details">
                    <h3><?php echo $studentName; ?></h3>
                    <p><span id="userDepartment"><?php echo $studentDepartment; ?></span></p>
                    <p><span id="userSchool"><?php echo $studentSchool; ?></span></p>
                </div>
            </section>

            <section class="right-panel">
                <div class="user-image">
                    <img src="data:image/jpeg;base64,<?php echo $studentImage; ?>" alt="Student Image">
                </div>
            </section>
        </div>
    </main>

    <footer>
        &copy; 2024 Presidency University Library Gate Register
    </footer>
</body>

</html>
