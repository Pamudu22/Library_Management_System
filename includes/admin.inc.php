<?php


	
	include("dbconnection.inc.php");

	$memid = "admin1" ;
	$fname = "adminaccount";
	$lname = "adminaccount";
	$gender = "notspecified";
	$contactno = "none";
	$address = "none";
	$profileimage = "none";
	$email = "login@admin";
	$password = "admin";
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

	
	
	// Insert the data collected from the for to the member table and logindetails table
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


?>