<!DOCTYPE html>
<html>
 <script>
	function goBack() {
		window.history.back()
	}
</script>

 <title>Quick Links</title>
 <body>
  <div>
   <p>
    <a href="/limbo/lost.php">Lost Something</a> <a href="/limbo/found.php">Found Something</a> <a href="/limbo/quicklinks.php">Quick Links</a>
   </p>
  </div>
  <div>
	<h1>Quick Links</h1>
	<form action="">
		<select name="Links">
			<option value="week">Location</option>
			<option value="month">Date</option>
		</select>
	</form>
  </div>
<?php
# Connect to MySQL server and the database
require( 'limboincludes/connect_limbo_db.php' ) ;

# Includes these helper functions
require( 'limboincludes/limbo_helpers.php' ) ;

if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {
	
	$lname = $_POST['name'] ;
	
	$item = $_POST['item'] ;
	
	$location = $_POST['location'] ;
    }
	else if($_SERVER[ 'REQUEST_METHOD' ] == 'GET') {
		if(isset($_GET['id']))
			show_record($dbc, $_GET['id']) ;
		}

# Show the records
show_item_by_location($dbc);

# Close the connection
mysqli_close( $dbc ) ;
?>
<!-- Get inputs from the user. -->
<button onclick="goBack()">Go Back</button>
 </body>
</html>