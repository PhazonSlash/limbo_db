<!DOCTYPE html>
<html>
<link rel="stylesheet" type="text/css" href="limboCSS.css">    
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
######################################################################################################################
#This function will produce the drop-down menu.
function location_form($dbc){
#This is the list of locations
 echo '<form action="" method="post">';
 echo	'<select name="loc_id">';
 echo '<option value=0>All Locations</option>'; #First option is here
	location_dropdown(); #This function in helpers gets the locations from database and forms the rest of the options
if(!isset($_POST['type'])){
	echo '<input type="hidden" name="type" value="0" />';
}
if(!isset($_POST['status_id'])){
	echo '<input type="hidden" name="status_id" value="lost" />';
}
 echo  '<input type="submit" value="Submit">'; 
 echo	'</select>';
 echo  '</form>';
 
#If the user selected a location, show that location
 if(isset($_POST['loc_id'])){
	show_item_by_location($dbc, $_POST['loc_id']);
	} else {
	#Otherwise, show from all locations
	show_item_by_location($dbc, 0);
	}
}
######################################################################################################################
#This function displays the status dropdown
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
 
 #If the used selected a status
  if(isset($_GET['status_id'])){
	$status_id = $_GET['status_id'];
	}
	#Display the table sorted by status
	show_item_by_status($dbc, $status_id);
}
######################################################################################################################
# Connect to MySQL server and the database
require( '../limboincludes/connect_limbo_db.php' ) ;

# Includes these helper functions
require( '../limboincludes/limbo_helpers.php' ) ;

#This creates the dropdown that can select between the location dropdown and the status dropdown
 echo '<form action="" method="post">';
 echo	'<select name="type">';
 echo '<option value=0 ' . check_type('0') . '>Location</option>'; #The call to the check_type function will return "selected"
echo '<option value=1 ' . check_type('1') . '>Status</option>';	   #if the user had selected the option before.

#If no status was set by the user, use "lost" as a default
if(!isset($_POST['status_id'])){
echo '<input type="hidden" name="status_id" value="lost" />';
}
 echo  '<input type="submit" value="Submit">'; 
 echo	'</select>';
 echo  '</form>';

 
if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {
	#If the user set a type, put it in the $type variable
	if(isset($_POST['type'])){
		$type = $_POST['type'] ;
	}
	#Make sure the $status variable has a value
	if(isset($_POST['status_id'])){
		$status = $_POST['status_id'] ;
	} else {
		$status = 'lost';
	}
	
   if(isset($type)){
	#If type is 0, show the location form
	if($type == '0'){
		location_form($dbc);
	#Otherwise show the status form
	} else if(isset($_GET['status_id']) || $type == '1') {
		status_form($dbc, $status);
	}
   }
 }


# Show the location form if no type is set
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