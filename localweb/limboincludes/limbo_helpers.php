<?php
$debug = true;
# Inserts a record into the stuff table
function insert_record($dbc, $location_id, $description, $room, $first, $last, $email, $phone, $status) {
  $existing_user_id = getUserId($dbc, $first, $last, $email);

 if ($existing_user_id == -1){
 $insert_query = 'INSERT INTO users(first_name, last_name, email, pass, reg_date, phone) 
		VALUES ("' . $first . '" , "' . $last . '" , "'. $email .'", "", now(), "' . $phone . '")' ;
		
  $results = mysqli_query($dbc, $insert_query) ;
  check_results($results) ;
  
   $existing_user_id = getUserId($dbc, $first, $last, $email);
 }
  
  if($status == 'lost'){
	$owner_id = $existing_user_id;
  } else {
    $owner_id = '';
  }
  if($status == 'found'){
	$finder_id = $existing_user_id;
  } else {
    $finder_id = '';
  }
	
  $insert_query = 'INSERT INTO stuff(location_id, description, create_date, update_date, room, owner, finder, status) 
		VALUES (' . $location_id . ' , "' . $description . '" , now(), now(), "' . $room . ' ", "' . $owner_id . '" , "' . $finder_id . '" ,"' . $status . '")' ;

  $results = mysqli_query($dbc, $insert_query) ;
  check_results($results) ;

  return $results ;
}
########################################################################################################################
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
function show_item_by_location($dbc, $loc_id){
# Connect to MySQL server and the database
require( '../limboincludes/connect_limbo_db.php' ) ;

# Create a query to get the name and price sorted by price
 if($loc_id == 0){
 $query = 'SELECT DISTINCT locations.id, stuff_id, name, description, stuff.create_date, stuff.update_date, room, owner, finder, status
		  FROM locations, stuff
		  WHERE locations.id = stuff.location_id
		  ORDER BY locations.id ASC' ;
 }
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
 # echo '<TH>Location ID</TH>';
  echo '<TH>Location</TH>';
  echo '<TH>Item Description</TH>';
  echo '<TH>Status</TH>';
  echo '</TR>';

  # For each row result, generate a table row
  while ( $row = mysqli_fetch_array( $results , MYSQLI_ASSOC ) )
  {
	$alink = '<A HREF=/limbo/item.php?id=' . $row['stuff_id'] . '>' . $row['description'] . '</A>' ;
    echo '<TR>' ;
 #   echo '<TD>' . $row['id'] . '</TD>' ;
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

function show_item($dbc){
# Connect to MySQL server and the database
require( '../limboincludes/connect_limbo_db.php' ) ;
$item_id = $_GET["id"];
# Create a query to get the name and price sorted by price
$query = 'SELECT DISTINCT locations.id, stuff_id, name, description, stuff.create_date, stuff.update_date, room, owner, finder, status
		  FROM locations, stuff
		  WHERE locations.id = stuff.location_id AND stuff_id = ' . $item_id . '';

		  
# Execute the query
$results = mysqli_query( $dbc , $query ) ;	
  # But...wait until we know the query succeeded before
  # starting the table.
  echo '<TABLE border="1">';
  echo '<TR>';
 # echo '<TH>Location ID</TH>';
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

	
	$alink = '<A HREF=/limbo/user.php?id=' . $row['owner'] . '>' . $owner . '</A>' ;
	$blink = '<A HREF=/limbo/user.php?id=' . $row['finder'] . '>' . $finder . '</A>' ;
    echo '<TR>' ;
 #   echo '<TD>' . $row['id'] . '</TD>' ;
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

# Create a query to get the name and price sorted by price
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
	# echo '<TH>Location ID</TH>';
	echo '<TH>Location</TH>';
	echo '<TH>Item Description</TH>';
	echo '</TR>';
	# For each row result, generate a table row
	while ( $row = mysqli_fetch_array( $results , MYSQLI_ASSOC ) ){
		$alink = '<A HREF=/limbo/item.php?id=' . $row['stuff_id'] . '>' . $row['description'] . '</A>' ;
		echo '<TR>' ;
	# echo '<TD>' . $row['id'] . '</TD>' ;
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

function admin_change_item_table($dbc){
# Connect to MySQL server and the database
require( '../limboincludes/connect_limbo_db.php' ) ;

# Create a query to get the name and price sorted by price
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
function show_item_by_date_range($dbc, $days){
# Connect to MySQL server and the database
require( '/limboincludes/connect_limbo_db.php' ) ;


# Create a query to get the name and price sorted by price
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
 # echo '<TH>Location ID</TH>';
  echo '<TH>Location</TH>';
  echo '<TH>Item Description</TH>';
  echo '<TH>Status</TH>';
  echo '</TR>';

  # For each row result, generate a table row
  while ( $row = mysqli_fetch_array( $results , MYSQLI_ASSOC ) )
  {
	$alink = '<A HREF=/limbo/item.php?id=' . $row['stuff_id'] . '>' . $row['description'] . '</A>' ;
    echo '<TR>' ;
 #   echo '<TD>' . $row['id'] . '</TD>' ;
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
function show_item_by_status($dbc, $status_id){
# Connect to MySQL server and the database
require( '../limboincludes/connect_limbo_db.php' ) ;

# Create a query to get the name and price sorted by price
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
 # echo '<TH>Location ID</TH>';
  echo '<TH>Location</TH>';
  echo '<TH>Item Description</TH>';
  echo '<TH>Status</TH>';
  echo '</TR>';

  # For each row result, generate a table row
  while ( $row = mysqli_fetch_array( $results , MYSQLI_ASSOC ) )
  {
	$alink = '<A HREF=/limbo/item.php?id=' . $row['stuff_id'] . '>' . $row['description'] . '</A>' ;
    echo '<TR>' ;
 #   echo '<TD>' . $row['id'] . '</TD>' ;
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
function admin_delete_item($dbc){
# Connect to MySQL server and the database
require( '../limboincludes/connect_limbo_db.php' ) ;

# Create a query to get the name and price sorted by price
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
function check_status($status){
	if(isset($_POST['status_id'])){ 
		if($status == $_POST['status_id']){
		return 'selected';
		}
	}
	return '';
}
##########################################################################################################################################
function check_type($type){
	if(isset($_POST['type'])){ 
		if($type == $_POST['type']){
		return 'selected';
		}
	}
	return '';
}
##########################################################################################################################################
function update_status($dbc, $id, $status){
$update_query = 'UPDATE stuff SET status="'. $status .'", update_date=now() WHERE stuff_id = '. $id .'';

  $results = mysqli_query($dbc, $update_query) ;
  check_results($results) ;

  return $results ;
}
###########################################################################################################################################
function delete_item($dbc, $id){
$delete_query = 'DELETE FROM stuff WHERE stuff_id = '. $id .'';

  $results = mysqli_query($dbc, $delete_query) ;
  check_results($results) ;

  return $results ;
}
###########################################################################################################################################
function show_user($dbc){
# Connect to MySQL server and the database
require( '../limboincludes/connect_limbo_db.php' ) ;
$user_id = $_GET["id"];
# Create a query to get the name and price sorted by price
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
 # echo '<TH>Location ID</TH>';
  echo '<TH>Name</TH>';
  echo '<TH>Email</TH>';
  echo '<TH>Phone Number</TH>';
  echo '</TR>';

  # For each row result, generate a table row
  while ( $row = mysqli_fetch_array( $results , MYSQLI_ASSOC ) )
  {
    echo '<TR>' ;
 #   echo '<TD>' . $row['id'] . '</TD>' ;
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
function add_admin($dbc, $first, $last, $email, $password){
	$query = 'INSERT INTO users(first_name, last_name, email, pass, reg_date, phone) 
		VALUES ("' . $first . '" , "' . $last . '" , "'. $email .'", "'. $password .'", now(), "")' ;
	$results = mysqli_query( $dbc , $query ) ;
	return $results;
}
?>