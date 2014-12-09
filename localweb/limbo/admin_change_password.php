<!DOCTYPE html>
<html>
<link rel="stylesheet" type="text/css" href="limboCSS.css"> 
 <script>
	function goBack() {
		window.history.back()
	}
</script>
 <title>Change Password</title>
 <body>
  <div>
   <p>
    <a href="/limbo/admin_change.php">Change Status</a> <a href="/limbo/admin_delete.php">Remove Entries</a> <a href="/limbo/admin_change_password.php">Change Password</a>
	<a href="/limbo/admin_add.php">Add Administrator</a> <a href="/limbo/limbo_login.php">Log Out</a
	
   </p>
  </div>
	<h1>Change Password</h1>
	<p>Here you can change your administrator account password.</p>
	
<?php
# Connect to MySQL server and the database
require( '../limboincludes/connect_limbo_db.php' ) ;

# Includes these helper functions
#require( '../limboincludes/limbo_helpers.php' ) ;
require( '../limboincludes/limbo_login_tools.php' ) ;

# Show the records
if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {

	$name = $_POST['name'] ;
	
	$old = $_POST['old'] ;
	
	$new = $_POST['new'] ;
	
	$cnew = $_POST['cnew'] ;
	;

if (validate($name, $old) == -1){
		echo '<p style="color:red">Invalid Login Credentials</p>';
	} elseif($new != $cnew){
		echo '<p style="color:red">New passwords do not match!</p>';
	} else{

	$update_query = 'UPDATE users SET pass="'. $new .'" WHERE email = "'. $name .'"';
	$results = mysqli_query($dbc, $update_query) ;
	check_results($results) ;
	echo '<p style="color:red">Update Successful!</p>';
	echo '<a href="../limbo/admin_change.php">Click Here to return to admin page.</a>';
	}
	
    }
echo '<form action="" method="POST">';
echo '<table>';
echo '<tr><td>Email:</td><td><input type="text" name="name"></td></tr>';
echo '<tr><td>Old Password:</td><td><input type="text" name="old"></td></tr>';
echo '<tr><td>New Password:</td><td><input type="text" name="new"></td></tr>';
echo '<tr><td>Confirm New Password:</td><td><input type="text" name="cnew"></td></tr>';
echo '</table>';
echo '<p><input type="submit" ></p>';
echo '</form>';
echo '<button onclick="goBack()">Go Back</button>';

# Close the connection
mysqli_close( $dbc ) ;
?>

 </body>
</html>