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

    if(!empty($number) && !empty($fname) && !empty($lname)) {
		
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
	  

      #echo "<p>Added " . $number . " new print(s) ". $fname . " @ $" . $lname . " .</p>" ;
    }
	else{
		echo '<p style="color:red">Please input first name, last name and number!.</p>';
		}
}

# Show the records
show_records($dbc);

# Close the connection
mysqli_close( $dbc ) ;
?>

<!-- Get inputs from the user. -->
<form action="vipresidents.php" method="POST">
<table>
<tr>
<td>Number:</td><td><input type="text" name="number"></td>
</tr>
<tr>
<td>First Name:</td><td><input type="text" name="fname"></td>
</tr>
<tr>
<td>Last Name:</td><td><input type="text" name="lname"></td>
</tr>
</table>
<p><input type="submit" ></p>
</form>
</html>