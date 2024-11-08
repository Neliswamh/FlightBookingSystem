<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "letsfly";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

try {
    $pdo = new PDO("mysql:servername=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit();
}

// bookFlight.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect the form data
    $flight_number = $_POST['flight_number'] ?? '';
    $trip_type = $_POST['trip_type'] ?? '';
    $passengers = $_POST['passengers'] ?? 1;
    $ticket_type = $_POST['ticket_type'] ?? 'economy';

    // Validate required fields
    if (empty($flight_number) || empty($trip_type) || empty($passengers) || empty($ticket_type)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit();
    }

    // Insert booking data into complete_bookings table
    $sql = "INSERT INTO complete_bookings (flight_number, trip_type, passengers, ticket_type) VALUES (:flight_number, :trip_type, :passengers, :ticke_type)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            ':flight_number' => $flight_number,
            ':trip_type' => $trip_type,
            ':passengers' => $passengers,
            ':ticket_type' => $ticket_type
        ]);
        echo json_encode(['success' => true, 'message' => 'Booking successful!']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Booking failed.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}


    // Base prices for each ticket type
    $basePrices = [
        'economy' => 1100,
        'premium_economy' => 2000,
        'business class' => 5000,
        'first class' => 10000
    ];

    // Multipliers for trip type
    $trip_typeMultiplier = ($trip_type === 'return') ? 2 : 1;

    // Calculate total cost
    $ticketPrice = $basePrices[$ticket_type] ?? 100;
    $totalCost = $ticketPrice * $passengers * $trip_typeMultiplier;

   


?>

 <script>
    document.getElementById('bookingForm').addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(e.target);

		try{
		const response = await fetch('bookFlight.php', {
            method: 'POST',
            body: formData
        });

		if (!response.ok)
		{
			throw new 
			Error('Network response was not ok');
		}
           const result = await response.json();
		     console.log(result);
                if (result.success) {
                // Show the total cost to the user
                 const confirmBooking = confirm(`Total cost for your booking is $${result.totalCost}. Do you want to confirm?`);

           

		if (confirmBooking)
		{
		  const confirmationForm = document.createElement('form'); 
		  confirmationForm.method ='POST';
		  confirmationForm.action = 'bookFlight.php';

		  const flight_numberInput = document.createElement('input');

		  flight_numberInput.type  = 'hidden';

		  flight_numberInput.name = 'flight_number';

		  flight_numberInput.value=result.flight_number;

		  confirmationForm.appendChild(flight_numberInput);

		  const totalCostInput = document.createElement('input'); 

		  totalCostInput.type = 'hidden';
		  totalCostInput.name = 'totalCost';
		  confirmationForm.appendChild(totalCostInput);


		  const confirmBookingInput = document.createElement('input');

		 confirmBookingInput.type  = 'hidden';

		 confirmBookingInput.name = 'confirmBooking';

		  

		  confirmationForm.appendChild(confirmBookingInput);

		  document.body.appendChild(confirmationForm);
		  confirmationForm.submit();
		} else 
		{
			alert("Booking cancelled. Please try again");

		}
		else{
			alert("There was am issue calculating Your booking. Please Try again.");
		}
		}catch (error) 
		{ alert ("Error processing your request. Please try again");}
		} );
            


    fetchFlights();
</script>




 

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Confirm Your Booking</title>
  <link rel="stylesheet" href="./letsfly.css">
</head>
<body style="background-color: #d0d8e4">

  <header>
    <div class="logo">LetsFly</div>
    <nav>
        <a href="Flight.php">Flight</a>
        <a href="holidayfun.php">HolidayFun</a>
        <a href="index.php">Logout</a>
    </nav>
  </header>

  <h2>Your Total Cost is: E <?php echo $totalCost; ?> </h2>
  <p>Flight Number: <?php echo $flight_number; ?> </p>
  <br>
  <br>

  <!-- Confirmation and Cancellation Forms -->
  <form action="bookFlight.php" method="post">
    <button type="submit" name="confirmBooking" class="button" style="background-color:green; color:white;">Confirm Booking</button>
    <input type="hidden" name="flight_number" value="<?php echo $flight_number; ?>">
  </form>

  <form action="bookFlight.php" method="post">
    <button type="submit" name="cancelBooking" class="button" style="background-color:red; color:white;">Cancel Booking</button>
    <input type="hidden" name="flight_number" value="<?php echo $flight_number; ?>">
  </form>

</body>
</html>
