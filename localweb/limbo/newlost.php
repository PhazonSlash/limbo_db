<!DOCTYPE html>
<html>
<link rel="stylesheet" type="text/css" href="limboCSS.css">    
<script>
	function goBack() {
		window.history.back()
	}
</script>
 <title>Found</title>
 <body>
  <div>
   <p>
    <a href="/limbo/lost.php">Lost Something</a> <a href="/limbo/found.php">Found Something</a> <a href="/limbo/quicklinks.php">Quick Links</a>
   </p>
   </p>
  </div>
	<h1>Report Lost</h1>
	<p>You can report a new lost item here.</p>
<?php
# Connect to MySQL server and the database
require( '../limboincludes/connect_limbo_db.php' ) ;

# Includes these helper functions
require( '../limboincludes/limbo_helpers.php' ) ;

# location, description, create_date, update_date, room, owner, finder, status

if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {
	$location_id = $_POST['location_id'] ;

    $description = $_POST['description'] ;
	
	$room = $_POST['room'] ;

    $first = $_POST['first'] ;
	
	$last = $_POST['last'] ;
	
	$email = $_POST['email'] ;
	
	$phone = $_POST['phone'] ;
	
	$status = 'lost';
	

    if(!empty($description) && !empty($first) && !empty($last) && !empty($email)) {
		
		$result = insert_record($dbc, $location_id, $description, $room, $first, $last, $email, $phone, $status ) ;
		header("Location: /limbo/thanks.php");
    }
	else{
		echo '<p style="color:red">Please input first name, last name, email, and item description!.</p>';
		}
 }

# Close the connection
mysqli_close( $dbc ) ;
?>
<p>Fields marked with * are required.</p>
<form action="newlost.php" method="POST">
<table>
<tr>
<td>*Your First Name:</td><td><input type="text" name="first" value="<?php if(isset($_POST['first'])) echo $_POST['first']; ?>"></td>
</tr>
<tr>
<td>*Your Last Name:</td><td><input type="text" name="last" value="<?php if(isset($_POST['last'])) echo $_POST['last']; ?>"></td>
</tr>
<tr>
<td>*Your Email Address:</td><td><input type="text" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>"></td>
</tr>
<tr>
<td>Your Phone Number:</td><td><input type="text" name="phone" value="<?php if(isset($_POST['phone'])) echo $_POST['phone']; ?>"></td>
</tr>
<tr>
<td>*Item Description:</td><td><input type="text" name="description" value="<?php if(isset($_POST['description'])) echo $_POST['description']; ?>"></td>
</tr>
<tr>
<td>*Where You Last Saw It:</td><td><select name="location_id">
<?php location_dropdown(); ?>
</td>
</tr>
<tr>
<td>Room:</td><td><input type="text" name="room" value="<?php if(isset($_POST['room'])) echo $_POST['room']; ?>"></td>
</tr>
</table>
<p><input type="submit" ></p>
</form>
<button onclick="goBack()">Go Back</button>
 </body>
</html>