<?php

if(isset($_POST['submit'])) {
	$bookid = $_POST["bookid"];
	$isbn10 = $_POST['isbn10'];

	########---------START: Code for  Image Upload-----------########
	$file = $_FILES['bookimage'];

	$fileName = $file['name'];
	$fileTmpName = $file['tmp_name'];
	$fileSize = $file['size'];
	$fileError = $file['error'];	

	if(isset($_FILES['bookimage']) && !empty($_FILES['bookimage']['name'])) {

		$fileExtArr = explode('.', $fileName);
		$fileExt = strtolower(end($fileExtArr));

		$allowedExt = array('jpg', 'jpeg', 'png');



		if (in_array($fileExt, $allowedExt)) {
			//Image Format Excepted

			if ($fileError === 0) {
				if($fileSize < 5000000) {

					$fileNewName = $isbn10.".".$fileExt;
					$fileDestination = "../"."images/"."booksimage/".$fileNewName;
					move_uploaded_file($fileTmpName,$fileDestination);


				} else {
					//File Size more than 5MB

					header("Location: ../bookedit.php?error=Image+size+to+large.+Max+5MB&btnedit=1&taskbookid=".$bookid);
					exit();

				}


			} else {
				// Unexpected error
				header("Location: ../bookedit.php?error=Unexpected+Error.+Please+try+again&btnedit=1&taskbookid=".$bookid);
				exit();
			}


		} else {
			//Error Image Format
			header("Location: ../bookedit.php?error=Invalid+Image+Format+Selected.+Please+Retry&btnedit=1&taskbookid=".$bookid);
			exit();
		}
		
	}
	
	########---------END: Code for  Image Upload-----------########

	########---------START: Code Updating data to database-----------########
	
	include("dbconnection.inc.php");
	
	
	$title = mysqli_real_escape_string($conn, $_POST["title"]); 
	$isbn10 = mysqli_real_escape_string($conn, $_POST["isbn10"]); 
	$isbn13 = mysqli_real_escape_string($conn, $_POST["isbn13"]); 
	$author = mysqli_real_escape_string($conn, $_POST["author"]); 
	$publisher = mysqli_real_escape_string($conn, $_POST["publisher"]); 
	$year = mysqli_real_escape_string($conn, $_POST["year"]); 
	$edition = mysqli_real_escape_string($conn, $_POST["edition"]); 
	$pages = mysqli_real_escape_string($conn, $_POST["pages"]); 
	$language = mysqli_real_escape_string($conn, $_POST["language"]); 
	$genre = mysqli_real_escape_string($conn, $_POST["genre"]); 
	$availability = mysqli_real_escape_string($conn, $_POST["availability"]); 
	$description = mysqli_real_escape_string($conn, $_POST["description"]); 
	
	if(isset($fileNewName)) {
		$sql = "UPDATE `book` SET `ISBN10`='$isbn10',`ISBN13`='$isbn13',`bkTitle`='$title',`bkAuthor`='$author',`bkPublisher`='$publisher',`bkYear`='$year',`bkEdition`='$edition',`bkPages`='$pages',`bkDescription`='$description',`bkImage`='$fileNewName',`bkAvailability`='$availability' WHERE bkId =  '$bookid' ";
	} else {
		$sql = "UPDATE `book` SET `ISBN10`='$isbn10',`ISBN13`='$isbn13',`bkTitle`='$title',`bkAuthor`='$author',`bkPublisher`='$publisher',`bkYear`='$year',`bkEdition`='$edition',`bkPages`='$pages',`bkDescription`='$description',`bkAvailability`='$availability' WHERE bkId =  '$bookid' ";
	}
	
	
	
	if ($conn->query($sql)===TRUE){
		
		if($language != "--Select Book Language-- *") {
			$sql2 = "UPDATE `book` SET `bkLanguage`= '$language' WHERE bkId = '$bookid'";
			if ($conn->query($sql2)===TRUE){
			} else {
				header("Location: ../bookedit.php?error=Unexpexted+Error+Please+Try+Again&btnedit=1&taskbookid=".$bookid);
				exit();
			}
		}
		
		if($genre != "--Select Genre-- *") {
			$sql3 = "UPDATE `book` SET `bkGenre`= '$genre' WHERE bkId = '$bookid'";
			if ($conn->query($sql3)===TRUE){
			} else {
				header("Location: ../bookedit.php?error=Unexpexted+Error+Please+Try+Again&btnedit=1&taskbookid=".$bookid);
				exit();
			}
		}
		
		header("Location: ../bookedit.php?registration=success&btnedit=1&taskbookid=".$bookid);
		exit();
		
	} else {
		print("Error: ".$sql."<br>".$conn->error);
	}
	
	$conn->close();
	
	########---------END: Code Updating data to database-----------########
	

} else {
	header("Location: ../bookedit.php");
	exit();
}	



?>