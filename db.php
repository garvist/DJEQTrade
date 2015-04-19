<?php
$DB_HOST = "localhost";
$DB_USER = "djex_test";
$DB_PASS = "123456";
$DB_NAME = "djex";

function connect_to_db()
{
	$con = mysqli_connect( $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME ); //create a connection to the database
	if( $mysqli->connect_errno )
		die("Failed to connect to server"); //stop the script with this error message
	
	return $con; //return the database connection
}
?>