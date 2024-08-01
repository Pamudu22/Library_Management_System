<?php

if(isset($_POST['submit'])) {
	########---------START: Code for  Image Upload-----------########
		
	$file = $_FILES['bookimage'];
	$isbn10 = $_POST['isbn10'];
	
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
			if($fileSize < 5000000) { // File Size in byte, 5000000 byte = 5MB
				
				$fileNewName = $isbn10.".".$fileExt;
				$fileDestination = "../"."images/"."booksimage/".$fileNewName;
				move_uploaded_file($fileTmpName,$fileDestination);
				
				
			} else {
				//File Size more than 5MB
				
				header("Location: ../newbook.php?error=Image+size+to+large.+Max+5MB");
				exit();
				
			}
			
			
		} else {
			// Unexpected error
			header("Location: ../newbook.php?error=Unexpected+Error.+Please+try+again");
			exit();
		}
		
		
	} else {
		//Error Image Format
		header("Location: ../newbook.php?error=Invalid+Image+Format+Selected.+Please+Retry");
		exit();
	}
	
	########---------END: Code for  Image Upload-----------########

	########---------START: Code Inserting data to database-----------########
	
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
	
	
	$sql = "INSERT INTO `book`(`bkTitle`, `ISBN10`, `ISBN13`, `bkAuthor`, `bkPublisher`, `bkYear`, `bkEdition`, `bkPages`, `bkLanguage`, `bkGenre`,`bkAvailability`, `bkDescription`, `bkImage`) VALUES ('$title', '$isbn10', '$isbn13', '$author', '$publisher', '$year', '$edition', '$pages', '$language', '$genre', '$availability', '$description', '$fileNewName')";
	
	if ($conn->query($sql)===TRUE){
		header("Location: ../newbook.php?registration=success");
		exit();
	} else {
		print("Error: ".$sql."<br>".$conn->error);
	}
	
	$conn->close();
	
	########---------END: Code Inserting data to database-----------########
	

} else {
	header("Location: ../newbook.php");
	exit();
}	

?>