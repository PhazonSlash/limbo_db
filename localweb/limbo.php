<!DOCTYPE html>
<html>

 <title>Limbo Database</title>
 <body>
  <div>
   <a href="linkypresidents.php">Lost Something</a><a href="presidents_login.php">Found Something</a>
  </div>
	<h1>Welcome to Limbo!</h1>
	<p>If you lost or found something, you're in luck this is the place to report it.</p>
	
	<p>Reported in Last: </p>
	<form action="">
		<select name="Options">
			<option value="week">Week</option>
			<option value="month">Month</option>
			<option value="year">Year</option>
		</select>
	</form>
<?php
# Connect to MySQL server and the database
require( 'includes/connect_limbo_db.php' ) ;

# Includes these helper functions
require( 'includes/limbo_helpers.php' ) ;


# Show the records
show_limbo_records($dbc);

# Close the connection
mysqli_close( $dbc ) ;
?>
 </body>
</html>