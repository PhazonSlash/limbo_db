<!--
This PHP script was modified based on result.php in McGrath (2012).
It demonstrates how to ...
  1) Connect to MySQL.
  2) Write a complex query.
  3) Format the results into an HTML table.
  4) Update MySQL with form input.
By Ron Coleman
-->
<!DOCTYPE html>
<html>
<?php
# Connect to MySQL server and the database
require( 'includes/connect_db.php' ) ;

# Includes these helper functions
require( 'includes/helpers.php' ) ;

if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {
	$number = $_POST['number'] ;

    $fname = $_POST['fname'] ;
	
	$lname = $_POST['lname'] ;
	
		if(!valid_number($number)){ 
			echo '<p style="color:red">Please give a valid number.</p>';
			}
		else if (!valid_name($fname)){
			echo '<p style="color:red">Please complete the first name.</p>';
			}
		else if (!valid_name($lname)){
			echo '<p style="color:red">Please complete the last name.</p>';
			}
		else{
		$result = insert_record($dbc, $number, $fname, $lname) ;
		}
    }
	else if($_SERVER[ 'REQUEST_METHOD' ] == 'GET') {
		if(isset($_GET['id']))
			show_record($dbc, $_GET['id']) ;
		}

# Show the records
show_link_records($dbc);

# Close the connection
mysqli_close( $dbc ) ;
?>


<!-- Get inputs from the user. -->
<form action="linkypresidents.php" method="POST">
	<p>Number: <input type="text" name="number" value="<?php 
		if (isset($_POST['number'])) echo $_POST['number']; ?>">
	</p>
	<p>First Name: <input type="text" name="fname" value="<?php if(isset($_POST['fname'])) echo $_POST['fname']; ?>">
	</p>
	<p>Last Name: <input type="text" name="lname" value="<?php if(isset($_POST['lname'])) echo $_POST['lname']; ?>">
	</p>
	<p><input type="submit"></p>
</form>
</html>