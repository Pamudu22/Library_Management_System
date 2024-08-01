<?php

if (isset($_POST['submit'])) {
	
	session_start();
	
	include("dbconnection.inc.php");
	
	$userid = $_SESSION['userid'];
	$usertype = $_SESSION['usertype'];
	
	if ($usertype == "librarian") {
		$filename = "adminsettings.php";
	} else {
		$filename = "usersettings.php";
	}
	

	//Collect data from form
	$oldpassword = mysqli_real_escape_string($conn, $_POST["password"]);
	$newpassword = mysqli_real_escape_string($conn, $_POST["newpassword"]);

	//Check if email is valid
	$sql_email="SELECT * FROM logindetails WHERE userId='".$userid."'";
	$result_email = $conn->query($sql_email);
	
	if ($result_email->num_rows==1){ 		
		#User Name Exists in the Database
		
		while($row=$result_email->fetch_assoc()){
			$actualPassowrd = $row['password'];
			if (password_verify($oldpassword, $actualPassowrd)) {
				
				// Correct Old PASSWORD
				// Code to Change Password
				$hashedpassword = password_hash($newpassword, PASSWORD_DEFAULT);
				$sql_change_pwd = "UPDATE logindetails SET password = '".$hashedpassword."' WHERE userId = '".$userid."' " ;
				
				if ($conn->query($sql_change_pwd)===TRUE) {
					header("Location: ../".$filename."?pwdupdate=success");
					exit();
				} else {
					header("Location: ../".$filename."?pwderror=Unnexpexted+Error.+Please+Try+Again");
					exit();
				}
				
				
			}
			else {
				header('Location: ../'.$filename.'?pwderror=Incorrect+Password+(Old)#pwderrormessage');
				exit();
			}
		}	
		
	}
	
} else {
	header('Location: ../'.$filename);
	exit();
}

?>