<!DOCTYPE html>
<html>
<link rel="stylesheet" type="text/css" href="limbo/limboCSS.css">    
 <script>
	function goBack() {
		window.history.back()
	}
</script>

 <title>Item</title>
 <body>
  <div>
   <p>
    <a href="/limbo/lost.php">Lost Something</a> <a href="/limbo/found.php">Found Something</a> <a href="/limbo/quicklinks.php">Quick Links</a>
   </p>
  </div>
  <div>
	<h1>Item</h1>
  </div>
<?php
# Connect to MySQL server and the database
require( '../limboincludes/connect_limbo_db.php' ) ;

# Includes these helper functions
require( '../limboincludes/limbo_helpers.php' ) ;

if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {
	
	$lname = $_POST['name'] ;
	
	$item = $_POST['item'] ;
	
	$location = $_POST['location'] ;
    }

# Show the records
show_item($dbc);

# Close the connection
mysqli_close( $dbc ) ;
?>
<!-- Get inputs from the user. -->
<button onclick="goBack()">Go Back</button>
 </body>
</html>