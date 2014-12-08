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

    $owner = '' ;
	
	$finder = $_POST['finder'];
	
	$status = 'found';
	

    if(!empty($description) && !empty($finder)) {
		
		$result = insert_record($dbc, $location_id, $description, $room, $owner, $finder, $status ) ;
		header("Location: /limbo/thanks.php");
		
    }
	else{
		echo '<p style="color:red">Please input first name, last name and number!.</p>';
		}
 }

# Close the connection
mysqli_close( $dbc ) ;
?>
<form action="newfound.php" method="POST">
<table>
<tr>
<td>Your Name:</td><td><input type="text" name="finder"></td>
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