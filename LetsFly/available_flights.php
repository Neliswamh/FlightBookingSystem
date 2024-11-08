<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "letsfly";

// Create connection
$conn = new mysqli("localhost", "root", "", "letsfly");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to create table
$sql = "CREATE TABLE available_flights (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    flight_number VARCHAR(10) NOT NULL,
    origin VARCHAR(50) NOT NULL,
    destination VARCHAR(50) NOT NULL,
    departure_time DATETIME NOT NULL,
    arrival_time DATETIME NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table Bookings_data created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
