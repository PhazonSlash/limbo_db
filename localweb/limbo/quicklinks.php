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
  </div>
<?php
session_start();

#Initialize Session Variables

if(isset($_SESSION["status_id"])){
 $status_id = $_SESSION["status_id"];
} else{
 $status_id = 'lost';
 }
 
if(isset($_SESSION["type"])){
 $type = $_SESSION["type"];
} else{
 $type = '0';
}

function location_form($dbc){
 echo '<form action="quicklinks.php">';
 echo	'<select name="loc_id">';
 echo '<option value=0>All Locations</option>';
	location_dropdown();
 echo  '<input type="submit" value="Submit">'; 
 echo	'</select>';
 echo  '</form>';
 

 if(isset($_GET['loc_id'])){
	show_item_by_location($dbc, $_GET['loc_id']);
	} else {
	show_item_by_location($dbc, 0);
	}
}

function status_form($dbc, $status_id){
 echo '<form action="quicklinks.php">';
 echo	'<select name="status_id">';
 echo '<option value=lost ' . check_status('lost') . '>Lost</option>';
 echo '<option value=found ' . check_status('found') . '>Found</option>';
 echo '<option value=claimed ' . check_status('claimed') . '>Claimed</option>';
 echo  '<input type="submit" value="Submit">'; 
 echo	'</select>';
 echo  '</form>';
  if(isset($_GET['status_id'])){
	$status_id = $_GET['status_id'];
	$_SESSION["status_id"] = $status_id;
	}
	$_SESSION["type"] = '1';
	show_item_by_status($dbc, $status_id);
}
# Connect to MySQL server and the database
require( '../limboincludes/connect_limbo_db.php' ) ;

# Includes these helper functions
require( '../limboincludes/limbo_helpers.php' ) ;
 echo '<form action="quicklinks.php">';
 echo	'<select name="type">';
 echo '<option value=0 ' . check_type('0') . '>Location</option>';
echo '<option value=1 ' . check_type('1') . '>Status</option>';
 echo  '<input type="submit" value="Submit">'; 
 echo	'</select>';
 echo  '</form>';
 
 if(isset($_GET['type'])){
	$type = $_GET['type'];
	$_SESSION["type"] = $type;
 } else {
   $type = $type;
   }
   #TESTING
 #echo '<p> Type = ' . $type . ' </p>';
 #echo '<p> Status_ID = ' . $status_id . ' </p>';
   #/TESTING
if($type == '0'){
	location_form($dbc);
} else if(isset($_GET['status_id']) || $type == '1') {
	status_form($dbc, $status_id);
}

if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {
	
	$type = $_POST['name'] ;
	
	$status = $_POST['status_id'] ;
	
	$location = $_POST['location'] ;
    }


# Show the records


# Close the connection
mysqli_close( $dbc ) ;
?>
<!-- Get inputs from the user. -->
<button onclick="goBack()">Go Back</button>
 </body>
</html>