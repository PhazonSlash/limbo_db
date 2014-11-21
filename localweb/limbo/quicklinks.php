<!DOCTYPE html>
<html>
 <script>
	function goBack() {
		window.history.back()
	}
</script>

 <title>Quick Links</title>
 <body>
  <div>
    <a href="/limbo/lost.php">Lost Something</a> <a href="/limbo/found.php">Found Something</a> <a href="/limbo/quicklinks.php">Quick Links</a>
  </div>
  <div>
	<h1>Quick Links</h1>
	<form action="">
		<select name="Links">
			<option value="location">By Location</option>
			<option value="date"></option>
		</select>
	</form>
	<?php 
	
	?>
  </div>
<?php
# Connect to MySQL server and the database
require( '../limboincludes/connect_limbo_db.php' ) ;

# Includes these helper functions
require( '../limboincludes/limbo_helpers.php' ) ;

 echo '<form action="">';
 echo	'<select name="loc_id">';
 echo '<option value=0>All Locations</option>';
	location_dropdown();
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
if(isset($_GET['loc_id'])){
show_item_by_location($dbc, $_GET['loc_id']);
} else {
show_item_by_location($dbc, 0);
}

# Close the connection
mysqli_close( $dbc ) ;
?>
<!-- Get inputs from the user. -->
<button onclick="goBack()">Go Back</button>
 </body>
</html>