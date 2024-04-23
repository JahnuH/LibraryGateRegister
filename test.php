<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "koha";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Example query to fetch data
$sql = "SELECT * FROM students";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Name: " . $row["name"]. " - Gender: " . $row["gender"]. "<br>";
    }
} else {
    echo "0 results";
}

// Close connection
$conn->close();
?>



SELECT 
    CONCAT(firstname,' ',surname) AS surname,
    borrowernumber,
    sex,
    categorycode,
    branchcode,
    sort1,
    sort2,
    mobile,
    email 
FROM 
    borrowers 
WHERE 
    cardnumber='$id' 
    AND dateexpiry > '$date';
