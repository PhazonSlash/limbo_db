<?php
$debug = true;
########################################################################################################################
# Inserts a record into the stuff table
function insert_record($dbc, $location_id, $description, $room, $first, $last, $email, $phone, $status) {
#Check to see if user already exists, if not, create it
 $existing_user_id = getUserId($dbc, $first, $last, $email);

 if ($existing_user_id == -1){
 $insert_query = 'INSERT INTO users(first_name, last_name, email, pass, reg_date, phone) 
		VALUES ("' . $first . '" , "' . $last . '" , "'. $email .'", "", now(), "' . $phone . '")' ;
		
  $results = mysqli_query($dbc, $insert_query) ;
  check_results($results) ;
  
   $existing_user_id = getUserId($dbc, $first, $last, $email);
 }
  #If the user is reporting a lost item
  if($status == 'lost'){
	$owner_id = $existing_user_id;
  } else {
    $owner_id = '';
  }
  #If the user is reporting a found item
  if($status == 'found'){
	$finder_id = $existing_user_id;
  } else {
    $finder_id = '';
  }
  #Put the item into the database
  $insert_query = 'INSERT INTO stuff(location_id, description, create_date, update_date, room, owner, finder, status) 
		VALUES (' . $location_id . ' , "' . $description . '" , now(), now(), "' . $room . ' ", "' . $owner_id . '" , "' . $finder_id . '" ,"' . $status . '")' ;

  $results = mysqli_query($dbc, $insert_query) ;
  check_results($results) ;

  return $results ;
}
########################################################################################################################
#Checks newly input user information to see if it exists in the database
#Returns user_id if found, else returns -1
function getUserId($dbc, $first, $last, $email){
  $get_id_query = 'SELECT user_id, first_name, last_name, email 
				   FROM users 
				   WHERE first_name = "'. $first .'" AND last_name = "'. $last .'" AND email = "'. $email .'"';
  $results = mysqli_query($dbc, $get_id_query) ;
  check_results($results);
  
	$row = mysqli_fetch_array( $results , MYSQLI_ASSOC );
  if($row['user_id'] != ''){ 
	$id = $row['user_id'];
  } else {
	$id = '-1';
  }
  return $id;
}
########################################################################################################################
# Checks the query results as a debugging aid
function check_results($results) {
  global $dbc;

  if($results != true)
    echo '<p>SQL ERROR = ' . mysqli_error( $dbc ) . '</p>'  ;
}
########################################################################################################################
#Creates the locations dropdown menu seen in the quick links page
function location_dropdown(){
# Connect to MySQL server and the database
require( '../limboincludes/connect_limbo_db.php' ) ;

# Create a query to get the name and price sorted by price
$query = 'SELECT DISTINCT id, name
		  FROM locations';

# Execute the query
$results = mysqli_query( $dbc , $query ) ;

# Show results
if( $results )
{

  # For each row result, generate a table row
  while ( $row = mysqli_fetch_array( $results , MYSQLI_ASSOC ) )
  {

	echo '<option value ="' . $row['id'] . '">'. $row['name'] .'</option>' ;

  }

  # Free up the results in memory
  mysqli_free_result( $results ) ;
}
else
{
  # If we get here, something has gone wrong
  echo '<p>' . mysqli_error( $dbc ) . '</p>'  ;
}

# Close the connection
mysqli_close( $dbc ) ;
}

############################################################################################################################################
#Creates a table of items from a single location selected by the user
function show_item_by_location($dbc, $loc_id){
# Connect to MySQL server and the database
require( '../limboincludes/connect_limbo_db.php' ) ;

#If the user has not specified a location, display items in all locations
 if($loc_id == 0){
 $query = 'SELECT DISTINCT locations.id, stuff_id, name, description, stuff.create_date, stuff.update_date, room, owner, finder, status
		  FROM locations, stuff
		  WHERE locations.id = stuff.location_id
		  ORDER BY locations.id ASC' ;
 }
 #If the user specified a location, get only items in that location
 else {
 $query = 'SELECT DISTINCT locations.id, stuff_id, name, description, stuff.create_date, stuff.update_date, room, owner, finder, status
		  FROM locations, stuff
		  WHERE locations.id = stuff.location_id and locations.id = ' . $loc_id . '
		  ORDER BY locations.id ASC' ;
 }
# Execute the query
$results = mysqli_query( $dbc , $query ) ;

# Show results
if( $results )
{
  # But...wait until we know the query succeeded before
  # starting the table.
  echo '<TABLE border="1">';
  echo '<TR>';
  echo '<TH>Location</TH>';
  echo '<TH>Item Description</TH>';
  echo '<TH>Status</TH>';
  echo '</TR>';

  # For each row result, generate a table row
  while ( $row = mysqli_fetch_array( $results , MYSQLI_ASSOC ) )
  {
	#Create a link to the item
	$alink = '<A HREF=/limbo/item.php?id=' . $row['stuff_id'] . '>' . $row['description'] . '</A>' ;
    echo '<TR>' ;
	echo '<TD>' . $row['name'] . '</TD>' ;
	echo '<TD>' . $alink . '</TD>' ;
	echo '<TD>' . $row['status'] . '</TD>' ;
    echo '</TR>' ;
  }
  
  
  
  # End the table
  echo '</TABLE>';

  # Free up the results in memory
  mysqli_free_result( $results ) ;
}
else
{
  # If we get here, something has gone wrong
  echo '<p>' . mysqli_error( $dbc ) . '</p>'  ;
}

# Close the connection
mysqli_close( $dbc ) ;
}
##########################################################################################################################################
#Shows a single item entry from the database on the item.php page
function show_item($dbc){
# Connect to MySQL server and the database
require( '../limboincludes/connect_limbo_db.php' ) ;
$item_id = $_GET["id"];
# Create a query to get the item info
$query = 'SELECT DISTINCT locations.id, stuff_id, name, description, stuff.create_date, stuff.update_date, room, owner, finder, status
		  FROM locations, stuff
		  WHERE locations.id = stuff.location_id AND stuff_id = ' . $item_id . '';

		  
# Execute the query
$results = mysqli_query( $dbc , $query ) ;	
  # But...wait until we know the query succeeded before
  # starting the table.
  echo '<TABLE border="1">';
  echo '<TR>';
  echo '<TH>Location</TH>';
  echo '<TH>Item Description</TH>';
  echo '<TH>Create Date</TH>';
  echo '<TH>Update Date</TH>';
  echo '<TH>Room</TH>';
  echo '<TH>Owner</TH>';
  echo '<TH>Finder</TH>';
  echo '<TH>Status</TH>';  
  echo '</TR>';

 if( $results )
{
  # For each row result, generate a table row
  while ( $row = mysqli_fetch_array( $results , MYSQLI_ASSOC ) )
  {
  
  # Show results
  
  #This block of if/else statements determines the owner and/or finder
  #of the item to help prepare a link to that person's info
	if($row['owner'] != ''){
		$owner = getUser($dbc, $row['owner'] );
	} else {
	$owner = '';
	}
	if($row['finder'] != ''){
		$finder = getUser($dbc, $row['finder'] );
	} else {
	$finder = '';
	}

	#These variables create links to the person's contact information page
	$alink = '<A HREF=/limbo/user.php?id=' . $row['owner'] . '>' . $owner . '</A>' ;
	$blink = '<A HREF=/limbo/user.php?id=' . $row['finder'] . '>' . $finder . '</A>' ;
    echo '<TR>' ;
	echo '<TD>' . $row['name'] . '</TD>' ;
	echo '<TD>' . $row['description'] . '</TD>' ;
    echo '<TD>' . $row['create_date'] . '</TD>' ;
	echo '<TD>' . $row['update_date'] . '</TD>' ;
	echo '<TD>' . $row['room'] . '</TD>' ;
	echo '<TD>' . $alink . '</TD>' ;
	echo '<TD>' . $blink. '</TD>' ;
	echo '<TD>' . $row['status'] . '</TD>' ;
    echo '</TR>' ;
  
  }
  # End the table
  echo '</TABLE>';

  # Free up the results in memory
  mysqli_free_result( $results ) ;
}
else
{
  # If we get here, something has gone wrong
  echo '<p>' . mysqli_error( $dbc ) . '</p>'  ;
}

# Close the connection
mysqli_close( $dbc ) ;
}

##################################################################################################################################
# Searches for items in database
function search($dbc, $status, $item) {
# Connect to MySQL server and the database
require( '../limboincludes/connect_limbo_db.php' ) ;

# Create a query to get any item similar to what the user typed in
$query = 'SELECT DISTINCT locations.id, stuff_id, name, description, stuff.create_date, stuff.update_date, room, owner, finder, status
		  FROM locations, stuff
		  WHERE locations.id = stuff.location_id AND status = "' . $status .'" AND description LIKE "%' . $item .'%"' ;

# Execute the query
$results = mysqli_query( $dbc , $query ) ;

# Show results
if( $results )
{
 if (mysqli_num_rows($results) < 1){
  echo '<p>Sorry, we could not find the item in the database.</p>';
  
 } else{
	# But...wait until we know the query succeeded before
	# starting the table.
	echo '<TABLE border="1">';
	echo '<TR>';
	echo '<TH>Location</TH>';
	echo '<TH>Item Description</TH>';
	echo '</TR>';
	
	# For each row result, generate a table row
	while ( $row = mysqli_fetch_array( $results , MYSQLI_ASSOC ) ){
		#Creates a link to the item's information page
		$alink = '<A HREF=/limbo/item.php?id=' . $row['stuff_id'] . '>' . $row['description'] . '</A>' ;
		echo '<TR>' ;
		echo '<TD>' . $row['name'] . '</TD>' ;
		echo '<TD>' . $alink . '</TD>' ;
		echo '</TR>' ;
	}
  
  
	# End the table
	echo '</TABLE>';
   }
  # Free up the results in memory
  mysqli_free_result( $results ) ;
}
else
{
  # If we get here, something has gone wrong
  echo '<p>' . mysqli_error( $dbc ) . '</p>'  ;
}

# Close the connection
mysqli_close( $dbc ) ;
}
##################################################################################################################################
#Creates the table that has the ability for admins to change the status of an item
function admin_change_item_table($dbc){
# Connect to MySQL server and the database
require( '../limboincludes/connect_limbo_db.php' ) ;

# Create a query to get the items in the database
$query = 'SELECT DISTINCT locations.id, stuff_id, name, description, stuff.create_date, stuff.update_date, room, owner, finder, status
		  FROM locations, stuff
		  WHERE locations.id = stuff.location_id
		  ORDER BY stuff_id ASC';
$queryStatus = 'SELECT status FROM stuff ';
# Execute the query
$results = mysqli_query( $dbc , $query ) ;
$resultsStatus = mysqli_query( $dbc , $query ) ;


# Show results
if( $results) 
{
  # But...wait until we know the query succeeded before
  # starting the table.
  echo '<TABLE border="1">';
  echo '<TR>';
  echo '<TH>Item ID</TH>';
  echo '<TH>Item Description</TH>';
  echo '<TH>Location ID</TH>';
  echo '<TH>Location</TH>';
  echo '<TH>Create Date</TH>';
  echo '<TH>Update Date</TH>';
  echo '<TH>Room</TH>';
  echo '<TH>Owner ID</TH>';
  echo '<TH>Finder ID</TH>';
  echo '<TH>Status</TH>'; 
  echo '<TH>Change Status</TH>';
  echo '</TR>' ;
  
  # For each row result, generate a table row
  while ( $row = mysqli_fetch_array( $results , MYSQLI_ASSOC ) )
  {
	#Create links to the owner/finder's contact info page
	$alink = '<A HREF=/limbo/user.php?id=' . $row['owner'] . '>' . $row['owner']. '</A>' ;
	$blink = '<A HREF=/limbo/user.php?id=' . $row['finder'] . '>' . $row['finder'] . '</A>' ;
	echo '<TR>' ;
	echo '<TD>' . $row['stuff_id'] . '</TD>' ;
	echo '<TD>' . $row['description'] . '</TD>' ;
	echo '<TD>' . $row['id'] . '</TD>' ;
	echo '<TD>' . $row['name'] . '</TD>' ;
    echo '<TD>' . $row['create_date'] . '</TD>' ;
	echo '<TD>' . $row['update_date'] . '</TD>' ;
	echo '<TD>' . $row['room'] . '</TD>' ;
	echo '<TD>' . $alink . '</TD>' ;
	echo '<TD>' . $blink . '</TD>' ;
	echo '<TD>' . $row['status'] . '</TD>' ;
	echo '<TD> 
								<form action="" method="post">
								<select id="cmbChangeStatus" name="change_status" >
								<option value="lost" id="lost" '.check_current_status('lost', $row['status']). ' >Lost</option>
								<option value="found" id="found" '.check_current_status('found', $row['status']). ' >Found</option>
								<option value="claimed" id="claimed" '.check_current_status('claimed', $row['status']). ' >Claimed</option>
								<input type="hidden" name="id" value=' . $row['stuff_id'] .' />
								 <input type="submit" value="Submit">
							</select>
							</form>
	</TD>';
    echo '</TR>' ;
  }
  
  
  
  # End the table
  echo '</TABLE>';

  # Free up the results in memory
  mysqli_free_result( $results ) ;
}
else
{
  # If we get here, something has gone wrong
  echo '<p>' . mysqli_error( $dbc ) . '</p>'  ;
}

# Close the connection
mysqli_close( $dbc ) ;
}
############################################################################################################################################
#This function is used to check to see if the user selected a status in quick links, and keep that status selected after hitting submit
#Returns the string 'selected' if the user did select it, which will keep the option in the drop-down menu selected
function check_current_status($option, $status){
 if($option == $status)
	return 'selected';
 return '';
}
############################################################################################################################################
function show_query($query) {
  global $debug;

  if($debug)
    echo "<p>Query = $query</p>" ;
}
############################################################################################################################################
#Shows items reported in the specified date range on the landing page
function show_item_by_date_range($dbc, $days){
# Connect to MySQL server and the database
require( '/limboincludes/connect_limbo_db.php' ) ;


# Create a query to get items reported in the last X days
 $query = 'SELECT DISTINCT locations.id, stuff_id, name, description, stuff.create_date, stuff.update_date, room, owner, finder, status
		  FROM locations, stuff
		  WHERE locations.id = stuff.location_id and (stuff.create_date > DATE_SUB(NOW(), INTERVAL ' . $days . ' DAY)) 
		  ORDER BY locations.id ASC' ;
# Execute the query
$results = mysqli_query( $dbc , $query ) ;

# Show results
if( $results )
{
  # But...wait until we know the query succeeded before
  # starting the table.
  echo '<TABLE border="1">';
  echo '<TR>';
  echo '<TH>Location</TH>';
  echo '<TH>Item Description</TH>';
  echo '<TH>Status</TH>';
  echo '</TR>';

  # For each row result, generate a table row
  while ( $row = mysqli_fetch_array( $results , MYSQLI_ASSOC ) )
  {
	#Create the link to the item's information page
	$alink = '<A HREF=/limbo/item.php?id=' . $row['stuff_id'] . '>' . $row['description'] . '</A>' ;
    echo '<TR>' ;
	echo '<TD>' . $row['name'] . '</TD>' ;
	echo '<TD>' . $alink . '</TD>' ;
	echo '<TD>' . $row['status'] . '</TD>' ;
    echo '</TR>' ;
  }
  
  
  
  # End the table
  echo '</TABLE>';

  # Free up the results in memory
  mysqli_free_result( $results ) ;
}
else
{
  # If we get here, something has gone wrong
  echo '<p>' . mysqli_error( $dbc ) . '</p>'  ;
}

# Close the connection
mysqli_close( $dbc ) ;
}
############################################################################################################################################
#Displays items only of the selected status on the quick links page
function show_item_by_status($dbc, $status_id){
# Connect to MySQL server and the database
require( '../limboincludes/connect_limbo_db.php' ) ;

# Create a query to get the items of the selected status
 $query = 'SELECT DISTINCT locations.id, stuff_id, name, description, stuff.create_date, stuff.update_date, room, owner, finder, status
		  FROM locations, stuff
		  WHERE locations.id = stuff.location_id and status = "' . $status_id . '"
		  ORDER BY locations.id ASC' ;
# Execute the query
$results = mysqli_query( $dbc , $query ) ;

# Show results
if( $results )
{
  # But...wait until we know the query succeeded before
  # starting the table.
  echo '<TABLE border="1">';
  echo '<TR>';
  echo '<TH>Location</TH>';
  echo '<TH>Item Description</TH>';
  echo '<TH>Status</TH>';
  echo '</TR>';

  # For each row result, generate a table row
  while ( $row = mysqli_fetch_array( $results , MYSQLI_ASSOC ) )
  {
	$alink = '<A HREF=/limbo/item.php?id=' . $row['stuff_id'] . '>' . $row['description'] . '</A>' ;
    echo '<TR>' ;;
	echo '<TD>' . $row['name'] . '</TD>' ;
	echo '<TD>' . $alink . '</TD>' ;
	echo '<TD>' . $row['status'] . '</TD>' ;
    echo '</TR>' ;
  }
  
  
  
  # End the table
  echo '</TABLE>';

  # Free up the results in memory
  mysqli_free_result( $results ) ;
}
else
{
  # If we get here, something has gone wrong
  echo '<p>' . mysqli_error( $dbc ) . '</p>'  ;
}

# Close the connection
mysqli_close( $dbc ) ;
}
############################################################################################################################################
#Creates the table of items with the option for admins to delete an item from the database
function admin_delete_item($dbc){
# Connect to MySQL server and the database
require( '../limboincludes/connect_limbo_db.php' ) ;

# Create a query to get the items in the database
$query = 'SELECT DISTINCT locations.id, stuff_id, name, description, stuff.create_date, stuff.update_date, room, owner, finder, status
		  FROM locations, stuff
		  WHERE locations.id = stuff.location_id
		  ORDER BY stuff_id ASC';
$queryStatus = 'SELECT status FROM stuff ';
# Execute the query
$results = mysqli_query( $dbc , $query ) ;
$resultsStatus = mysqli_query( $dbc , $query ) ;


# Show results
if( $results) 
{
  # But...wait until we know the query succeeded before
  # starting the table.
  echo '<TABLE border="1">';
  echo '<TR>';
  echo '<TH>Item ID</TH>';
  echo '<TH>Item Description</TH>';
  echo '<TH>Location ID</TH>';
  echo '<TH>Location</TH>';
  echo '<TH>Create Date</TH>';
  echo '<TH>Update Date</TH>';
  echo '<TH>Room</TH>';
  echo '<TH>Owner</TH>';
  echo '<TH>Finder</TH>';
  echo '<TH>Status</TH>'; 
  echo '<TH>Delete Item</TH>';
  echo '</TR>' ;
  
  # For each row result, generate a table row
  while ( $row = mysqli_fetch_array( $results , MYSQLI_ASSOC ) )
  {
	#Creates the links to the owner/finders contact information page
  	$alink = '<A HREF=/limbo/user.php?id=' . $row['owner'] . '>' . $row['owner']. '</A>' ;
	$blink = '<A HREF=/limbo/user.php?id=' . $row['finder'] . '>' . $row['finder'] . '</A>' ;
	echo '<TR>' ;
	echo '<TD>' . $row['stuff_id'] . '</TD>' ;
	echo '<TD>' . $row['description'] . '</TD>' ;
	echo '<TD>' . $row['id'] . '</TD>' ;
	echo '<TD>' . $row['name'] . '</TD>' ;
    echo '<TD>' . $row['create_date'] . '</TD>' ;
	echo '<TD>' . $row['update_date'] . '</TD>' ;
	echo '<TD>' . $row['room'] . '</TD>' ;
	echo '<TD>' . $alink . '</TD>' ;
	echo '<TD>' . $blink . '</TD>' ;
	echo '<TD>' . $row['status'] . '</TD>' ;
	echo '<TD> 	<form action="" method="post"> 
					<input type="hidden" name="id" value=' . $row['stuff_id'] .' />
					<input type="submit" value="Delete">	
				</form>
		</TD>';
    echo '</TR>' ;
  }
  
  
  
  # End the table
  echo '</TABLE>';

  # Free up the results in memory
  mysqli_free_result( $results ) ;
}
else
{
  # If we get here, something has gone wrong
  echo '<p>' . mysqli_error( $dbc ) . '</p>'  ;
}

# Close the connection
mysqli_close( $dbc ) ;
}
############################################################################################################################################
#Checks the status selected by the used to ensure it stays selected after submitting the form
function check_status($status){
	if(isset($_POST['status_id'])){ 
		if($status == $_POST['status_id']){
		return 'selected';
		}
	}
	return '';
}
##########################################################################################################################################
#Checks the type selected by the used to ensure it stays selected after submitting the form
function check_type($type){
	if(isset($_POST['type'])){ 
		if($type == $_POST['type']){
		return 'selected';
		}
	}
	return '';
}
##########################################################################################################################################
#This updates the record in the database to whatever the admin selected on the change status page
function update_status($dbc, $id, $status){
$update_query = 'UPDATE stuff SET status="'. $status .'", update_date=now() WHERE stuff_id = '. $id .'';

  $results = mysqli_query($dbc, $update_query) ;
  check_results($results) ;

  return $results ;
}
###########################################################################################################################################
#This deletes the record that the admin selected from the stuff table
function delete_item($dbc, $id){
$delete_query = 'DELETE FROM stuff WHERE stuff_id = '. $id .'';

  $results = mysqli_query($dbc, $delete_query) ;
  check_results($results) ;

  return $results ;
}
###########################################################################################################################################
#This displays the contact information of the selected user
function show_user($dbc){
# Connect to MySQL server and the database
require( '../limboincludes/connect_limbo_db.php' ) ;
$user_id = $_GET["id"];
# Create a query to get the contact information of the user
$query = 'SELECT DISTINCT user_id, first_name, last_name, email, phone
		  FROM locations, users
		  WHERE user_id = ' . $user_id . '';

# Execute the query
$results = mysqli_query( $dbc , $query ) ;

# Show results
if( $results )
{
  # But...wait until we know the query succeeded before
  # starting the table.
  echo '<TABLE border="1">';
  echo '<TR>';
  echo '<TH>Name</TH>';
  echo '<TH>Email</TH>';
  echo '<TH>Phone Number</TH>';
  echo '</TR>';

  # For each row result, generate a table row
  while ( $row = mysqli_fetch_array( $results , MYSQLI_ASSOC ) )
  {
    echo '<TR>' ;
	echo '<TD>' . $row['first_name'] . ' ' . $row['last_name'] . '</TD>' ;
	echo '<TD>' . $row['email'] . '</TD>' ;
    echo '<TD>' . $row['phone'] . '</TD>' ;
    echo '</TR>' ;
  }
  
  
  
  # End the table
  echo '</TABLE>';

  # Free up the results in memory
  mysqli_free_result( $results ) ;
}
else
{
  # If we get here, something has gone wrong
  echo '<p>' . mysqli_error( $dbc ) . '</p>'  ;
}

# Close the connection
mysqli_close( $dbc ) ;
}

##################################################################################################################################
#This function takes in a user_id and returns the corresponding first name and last name for display in tables
#This is mainly used to cross-reference user ids in the stuff table with the user ids in the names table
function getUser($dbc, $user_id){
 # Connect to MySQL server and the database
require( '../limboincludes/connect_limbo_db.php' ) ;

# Create a query to get the name and price sorted by price
$query = 'SELECT DISTINCT user_id, first_name, last_name
		  FROM locations, users
		  WHERE user_id = ' . $user_id . '';

# Execute the query
$results = mysqli_query( $dbc , $query ) ;

# Show results
if( $results )
{
$row = mysqli_fetch_array( $results , MYSQLI_ASSOC);
$name = $row['first_name'] . ' ' . $row['last_name'];
}
else
{
  # If we get here, something has gone wrong
  echo '<p>' . mysqli_error( $dbc ) . '</p>'  ;
}

# Close the connection
mysqli_close( $dbc ) ;

return $name;
}
##################################################################################################################################
#This function adds administrator accounts
function add_admin($dbc, $first, $last, $email, $password){
	$query = 'INSERT INTO users(first_name, last_name, email, pass, reg_date, phone) 
		VALUES ("' . $first . '" , "' . $last . '" , "'. $email .'", "'. $password .'", now(), "")' ;
	$results = mysqli_query( $dbc , $query ) ;
	return $results;
}
?>