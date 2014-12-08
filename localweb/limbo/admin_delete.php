<!DOCTYPE html>
<html>
<link rel="stylesheet" type="text/css" href="limboCSS.css"> 
 <title>Delete Entries</title>
 <body>
  <div>
   <p>
    <a href="/limbo/lost.php">Lost Something</a> <a href="/limbo/found.php">Found Something</a> <a href="/limbo/quicklinks.php">Quick Links</a> 
	<a href="/limbo/admin_change.php">Change Status</a> <a href="/limbo/admin_delete.php">Remove Entries</a> <a href="/limbo/admin_change_password.php">Change Password</a>
   </p>
  </div>
	<h1>Delete Entries</h1>
	<p>Here you can remove entries from the database.</p>
	
<?php
# Connect to MySQL server and the database
require( '../limboincludes/connect_limbo_db.php' ) ;

# Includes these helper functions
require( '../limboincludes/limbo_helpers.php' ) ;


# Show the records
if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {
	
	$id = $_POST['id'] ;
	
	delete_item($dbc, $id);
	}
	
	admin_delete_item($dbc);

# Close the connection
mysqli_close( $dbc ) ;
?>
<button onclick="goBack()">Go Back</button>
 </body>
</html>