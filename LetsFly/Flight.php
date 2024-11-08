
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flights</title>
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
<body>
    
        <h2>Booking Form</h2>
        <form action="bookFlight.php" method="POST" id="bookingForm">
            <div class="form-group">
			  <div class="container">
        <h3>Select Your Flight</h3>
		 <br>

        <div id="flights-container"></div>
		<h2> Book Seat</h2> 
		  <iframe src="connectWebsocket.html" width="100%" height="300px" frameborder="0"></iframe>
                <label for="flight_number">Flight Number</label>
                <input type="text" id="flight_number" name="flight_number" readonly required>
            </div>
            <div class="form-group">
                <label for="trip_type">Trip Type</label>
                <select id="trip_type" name="trip_type" required>
                    <option value="one_way">One Way</option>
                    <option value="return">Return</option>
                </select>
            </div>
            <div class="form-group">
                <label for="passengers">Number of Passengers</label>
                <input type="number" id="passengers" name="passengers" min="1" required>
            </div>
            <div class="form-group">
                <label for="ticket_type">Ticket Type</label>
                <select id="ticket_type" name="ticket_type" required>
                    <option value="economy">Economy</option>
                    <option value="premium_economy">Premium Economy</option>
                    <option value="business">Business class</option>
                    <option value="first">First Class</option>
                </select>
            </div>
            <button type="submit" class="submit-btn">Book Flight</button>
        </form>
    </div> 
    

    <script>
    
        async function fetchFlights() {
            const response = await fetch('getFlights.php');
            const flights = await response.json();

            const flightsContainer = document.getElementById('flights-container');
            flightsContainer.innerHTML = '';
           
            flights.forEach(flight => {
                const flightElement = document.createElement('div');
                flightElement.textContent = `${flight.flight_number} - ${flight.origin} to ${flight.destination}     |   Date:${flight.departure_time}`;
                flightElement.style.cursor = 'pointer';
                flightElement.addEventListener('click', () => {
                    document.getElementById('flight_number').value = flight.flight_number;
                });
                flightsContainer.appendChild(flightElement);
            });
        }

        document.getElementById('bookingForm').addEventListener('submit', async (e) => {
            
           
            const formData = new FormData(e.target);
            const response = await fetch('bookFlight.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

			 
			 
			if (result.success)
			{window.location.href="bookFlight.php";}
			 else{
            alert(result.message);}
        });

        fetchFlights();
    </script>
</body>
</html>