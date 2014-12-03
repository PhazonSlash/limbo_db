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
<?php
# Connect to MySQL server and the database
require( '/limboincludes/connect_limbo_db.php' ) ;

# Includes these helper functions
require( '/limboincludes/limbo_helpers.php' ) ;

if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {
	
	$days = $_POST['days'] ;
	
    } else {
		$days = '7';
	}

 echo '<form action="" method="post">';
 echo	'<select name="days">';
 echo '<option value=7 '. check_current_status('7', $days) .'>Week</option>';
 echo '<option value=30 '. check_current_status('30', $days) .'>Month</option>';
 echo '<option value=365 '. check_current_status('365', $days) .'>Year</option>'; 
 echo  '<input type="submit" value="Submit">'; 
 echo	'</select>';
 echo  '</form>';


# Show the records
show_item_by_date_range($dbc, $days);

?>
 </body>
</html>