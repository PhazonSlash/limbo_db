<?php
$debug = true;

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
?>