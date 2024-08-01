<?php

if (isset($_POST['submit'])) { //Checks if the Submit button was clicked
	
	include("dbconnection.inc.php");

	//Collects the Form Data in to variables.
	$memid = mysqli_real_escape_string($conn, $_POST["memid"]) ;
	$memid = strtoupper($memid);
	$fname = mysqli_real_escape_string($conn, $_POST["fname"]);
	$lname = mysqli_real_escape_string($conn, $_POST["lname"]);
	$gender = mysqli_real_escape_string($conn, $_POST["gender"]);
	$contactno = mysqli_real_escape_string($conn, $_POST["contactno"]);
	$address = mysqli_real_escape_string($conn, $_POST["address"]);
	$profileimage = "notassigned";
	$email = mysqli_real_escape_string($conn, $_POST["email"]);
	$password = mysqli_real_escape_string($conn, $_POST["password"]);
	$hashedpassword = password_hash($password, PASSWORD_DEFAULT);
	
	
	//Check if the Member ID Already Exist
	$sql_memid="SELECT * FROM member WHERE memId='".$memid."'";
	$result_memid = $conn->query($sql_memid);
	
	if ($result_memid->num_rows>0){ 		
		header("Location: ../register.php?error=This+Student+ID/Professor+ID+is+already+registered");
		exit();		
	}
	
	//Check if Email already associated to another account
	$sql_email="SELECT * FROM logindetails WHERE email='".$email."'";
	$result_email = $conn->query($sql_email);
	
	if ($result_email->num_rows>0){ 		
		header("Location: ../register.php?error=This+Email+ID+is+already+associated+to+another+account.");
		exit();		
	}
	
	//Detect User Authentication Level Using Users Student ID/Professor ID
	if ($memid[0] == 's' || $memid[0] == 'S') {
		$authlevel = 'student';
	} else if ($memid[0] == 'p' || $memid[0] == 'P'){
		$authlevel = 'professor';
	} else {
		header("Location: ../register.php?registration=failed&error=invalidmemberid");
		exit();
	}
	
	
	// Insert the data collected from the form to the member table and logindetails table
	$sql = "INSERT INTO member VALUES('$memid', '$fname', '$lname', '$gender', '$contactno', '$address', '$profileimage')";
	$sql2 = "INSERT INTO logindetails(email, password, authLevel, status, memId) VALUES('$email', '$hashedpassword', '$authlevel', 'pending', '$memid' )";
	
	if ($conn->query($sql)===TRUE && $conn->query($sql2)===TRUE){
		header("Location: ../register.php?registration=success");
		exit();
	}
	else {
		print("Error: ".$sql."<br>".$conn->error);
	}
	
	$conn->close();
}

else {
	header("Location: ../index.php"); //Returns to homepage if this page opens without clicking submit button
	exit();
}
?>