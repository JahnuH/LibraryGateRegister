<?php
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rollNumber = $_POST["rollNumber"];

    $stmt = $conn->prepare("SELECT name, department, school, image FROM students WHERE roll_number = ?");
    $stmt->bind_param("s", $rollNumber);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($name, $department, $school, $image);
        $stmt->fetch();

        $imageData = base64_encode($image);
        $imageSrc = "data:image/jpeg;base64," . $imageData;

        echo json_encode(["name" => $name, "department" => $department, "school" => $school, "imageSrc" => $imageSrc, "status" => "Available"]);
    } else {
        echo json_encode(["error" => "Student not found"]);
    }

    $stmt->close();
}

$conn->close();
?>
