<!DOCTYPE html>
<html>

 <title>Lost</title>
 <body>
  <div>
   <p>
    <a href="lost.php">Lost Something</a> <a href="found.php">Found Something</a>
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
			show_record($dbc, $_GET['id']) ;
		}

# Show the records
#show_limbo_records($dbc);

# Close the connection
mysqli_close( $dbc ) ;
?>
<!-- Get inputs from the user. -->
<form action="found.php" method="POST">
	<p>Type of Item Lost: <input type="text" name="item" value="<?php if(isset($_POST['item'])) echo $_POST['item']; ?>">
	</p>
	<p><input type="submit"></p>
</form>
 </body>
</html>