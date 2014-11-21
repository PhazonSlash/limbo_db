<!DOCTYPE html>
<html>
<body>

<?php
$debug = true;

function show_item_by_location($dbc){
# Connect to MySQL server and the database
require( 'connect_limbo_db.php' ) ;

# Create a query to get the name and price sorted by price
$query = 'SELECT DISTINCT locations.id, stuff_id, name, description, stuff.create_date, stuff.update_date, room, owner, finder, status
		  FROM locations, stuff
		  WHERE locations.id = stuff.location_id
		  ORDER BY locations.id ASC' ;

# Execute the query
$results = mysqli_query( $dbc , $query ) ;

# Show results
if( $results )
{
  # But...wait until we know the query succeeded before
  # starting the table.
  echo '<H1>Limbo</H1>' ;
  echo '<TABLE border="1">';
  echo '<TR>';
  echo '<TH>Location ID</TH>';
  echo '<TH>Location</TH>';
  echo '<TH>Item Description</TH>';
  echo '</TR>';

  # For each row result, generate a table row
  while ( $row = mysqli_fetch_array( $results , MYSQLI_ASSOC ) )
  {
	$alink = '<A HREF=/limbo/item.php?id=' . $row['stuff_id'] . '>' . $row['description'] . '</A>' ;
    echo '<TR>' ;
    echo '<TD>' . $row['id'] . '</TD>' ;
	echo '<TD>' . $row['name'] . '</TD>' ;
	echo '<TD>' . $alink . '</TD>' ;
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

function show_item($dbc){
# Connect to MySQL server and the database
require( 'connect_limbo_db.php' ) ;
$item_id = $_GET["id"];
# Create a query to get the name and price sorted by price
$query = 'SELECT DISTINCT locations.id, stuff_id, name, description, stuff.create_date, stuff.update_date, room, owner, finder, status
		  FROM locations, stuff
		  WHERE locations.id = stuff.location_id AND stuff_id = ' . $item_id . '';

# Execute the query
$results = mysqli_query( $dbc , $query ) ;

# Show results
if( $results )
{
  # But...wait until we know the query succeeded before
  # starting the table.
echo '<H1>Limbo</H1>' ;
  echo '<TABLE border="1">';
  echo '<TR>';
  echo '<TH>Location ID</TH>';
  echo '<TH>Location</TH>';
  echo '<TH>Item Description</TH>';
  echo '<TH>Create Date</TH>';
  echo '<TH>Update Date</TH>';
  echo '<TH>Room</TH>';
  echo '<TH>Owner</TH>';
  echo '<TH>Finder</TH>';
  echo '<TH>Status</TH>';  
  echo '</TR>';

  # For each row result, generate a table row
  while ( $row = mysqli_fetch_array( $results , MYSQLI_ASSOC ) )
  {
    echo '<TR>' ;
    echo '<TD>' . $row['id'] . '</TD>' ;
	echo '<TD>' . $row['name'] . '</TD>' ;
	echo '<TD>' . $row['description'] . '</TD>' ;
    echo '<TD>' . $row['create_date'] . '</TD>' ;
	echo '<TD>' . $row['update_date'] . '</TD>' ;
	echo '<TD>' . $row['room'] . '</TD>' ;
	echo '<TD>' . $row['owner'] . '</TD>' ;
	echo '<TD>' . $row['finder'] . '</TD>' ;
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

# Shows the records in limbo
function show_limbo_records($dbc) {

# Connect to MySQL server and the database
require( 'limbo/limboincludes/connect_limbo_db.php' ) ;

# Create a query to get the name and price sorted by price
$query = 'SELECT DISTINCT id, create_date, name FROM locations ORDER BY id ASC' ;

# Execute the query
$results = mysqli_query( $dbc , $query ) ;

# Show results
if( $results )
{
  # But...wait until we know the query succeeded before
  # starting the table.
  echo '<H1>Limbo</H1>' ;
  echo '<TABLE border="1">';
  echo '<TR>';
  echo '<TH>Number</TH>';
  echo '<TH>Create Date</TH>';
  echo '<TH>Location</TH>';
  echo '</TR>';

  # For each row result, generate a table row
  while ( $row = mysqli_fetch_array( $results , MYSQLI_ASSOC ) )
  {
	# $alink = '<A HREF=linkypresidents.php?id=' . $row['id'] . '>' . $row['id'] . '</A>' ;
    echo '<TR>' ;
	#echo '<TD ALIGN=right>' . $alink . '</TD>' ;
    echo '<TD>' . $row['id'] . '</TD>' ;
	echo '<TD>' . $row['create_date'] . '</TD>' ;
	echo '<TD>' . $row['name'] . '</TD>' ;
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

function admin_change_item($dbc){
# Connect to MySQL server and the database
require( 'connect_limbo_db.php' ) ;

# Create a query to get the name and price sorted by price
$query = 'SELECT DISTINCT locations.id, stuff_id, name, description, stuff.create_date, stuff.update_date, room, owner, finder, status
		  FROM locations, stuff
		  WHERE locations.id = stuff.location_id
		  ORDER BY locations.id ASC';
$queryStatus = 'SELECT status FROM stuff ';
# Execute the query
$results = mysqli_query( $dbc , $query ) ;
$resultsStatus = mysqli_query( $dbc , $queryStatus ) ;


# Show results
if( $results AND $resultsStatus ) 
{
  # But...wait until we know the query succeeded before
  # starting the table.
echo '<H1>Limbo</H1>' ;
  echo '<TABLE border="1">';
  echo '<TR>';
  echo '<TH>Location ID</TH>';
  echo '<TH>Location</TH>';
  echo '<TH>Item Description</TH>';
  echo '<TH>Create Date</TH>';
  echo '<TH>Update Date</TH>';
  echo '<TH>Room</TH>';
  echo '<TH>Owner</TH>';
  echo '<TH>Finder</TH>';
  echo '<TH>Status</TH>'; 
  echo '<TH>Change Status</TH>';
  echo '</TR>' ;
  
while ( $row = mysqli_fetch_array( $resultsStatus , MYSQLI_ASSOC ) )
  {
  $changeStatus = 	$row= 	'<select id="cmbChangeStatus" name="ChangeStatus" >
								<option value="status" >' . $row['status'] . '</option>
								<option value="Lost" id="lost" >Lost</option>
								<option value="found" id="found" >Found</option>
								<option value="status" id="claimed" >Claimed</option>
							</select>' ;
	}

  # For each row result, generate a table row
  while ( $row = mysqli_fetch_array( $results , MYSQLI_ASSOC ) )
  {

	echo '<TR>' ;
    echo '<TD>' . $row['id'] . '</TD>' ;
	echo '<TD>' . $row['name'] . '</TD>' ;
	echo '<TD>' . $row['description'] . '</TD>' ;
    echo '<TD>' . $row['create_date'] . '</TD>' ;
	echo '<TD>' . $row['update_date'] . '</TD>' ;
	echo '<TD>' . $row['room'] . '</TD>' ;
	echo '<TD>' . $row['owner'] . '</TD>' ;
	echo '<TD>' . $row['finder'] . '</TD>' ;
	echo '<TD>' . $row['status'] . '</TD>' ;
	echo '<TD>' . $changeStatus . '</TD>';
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

?>

</body>
</html>