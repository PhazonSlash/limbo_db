<!DOCTYPE html>
<html>

 <title>Found</title>
 <body>
  <div>
   <p>
    <a href="lost.php">Lost Something</a> <a href="found.php">Found Something</a>
   </p>
  </div>
	<h1>Found Something?</h1>
	<p>If you found something, you can post it here.</p>
<?php
# Connect to MySQL server and the database
require( 'limboincludes/connect_limbo_db.php' ) ;

# Includes these helper functions
require( 'limboincludes/limbo_helpers.php' ) ;

if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {

    $fname = $_POST['fname'] ;
	
	$lname = $_POST['lname'] ;
	
	$item = $_POST['item'] ;
	
	$location = $_POST['location'] ;
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
	<p>First Name: <input type="text" name="fname" value="<?php if(isset($_POST['fname'])) echo $_POST['fname']; ?>">
	</p>
	<p>Last Name: <input type="text" name="lname" value="<?php if(isset($_POST['lname'])) echo $_POST['lname']; ?>">
	</p>
	<p>Item Found: <input type="text" name="item" value="<?php if(isset($_POST['item'])) echo $_POST['item']; ?>">
	</p>
	<p>Location Found: <input type="text" name="location" value="<?php if(isset($_POST['location'])) echo $_POST['location']; ?>">
	</p>
	<p>Description: <input type="text" name="description" value="<?php if(isset($_POST['description'])) echo $_POST['description']; ?>">
	</p>
	<p><input type="submit"></p>
</form>
 </body>
</html>