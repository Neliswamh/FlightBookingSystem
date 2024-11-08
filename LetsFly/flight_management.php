<?php

require 'connect.php';



// Check if the user is an admin


// Handle adding a new flight
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_flight'])) {
    $flight_number = $_POST['flight_number'];
    $trip_type = $_POST['trip_type'];
    $passengers = $_POST['passengers'];
    $ticket_type = $_POST['ticket_type'];

    $stmt = $conn->prepare("INSERT INTO complete_bookings (flight_number, trip_type, passengers, ticket_type) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis",$flight_number, $trip_type, $passengers, $ticket_type);
    $stmt->execute();
    header("Location: flight_management.php");
    exit();
}

// Handle deleting a flight
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_flight'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM complete_bookings WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: flight_management.php");
    exit();
}

// Fetch all flights
$result = $conn->query("SELECT * FROM complete_bookings ORDER BY flight_number ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> MANAGE FLIGHTS</title>
  <link rel="stylesheet" href="./letsfly.css">
</head>
<body style="background-color: #d0d8e4">

  <header >
    <div class="logo">LetsFly</div>
    <nav>
      
	  <a href="Admin_dashboard.php">Back</a>
	  <a href="index.php">Logout</a>
	
    </nav>
  </header>
	
	<br>
	<br>
     
    <!-- Display existing flights -->
    <table border="1" class="table-edit">
        <tr>
            <th>Flight Number</th>
            <th>Trip Type</th>
            <th>No. of People</th>
            <th>Ticket Type</th>
            <th>Actions</th>
        </tr>
        <?php while ($flight = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $flight['flight_number'] ?></td>
				 <td><?= $flight['trip_type'] ?></td>
                <td><?= $flight['passengers'] ?></td>
                <td><?= $flight['ticket_type'] ?></td>
                <td>
                    <!-- Form to delete the flight -->
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $flight['id'] ?>">
                        <button type="submit" name="delete_flight">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h2>Add New Flight:</h2>
    <form method="POST">
        <label>Flight Number:</label>
        <input type="text" name="flight_number" required><br>


        <label>Trip Type:</label>
        <select name="trip_type" required>
            <option value="one way">One Way</option>
            <option value="return">Return</option>
        </select><br>

        <label>No. of People:</label>
        <input type="number" name="passengers" min="1" required><br>

        <label>Ticket Type:</label>
        <select name="ticket_type" required>
            <option value="Economy">Economy</option>
            <option value="Premium Economy">Premium Economy</option>
            <option value="Business Class">Business Class</option>
            <option value="First Class">First Class</option>
        </select><br>

       

        <button type="submit" name="add_flight">Add Flight</button>
    </form>
</body>
</html>
