<?php 

 include 'connect.php';

 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $gender = $_POST['Gender'];
    $email = $_POST['email'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];

    // Check if the passwords match
    if ($password1 === $password2) {
        // Hash the password before storing it in the database
        $hashed_password = password_hash($password1, PASSWORD_BCRYPT);

        // Prepare the SQL statement
        $sql = "INSERT INTO users (firstname, lastname, gender, email, password1) 
                VALUES ('$firstname', '$lastname', '$gender', '$email', '$password1')";

        // Execute the query and check if it was successful
        if ($conn->query($sql) === TRUE) {
            echo "<p>   Sign-up successful! You will be redirected to the flight booking page in a few seconds</p>";

			   echo "<script> 
			     
				 setTimeout (function(){
				 	 window.location.href ='Flight.php'; }, 2000);
					 </script> ";

					 exit();

			
         } 
		else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Passwords do not match.";
    }

    // Close the database connection
    $conn->close();
}

 ?>

<!DOCTYPE html>


<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flights</title>
  <link rel="stylesheet" href="./letsfly.css">
</head>

  <header>
    <div class="logo">LetsFly</div>
    <nav>
      
	  <a href="login.php">Login</a>
	  <a href="index.php">Exit</a>
    </nav>
  </header>

<body style="background-color: #d0d8e4">



<form method="post">
  <h4>Sign Up to LetsFly</h4>
  <input type="text" name="firstname" placeholder="Name" required><br>
  <input type="text" name="lastname" placeholder="Lastname" required><br>
  
  <label>Gender:</label>
  <input type="radio" name="Gender" value="Female" required> Female
  <input type="radio" name="Gender" value="Male" required> Male
  <input type="radio" name="Gender" value="Other" required> Other<br><br>

  <input type="text" name="email" placeholder="Email" required><br><br>
  <input type="password" name="password1" placeholder="Password" required><br><br>
  <input type="password" name="password2" placeholder="Retype Password" required><br><br>
  
  <a href="flight.php"><input type="submit" value="Sign Up"></a>
</form>

</body>