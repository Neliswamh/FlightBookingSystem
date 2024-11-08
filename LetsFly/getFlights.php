
<?php

header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "letsfly";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM available_flights";
$result = $conn->query($sql);

$flights = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $flights[] = $row;
    }
}

$newFlight =[ "flight_number"=> "AA233",
        "origin"=> "KM111",
        "destination"=> "Cape Town",
        "departure_time"=> "2024-11-01 05:00:00",
        "arrival_time"=> "2024-11-01 16:24:00" ];

		$flights[] = $newFlight;

echo json_encode($flights);

$conn->close();
?>