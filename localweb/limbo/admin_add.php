<!DOCTYPE html>
<html>
<link rel="stylesheet" type="text/css" href="limboCSS.css"> 
 <title>Add Admins</title>
 <body>
  <div>
   <p>
	<a href="/limbo/admin_change.php">Change Status</a> <a href="/limbo/admin_delete.php">Remove Entries</a> <a href="/limbo/admin_change_password.php">Change Password</a>
	<a href="/limbo/admin_add.php">Add Administrator</a> <a href="/limbo/limbo_login.php">Log Out</a>
   </p>
  </div>
	<h1>Add Administrators</h1>
	<p>Here you can create new administrator accounts.</p>
	
<?php
# Connect to MySQL server and the database
require( '../limboincludes/connect_limbo_db.php' ) ;

# Includes these helper functions
require( '../limboincludes/limbo_helpers.php' ) ;


# Show the records
if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {
	
	$first = $_POST['first'] ;
	
	$last = $_POST['last'] ;
	
	$email = $_POST['email'] ;
	
	$password = $_POST['password'] ;
	
	$cpassword = $_POST['cpassword'] ;
	
	if($password == $cpassword){
		add_admin($dbc, $first, $last, $email, $password);
		echo '<p style="color:red">Administrator added successfully.</p>';
	} else {
	  echo '<p style="color:red">Passwords do not match! Try again.</p>';
	}
	}
	

# Close the connection
mysqli_close( $dbc ) ;
?>
<form action="" method="POST">
<table>
<tr>
<td>Your First Name:</td><td><input type="text" name="first"></td>
</tr>
<tr>
<td>Your Last Name:</td><td><input type="text" name="last"></td>
</tr>
<tr>
<td>Your Email:</td><td><input type="text" name="email"></td>
</tr>
<tr>
<td>Password:</td><td><input type="text" name="password"></td>
</tr>
<tr>
<td>Confirm Password:</td><td><input type="text" name="cpassword"></td>
</tr>
</table>
<p><input type="submit" ></p>
</form>
<button onclick="goBack()">Go Back</button>
 </body>
</html>