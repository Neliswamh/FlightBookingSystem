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

// SQL to create table for machine data (as an example)
$sql = "CREATE TABLE complete_bookings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    flight_number VARCHAR(10) NOT NULL,
    trip_type ENUM('one_way', 'return') NOT NULL,
    passengers INT NOT NULL,
    ticket_type ENUM('economy', 'premium_economy', 'business', 'first class') NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table complete_bookings created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
<?php
