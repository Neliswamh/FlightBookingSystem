<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="./letsfly.css">
</head>

<body style="background-color: #d0d8e4">

<header>
  <div class="logo">LetsFly</div>
  <nav>
    <a href="signup.php">SignUp</a>
    <a href="index.php">Exit</a>
  </nav>
</header>

<?php
if (isset($_GET['email']) && isset($_GET['password1'])) {
    $email = $_GET['email'];
    $password1 = $_GET['password1'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'letsfly');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT role, password1 FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password and redirect based on role
        if ($user['password1'] === $password1) { // Plain-text check, replace with password_hash() in production
            if ($user['role'] === 'admin') {
                header("Location: Admin_dashboard.php"); // Redirect to admin dashboard
            } else {
                header("Location: Flight.php"); // Redirect to user dashboard
            }
            exit();
        } else {
            $error = "Invalid username or password";
        }
    } else {
        $error = "Invalid username or password";
    }

    $stmt->close();
    $conn->close();
}
?>

<form method="get" action="">
    <h4>Log in to LetsFly</h4>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <br>
    <input type="text" id="Text" name="email" placeholder="Email" required><br><br>
    <input type="password" id="Text" name="password1" placeholder="Password" required><br><br>
    <input type="submit" id="Submit" value="Log in">
    <br><br>
</form>

</body>
</html>
