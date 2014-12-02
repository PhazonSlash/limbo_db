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

 echo '<form action="">';
 echo	'<select name="days">';
 echo '<option value=7>Week</option>';
 echo '<option value=30>Month</option>';
 echo '<option value=365>Year</option>'; 
 echo  '<input type="submit" value="Submit">'; 
 echo	'</select>';
 echo  '</form>';

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
if(isset($_GET['days'])){
show_item_by_date_range($dbc, $_GET['days']);
} else {
show_item_by_date_range($dbc, 7);
}
?>
 </body>
</html>