<!DOCTYPE html>
<html>
<script>
	function goBack() {
		window.history.back()
	}
</script>
 <title>Lost</title>
 <body>
  <div>
   <p>
    <a href="/limbo/lost.php">Lost Something</a> <a href="/limbo/found.php">Found Something</a> <a href="/limbo/quicklinks.php">Quick Links</a>
   </p>
   </p>
  </div>
	<h1>Lost Something?</h1>
	<p>If you lost something, you can search for it here.</p>
<?php
# Connect to MySQL server and the database
require( 'limboincludes/connect_limbo_db.php' ) ;

# Includes these helper functions
require( 'limboincludes/limbo_helpers.php' ) ;

if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {
	
	$item = $_POST['item'] ;
	
    }
	else if($_SERVER[ 'REQUEST_METHOD' ] == 'GET') {
		if(isset($_GET['id']))
			search($dbc, $_GET['id']) ;
		}

# Show the records
$status = 'found';
search($dbc, $status, $item);

# Close the connection
mysqli_close( $dbc ) ;
?>
<a href="/limbo/newlost.php">Click Here to Report a New Lost Item</a><br>
<br>
<button onclick="goBack()">Go Back</button>
 </body>
</html>