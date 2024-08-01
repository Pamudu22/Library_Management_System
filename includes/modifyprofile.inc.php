<?php

if (isset($_POST['submit'])) {
	
	session_start();
	
	include("dbconnection.inc.php");
	
	$userid = $_SESSION['userid'];
	
	//Obtaining memid
	$sql="SELECT `logindetails`.*, `member`.* FROM `logindetails` LEFT JOIN `member` ON `logindetails`.`memId` = `member`.`memId` WHERE `logindetails`.`userId` = '".$userid."';";
	$result = $conn->query($sql);
	if ($result->num_rows==1) { 
		while($row=$result->fetch_assoc()){
			$memid = $row['memId'];
		}
	}

	//Collect data from form
	$contactno = mysqli_real_escape_string($conn, $_POST["contactno"]);
	$address = mysqli_real_escape_string($conn, $_POST["address"]);
	$email = mysqli_real_escape_string($conn, $_POST["email"]);
	
	//Check if same email
	
	$sql2="SELECT * FROM logindetails WHERE userId = '".$userid."';";
	$result2 = $conn->query($sql2);
	if ($result2->num_rows>0) { 
		while($row2=$result2->fetch_assoc()){
			$emailindb = $row2['email'];
		}
	}
	
	
	if ($email == $emailindb){
		
	} else {
		//Check if Email already associated to another account
		$sql_email="SELECT * FROM logindetails WHERE email='".$email."'";
		$result_email = $conn->query($sql_email);
		if ($result_email->num_rows>0){ 		
			header("Location: ../usersettings.php?error=This+Email+ID+is+already+associated+to+another+account.#errormessage");
			exit();		
		}
		
		$sql = "UPDATE logindetails SET email = '".$email."' WHERE userId = '".$userid."' ";
		if ($conn->query($sql)===TRUE){
			
 		} else {
			header("Location: ../usersettings.php?error=Unnexpexted+Error.+Please+Try+Again");
			exit();
		}
		
	}
	
	
	$sql3 = "UPDATE member SET contactNo = '".$contactno."', address = '".$address."' WHERE memId = '".$memid."' ";
	
	if ($conn->query($sql3)===TRUE) {
		header("Location: ../usersettings.php?update=success");
		exit();
	} else {
		header("Location: ../usersettings.php?error=Unnexpexted+Error.+Please+Try+Again");
		exit();
	}
	
} else {
	header('Location: ../usersettings.php');
	exit();
}

?>