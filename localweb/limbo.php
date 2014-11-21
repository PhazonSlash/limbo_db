<!DOCTYPE html>
<html>

 <title>Limbo Database</title>
 <body>
  <div>
   <p>
    <a href="limbo/lost.php">Lost Something</a> <a href="limbo/found.php">Found Something</a> <a href="limbo/quicklinks.php">Quick Links</a>
   </p>
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
require( '/limboincludes/connect_limbo_db.php' ) ;

# Includes these helper functions
require( '/limboincludes/limbo_helpers.php' ) ;


# Show the records
#show_item_by_location($dbc);

# Close the connection
mysqli_close( $dbc ) ;
?>
 </body>
</html>