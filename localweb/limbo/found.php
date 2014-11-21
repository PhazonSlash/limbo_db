<!DOCTYPE html>
<html>
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
	<p>If you found something, you can see if someone reported lost.</p>
<?php
# Connect to MySQL server and the database
require( 'limboincludes/connect_limbo_db.php' ) ;

# Includes these helper functions
require( 'limboincludes/limbo_helpers.php' ) ;

if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {
	
	$item = $_POST['item'] ;
	
    }

# Show the records

# Close the connection
mysqli_close( $dbc ) ;
?>
<!-- Get inputs from the user. -->
<form action="found.php" method="POST">
	<p>Type of Item Found: <input type="text" name="item" value="<?php if(isset($_POST['item'])) echo $_POST['item']; ?>">
	</p>
	<p><input type="submit" formaction="found-1.php"></p>';
</form>
 </body>
 <button onclick="goBack()">Go Back</button>
</html>