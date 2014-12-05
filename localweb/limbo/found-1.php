<!DOCTYPE html>
<html>
<link rel="stylesheet" type="text/css" href="limbo/limboCSS.css">    
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
	<h1>Found Something?</h1>
	<p>If you found something, you can see if someone reported it lost.</p>
<?php
# Connect to MySQL server and the database
require( '../limboincludes/connect_limbo_db.php' ) ;

# Includes these helper functions
require( '../limboincludes/limbo_helpers.php' ) ;

if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {
	
	$item = $_POST['item'] ;
	
    }
	else if($_SERVER[ 'REQUEST_METHOD' ] == 'GET') {
		if(isset($_GET['id']))
			search($dbc, $_GET['id']) ;
		}

# Show the records
$status = 'lost';
search($dbc, $status, $item);

# Close the connection
mysqli_close( $dbc ) ;
?>
<a href="/limbo/newlost.php">Click Here to Report a New Found Item</a><br>
<br>
<button onclick="goBack()">Go Back</button>
 </body>
</html>