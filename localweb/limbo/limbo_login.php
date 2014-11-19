<!--
This PHP script front-ends linkyprints.php with a login page.
Originally created By Ron Coleman.
Revision history:
Who	Date		Comment
RC  07-Nov-13   Created.
-->
<!DOCTYPE html>
<html>
<?php
# Connect to MySQL server and the database
require( 'limboincludes/connect_limbo_db.php' ) ;

# Connect to MySQL server and the database
require( 'limboincludes/limbo_login_tools.php' ) ;

if ($_SERVER[ 'REQUEST_METHOD' ] == 'POST') {

	$name = $_POST['name'] ;
	$password = $_POST['password'] ;

    $pid = validate($name) ;
	$pid = validate($password) ;

    if($pid == -1)
      echo '<P style=color:red>Login failed please try again.</P>' ;

    else
      load('linkypresidents.php', $pid);
}
?>
<!-- Get inputs from the user. -->
<h1>Administrator Login</h1>
<form action="limbo_login.php" method="POST">
<table>
<tr>
<td>Name:</td><td><input type="text" name="name"></td>
</tr>
<tr>
<td>Password:</td><td><input type="text" name="password"></td>
</tr>
</table>
<p><input type="submit" ></p>
</form>
</html>