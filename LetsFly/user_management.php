<?php
session_start();
require 'connect.php';
		

if($_SERVER['REQUEST_METHOD'] == 'POST')
   {
   
     $email =$_POST['email'];
       $password1 =$_POST['password1'];

	   $stmt =$conn->prepare("SELECT user_id,role,password1 From users WHERE email =?");
	     $stmt-> bind_param("s",$email);
		 $stmt->execute();
		 $result = $stmt->get_result();
		 if($result -> num_rows > 0) {
		     $user = $result->fetch_assoc();

			 if(password_verify($password1,$user['password1']))

			   {
			   	   $_SESSION['user_id'] = $user['user_id'];
				    $_SESSION['role'] = $user['role'];
					 $_SESSION['email'] = $email;

					 header("Location: user_management.php");
					     exit();

			   }
			   else { $error = "User Not Found!"; 
			   }
			  }
		    
   }



// Fetch users
$result = $conn->query("SELECT * FROM users");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $user_id = $_POST['user_id'];
    $conn->query("DELETE FROM users WHERE user_id = $user_id");
    header("Location: user_management.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head><title>Admin Panel - Users</title></head>
<body>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
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
<h2>Manage Users:</h2>
<table border="1" class="table-edit">
    <tr><th>User ID</th><th>Name</th><th>Email</th><th>Role</th><th>Action</th></tr>
    <?php while ($user = $result->fetch_assoc()): ?>
        <tr>
		     
            <td><?= $user['user_id'] ?></td>
            <td><?= $user['firstname'] . " " . $user['lastname'] ?></td>
            <td><?= $user['email'] ?></td>
            <td><?= $user['role'] ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                    <button type="submit" name="delete">Delete</button>
                </form>
            </td>
        </tr>

    <?php 
	   endwhile; 
	
	?>
</table>
</body>
</html>

