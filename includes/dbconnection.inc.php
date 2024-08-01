<?php

$servername="localhost";
$username="root";
$password="";
$database="lowastatelibrary";

//Create Connection
$conn = new mysqli($servername, $username, $password, $database);









//Check Connection
if ($conn->connect_error) {
	$error = "Connection failed: ".$conn->connect_error;
	echo '<script>alert("'.$error.'");</script>';
	print("Error Connecting to the Database.");
	
}

echo '<script>console.log("Database Connected Successfully");</script>';

?>