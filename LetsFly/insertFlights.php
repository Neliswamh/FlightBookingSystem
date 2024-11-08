<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "letsfly";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$jsonData = '[
    {
        "flight_number": "AA123",
        "origin": "KM111",
        "destination": "cape town",
        "departure_time": "2024-11-01 08:00:00",
        "arrival_time": "2024-11-01 11:30:00"
    },
    {
        "flight_number": "BA456",
        "origin": "matsapha",
        "destination": "durban",
        "departure_time": "2024-11-01 14:00:00",
        "arrival_time": "2024-11-01 17:30:00"
    },
    {
        "flight_number": "CA789",
        "origin": "matsapha",
        "destination": "jozi",
        "departure_time": "2024-11-02 09:00:00",
        "arrival_time": "2024-11-02 12:30:00"
    }
]';
$flights = json_decode($jsonData, true);
if ($flights === null){
    die("Failed to decode JSON data. please check the json file format.");
}
foreach ($flights as $flight) {
    $flightNumber = $flight['flight_number'];
    $origin = $flight['origin'];
    $destination = $flight['destination'];
    $departureTime = $flight['departure_time'];
    $arrivalTime = $flight['arrival_time'];

    $sql = "INSERT INTO available_flights (flight_number, origin, destination, departure_time, arrival_time)
            VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt){
        die("SQL statement preparation failed:". $conn->error);
    }
    $stmt->bind_param("sssss", $flightNumber, $origin, $destination, $departureTime, $arrivalTime);

    if (!$stmt->execute()) {
        echo "Error inserting flight: " . $flightNumber . "\n";
    }
}

$stmt->close();
$conn->close();

echo "Flights data inserted successfully from JSON file.";
?>
