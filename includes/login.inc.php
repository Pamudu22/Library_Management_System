<?php
	
if (isset($_POST['submit'])){	
	
	session_start();
	include("dbconnection.inc.php");
	include "login.php";
	
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	//Check if email is valid
	$sql_email="SELECT * FROM logindetails WHERE email='".$email."'";
	$result_email = $conn->query($sql_email);
	
	if ($result_email->num_rows==1){ 		
		#User Name Exists in the Database
		
		while($row=$result_email->fetch_assoc()){
			$actualPassowrd = $row['password'];
			$userid = $row['userId'];
			$usertype = $row['authLevel'];
			$accstatus = $row['status'];
			if (password_verify($password, $actualPassowrd)) {
				
				
				if ($accstatus == "active") {

					//SET Session Values
					$_SESSION['userid'] = $userid;
					$_SESSION['usertype'] = $usertype;

					include("reservationcheck.inc.php"); // Check Reservations
					header('Location: ../userprofile.php');
					exit();
				} elseif($accstatus == "inactive") {
					header('Location: ../login.php?error=Your+account+has+been+temporarily+suspended.');
					exit();
				} elseif($accstatus == "pending") {
					header('Location: ../login.php?error=Your+account+is+not+yet+verified+by+the+Administrator.');
					exit();
				} else {
					header('Location: ../login.php?error=Error+signing+in+please+try+again');
					exit();
				}	

			}
			else {
				header('Location: ../login.php?error=Invalid+Username+or+Password');
				exit();
			}
		}
		
		
	} else {
		#Invalid Useername
		header('Location: ../login.php?error=Invalid+Username+or+Password');
	}
}
?>