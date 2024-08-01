<?php
	session_start();
	
	if(isset($_POST['submit'])){

		include("dbconnection.inc.php");

		$userid = $_SESSION['userid'];
		$usertype = $_SESSION['usertype'];

		########---------START: Code for  Image Upload-----------########
			
		$file = $_FILES['profileimage'];
		
		$fileName = $file['name'];
		$fileTmpName = $file['tmp_name'];
		$fileSize = $file['size'];
		$fileError = $file['error'];

		$fileExtArr = explode('.', $fileName);
		$fileExt = strtolower(end($fileExtArr));

		$allowedExt = array('jpg', 'jpeg', 'png');

		if (in_array($fileExt, $allowedExt)) {
			//Image Format Excepted
			
			if ($fileError === 0) {
				if($fileSize < 5000000) {
					
					$fileNewName = $userid.$usertype.".".$fileExt;
					$fileDestination = "../"."images/"."profile/".$fileNewName;
					move_uploaded_file($fileTmpName,$fileDestination);

					// Obtain memid

					$sql_profile = "SELECT `member`.*, `logindetails`.* FROM `member` LEFT JOIN `logindetails` ON `logindetails`.`memId` = `member`.`memId` WHERE `logindetails`.`userid` = '".$userid."' ORDER BY `member`.`fName` ASC ";
					$result_profile = $conn->query($sql_profile);

					if ($result_profile->num_rows>0) {
						
						while ($row=$result_profile->fetch_assoc()){
							$memberid = $row['memId'];
						}
					}

					// Update Memeber table

					$sql = "UPDATE member SET profileImage ='".$fileNewName."' WHERE memId='".$memberid."'";
												
					if ($conn->query($sql)===TRUE){
						header("Location: ../usersettings.php?imagesuccess=profile+image+updated+sucessfully");
						exit();
					}
					else {
																	
					}
										
					
				} else {
					//File Size more than 5MB
					
					header("Location: ../usersettings.php?imageerror=Image+size+to+large.+Max+5MB");
					exit();
					
				}
	
			} else {
				// Unexpected error
				header("Location: ../usersettings.php?imageerror=Unexpected+Error.+Please+try+again");
				exit();
			}
			
			
		} else {
			//Error Image Format
			header("Location: ../usersettings.php?imageerror=Invalid+Image+Format+Selected.+Please+Retry");
			exit();
		}
		
		########---------END: Code for  Image Upload-----------########

	} else {
		header("Location: ../userprofile.php");
		exit();
	}

?>	