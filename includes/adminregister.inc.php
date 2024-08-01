<?php

if (isset($_POST['submit'])) { //Checks if the Submit button was clicked
	
	include("dbconnection.inc.php");
	
	
	$memid = mysqli_real_escape_string($conn, $_POST["memid"]);
	$memid = strtoupper($memid);
	$fname = mysqli_real_escape_string($conn, $_POST["fname"]);
	$lname = mysqli_real_escape_string($conn, $_POST["lname"]);
	$gender = mysqli_real_escape_string($conn, $_POST["gender"]);
	$contactno = mysqli_real_escape_string($conn, $_POST["contactno"]);
	$address = mysqli_real_escape_string($conn, $_POST["address"]);
	$email = mysqli_real_escape_string($conn, $_POST["email"]);
	$password = mysqli_real_escape_string($conn, $_POST["password"]);
	$hashedpassword = password_hash($password, PASSWORD_DEFAULT);
	
	
	//Check if the Librarian ID Already Exist
	$sql_memid="SELECT * FROM librarian WHERE libId='".$memid."'";
	$result_memid = $conn->query($sql_memid);
	
	if ($result_memid->num_rows>0){ 		
		header("Location: ../adminregistration26398443.php?error=This+Librarian+ID+is+already+registered");
		exit();		
	}
	
	//Check if Email already associated to another account
	$sql_email="SELECT * FROM logindetails WHERE email='".$email."'";
	$result_email = $conn->query($sql_email);
	
	if ($result_email->num_rows>0){ 		
		header("Location: ../adminregistration26398443.php?error=This+Email+ID+is+already+associated+to+another+account.");
		exit();		
	}
	
	//Detect User Authentication Level Using Users Student ID/Professor ID
	if ($memid[0] == 'l' || $memid[0] == 'L') {
		$authlevel = 'librarian';
	} else {
		header("Location: ../adminregistration26398443.php?registration=failed&error=Invalid+librarian+id");
	}
	
	
	// Insert the data collected from the form to the librarian table and logindetails table
	$sql = "INSERT INTO librarian VALUES('$memid', '$fname', '$lname', '$gender', '$contactno', '$address')";
	$sql2 = "INSERT INTO logindetails(email, password, authLevel, status, libId) VALUES('$email', '$hashedpassword', '$authlevel', 'active', '$memid' )";
	
	if ($conn->query($sql)===TRUE && $conn->query($sql2)===TRUE){
		header("Location: ../adminregistration26398443.php?registration=success");
		exit();
	}
	else {
		print("Error: ".$sql."<br>".$conn->error);
	}
	
	$conn->close();
}

else {
	header("Location: ../index.php"); //Returns to homepage if this page opens without clicking submit button
}
?>