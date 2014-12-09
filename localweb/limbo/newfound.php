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
	<h1>Report Found</h1>
	<p>You can report a new found item here.</p>
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
	
	$status = 'found';

    if(!empty($description) && !empty($first) && !empty($last)) {
		
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
<form action="newfound.php" method="POST">
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
<td>Your Phone:</td><td><input type="text" name="phone"></td>
</tr>
<tr>
<td>Item Description:</td><td><input type="text" name="description"></td>
</tr>
<tr>
<td>Where You Found It:</td><td><select name="location_id">
<?php location_dropdown(); ?>
</td>
</tr>
<tr>
<td>Room:</td><td><input type="text" name="room"></td>
</tr>
</table>
<p><input type="submit" ></p>
</form>
<button onclick="goBack()">Go Back</button>
 </body>
</html>