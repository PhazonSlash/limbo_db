<!DOCTYPE html>
<html>
<link rel="stylesheet" type="text/css" href="limbo/limboCSS.css">    
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
  </div>
<?php

function location_form($dbc){
 echo '<form action="" method="post">';
 echo	'<select name="loc_id">';
 echo '<option value=0>All Locations</option>';
	location_dropdown();
if(!isset($_POST['type'])){
	echo '<input type="hidden" name="type" value="0" />';
}
if(!isset($_POST['status_id'])){
	echo '<input type="hidden" name="status_id" value="lost" />';
}
 echo  '<input type="submit" value="Submit">'; 
 echo	'</select>';
 echo  '</form>';
 

 if(isset($_POST['loc_id'])){
	show_item_by_location($dbc, $_POST['loc_id']);
	} else {
	show_item_by_location($dbc, 0);
	}
}

function status_form($dbc, $status_id){
 echo '<form action="" method="post">';
 echo	'<select name="status_id">';
 echo '<option value=lost ' . check_status('lost') . '>Lost</option>';
 echo '<option value=found ' . check_status('found') . '>Found</option>';
 echo '<option value=claimed ' . check_status('claimed') . '>Claimed</option>';
 echo '<input type="hidden" name="type" value="1" />';
 echo  '<input type="submit" value="Submit">'; 
 echo	'</select>';
 echo  '</form>';
  if(isset($_GET['status_id'])){
	$status_id = $_GET['status_id'];
	}
	show_item_by_status($dbc, $status_id);
}
# Connect to MySQL server and the database
require( '../limboincludes/connect_limbo_db.php' ) ;

# Includes these helper functions
require( '../limboincludes/limbo_helpers.php' ) ;
 echo '<form action="" method="post">';
 echo	'<select name="type">';
 echo '<option value=0 ' . check_type('0') . '>Location</option>';
echo '<option value=1 ' . check_type('1') . '>Status</option>';
if(!isset($_POST['status_id'])){
echo '<input type="hidden" name="status_id" value="lost" />';
}
 echo  '<input type="submit" value="Submit">'; 
 echo	'</select>';
 echo  '</form>';
 
   #TESTING
 #echo '<p> Type = ' . $type . ' </p>';
 #echo '<p> Status_ID = ' . $status_id . ' </p>';
   #/TESTING

if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {
	if(isset($_POST['type'])){
		$type = $_POST['type'] ;
	}
	if(isset($_POST['status_id'])){
		$status = $_POST['status_id'] ;
	}
	
   if(isset($type)){
	if($type == '0'){
		location_form($dbc);
	} else if(isset($_GET['status_id']) || $type == '1') {
		status_form($dbc, $status);
	}
   }
 }


# Show the records
if(!isset($type)){
location_form($dbc);
}

# Close the connection
mysqli_close( $dbc ) ;
?>
<!-- Get inputs from the user. -->
<button onclick="goBack()">Go Back</button>
 </body>
</html>