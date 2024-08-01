<?php
session_start();
if (!isset($_SESSION['userid'])) {
	header('Location: login.php');
	exit();
} else {
	if ($_SESSION['usertype']!="librarian") {
		header('Location: userprofile.php');
		exit();
	}
}



if (!isset($_GET['btnedit']) || !isset($_GET['taskbookid'])) {
	header('Location: admindashboard.books.php');
	exit();
} else {
	if ($_GET['btnedit'] == "" || $_GET['taskbookid'] == "") {
		header('Location: admindashboard.books.php');
		exit();
	}
}

?>


<!DOCTYPE html>
<html lang="zxx">
    


<head>        
        
        
        <!-- Meta -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1">
        
        <!-- Title -->
        <title>Edit Book</title>
        
        <!-- Favicon -->
        <link href="images/favicon.ico" rel="icon" type="image/x-icon" />
        
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i%7CLato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet" />
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        
        <!-- Mobile Menu -->
        <link href="css/mmenu.css" rel="stylesheet" type="text/css" />
        <link href="css/mmenu.positioning.css" rel="stylesheet" type="text/css" />
        
        <!-- Stylesheet -->
        <link href="style.css" rel="stylesheet" type="text/css" />
        
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="js/html5shiv.min.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>


    <body>
        
        <!-- Start: Header Section -->
        <?php
        	$pagename = basename($_SERVER['PHP_SELF']);;
        	include('includes/pageheader.inc.php');
			pageheader1($pagename);        
        ?>
        <!-- End: Header Section -->
        
        <!-- Start: Page Banner -->
        <?php
        	include('includes/topbanner.inc.php');
			pageheader2('Edit Book');        
        ?>   
        <!-- End: Page Banner -->
        <!-- Start: Cart Section -->
        <div id="content" class="site-content">
            <div id="primary" class="content-area">
                <main id="main" class="site-main">
                    <div class="signin-main">
                        <div class="container">
                            <div class="woocommerce">
                                <div class="woocommerce-login">
                                    <div class="company-info signin-register">
                                        <div class="col-md-8 col-md-offset-2 new-user">
                                            <div class="row">
                                                <div class="col-md-12">
                                                  	
                                                  	
                                                  	<div id="successmessage" style="text-align: center; background-color: green; color: white; padding: 5px; font-weight: 600; display: none;">
                                                  		Changes Saved Successfully
                                                  	</div>
                                                  	
                                                  	<div id="errormessage" style="text-align: center; background-color: #f56363; color: white; padding: 5px; font-weight: 600; display: none;">
                                                  		Error Message
                                                  	</div>
                                                  	
                                                  	<?php
													if (isset($_GET['error'])) {
														
														$error = $_GET['error'];

														echo '<script type="text/javascript"> document.getElementById("errormessage").style.display ="block"; </script>';
														echo '<script type="text/javascript"> document.getElementById("errormessage").innerHTML ="'.$error.'"; </script>';
														
													}
													?>
                                                  	
													<?php
													if (isset($_GET['registration'])) {
														$registration = $_GET['registration'];

														if ($registration == 'success') {
															echo '<script type="text/javascript"> document.getElementById("successmessage").style.display ="block"; </script>';
														}
													}
													?>
                                                 	
                                                 	<?php
															if (isset($_GET['btnedit']) && isset($_GET['taskbookid'])) {
																
																$taskbookid = $_GET['taskbookid'];
																
																include("includes/dbconnection.inc.php");

																$sql_book = "SELECT * FROM book WHERE bkId = '".$taskbookid."'";
																$result_book = $conn->query($sql_book);

																		if ($result_book->num_rows>0) {
																					//Output data of each row
																					while ($row=$result_book->fetch_assoc()){
													?>
                                                  	
                                                  	<div class="col-lg-2">
                                                      		<a class="" href="admindashboard.books.php" style="margin-top: 20px; font-size: 50px"><i class="fa fa-arrow-circle-left"></i></a>
													</div>
                                                   	
                                                    <div class="company-detail new-account bg-light">
                                                        <div class="new-user-head col-lg-12">
                                                            <h2>Edit Book Details</h2>
                                                            <span class="underline left"></span>
                                                            <p class=""></p>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <form class="login" name="newbookform" method="post" action="includes/bookedit.inc.php" enctype="multipart/form-data" onSubmit="">
															<p class="form-row form-row-first input-required" style="margin-bottom: 0px">
																
																<p style="margin-bottom: 10px; background-color: #ff4e03; color: white; border-radius: 5px; padding: 5px; width: 100px; text-align: center;">Book Title</p>  
																
																<input type="text" id="title" name="title" class="input-text" maxlength="200" onFocus= 'document.getElementById("errormessage").style.display ="none"; document.getElementById("successmessage").style.display ="none";'  required value="<?php echo $row['bkTitle'] ?>">
																
																<input type="text" name="bookid" id="bookid" value="<?php echo $row['bkId'] ?>" hidden="true">
																
																
															</p>
															<p class="form-row input-required" style="margin-bottom: 0px;">
																<p style="margin-bottom: 10px; background-color: #ff4e03; color: white; border-radius: 5px; padding: 5px; width: 100px; text-align: center;">ISBN10 </p>  
																
																<input type="text" id="isbn10" name="isbn10" class="input-text" onChange="validateisbn10()" maxlength="10" required value="<?php echo $row['ISBN10'] ?>">
																<p style="margin-top: 0px; margin-bottom: 20px; color: #f56363;" id="isbn10error"></p> 
															</p>
															
															<p class="form-row input-required" style="margin-bottom: 0px;">
																<p style="margin-bottom: 10px; background-color: #ff4e03; color: white; border-radius: 5px; padding: 5px; width: 100px; text-align: center;"> ISBN13</p>  
																
																<input type="text" id="isbn13" name="isbn13" class="input-text" onChange="validateisbn13()" maxlength="13" required value="<?php echo $row['ISBN13'] ?>">
																<p style="margin-top: 0px; margin-bottom: 20px; color: #f56363;" id="isbn13error"></p> 
															</p>
															
															<p class="form-row input-required" style="margin-bottom: 0px;">
																
																<p style="margin-bottom: 10px; background-color: #ff4e03; color: white; border-radius: 5px; padding: 5px; width: 100px; text-align: center;">Author Name</p>  
																
																<input type="text" id="author" name="author" class="input-text"  maxlength="200" required value="<?php echo $row['bkAuthor'] ?>">					
															</p>
															
															<p class="form-row input-required" style="margin-bottom: 0px;">
																															
																<p style="margin-bottom: 10px; background-color: #ff4e03; color: white; border-radius: 5px; padding: 5px; width: 100px; text-align: center;">Publisher</p>  
																
																<input type="text" id="publisher" name="publisher" class="input-text"  maxlength="200" required value="<?php echo $row['bkPublisher'] ?>">					
															</p>
															
															<p class="form-row input-required" style="margin-bottom: 0px;">
																<p style="margin-bottom: 10px; background-color: #ff4e03; color: white; border-radius: 5px; padding: 5px; width: 100px; text-align: center;">Year</p>  
																
																<input type="text" id="year" name="year" class="input-text"  maxlength="4" required pattern="[0-9]{4,4}" value="<?php echo $row['bkYear'] ?>">					
															</p>
															
															<p class="form-row input-required" style="margin-bottom: 0px;">
																<p style="margin-bottom: 10px; background-color: #ff4e03; color: white; border-radius: 5px; padding: 5px; width: 100px; text-align: center;">Edition</p>  
																
																<input type="number" id="edition" name="edition" class="input-text"  maxlength="3" required value="<?php echo $row['bkEdition'] ?>">					
															</p>
															
															<p class="form-row input-required" style="margin-bottom: 0px;">
																
																<p style="margin-bottom: 10px; background-color: #ff4e03; color: white; border-radius: 5px; padding: 5px; width: 100px; text-align: center;">Pages</p>  
																
																<input type="number" id="pages" name="pages" class="input-text"  maxlength="5" required value="<?php echo $row['bkPages'] ?>">					
															</p>
															
															<p class="form-row input-required">
															
																<p style="margin-bottom: 10px; background-color: #ff4e03; color: white; border-radius: 5px; padding: 5px; width: 300px; text-align: center;">Language [Current: <?php echo $row['bkLanguage'] ?>]</p>
																<p>(Select New Language to Change Language. Leaving Unselected retains current Language)</p>
																
																<select id="language" name="language" tabindex="English">
																	<option>--Select Book Language-- *</option>
																	<option value="English">English</option>
																	<option value="Afrikanns">Afrikanns</option>
																	  <option value="Albanian">Albanian</option>
																	  <option value="Arabic">Arabic</option>
																	  <option value="Armenian">Armenian</option>
																	  <option value="Basque">Basque</option>
																	  <option value="Bengali">Bengali</option>
																	  <option value="Bulgarian">Bulgarian</option>
																	  <option value="Catalan">Catalan</option>
																	  <option value="Cambodian">Cambodian</option>
																	  <option value="Chinese (Mandarin)">Chinese (Mandarin)</option>
																	  <option value="Croation">Croation</option>
																	  <option value="Czech">Czech</option>
																	  <option value="Danish">Danish</option>
																	  <option value="Dutch">Dutch</option>
																	  <option value="Estonian">Estonian</option>
																	  <option value="Fiji">Fiji</option>
																	  <option value="Finnish">Finnish</option>
																	  <option value="French">French</option>
																	  <option value="Georgian">Georgian</option>
																	  <option value="German">German</option>
																	  <option value="Greek">Greek</option>
																	  <option value="Gujarati">Gujarati</option>
																	  <option value="Hebrew">Hebrew</option>
																	  <option value="Hindi">Hindi</option>
																	  <option value="Hungarian">Hungarian</option>
																	  <option value="Icelandic">Icelandic</option>
																	  <option value="Indonesian">Indonesian</option>
																	  <option value="Irish">Irish</option>
																	  <option value="Italian">Italian</option>
																	  <option value="Japanese">Japanese</option>
																	  <option value="Javanese">Javanese</option>
																	  <option value="Korean">Korean</option>
																	  <option value="Latin">Latin</option>
																	  <option value="Latvian">Latvian</option>
																	  <option value="Lithuanian">Lithuanian</option>
																	  <option value="Macedonian">Macedonian</option>
																	  <option value="Malay">Malay</option>
																	  <option value="Malayalam">Malayalam</option>
																	  <option value="Maltese">Maltese</option>
																	  <option value="Maori">Maori</option>
																	  <option value="Marathi">Marathi</option>
																	  <option value="Mongolian">Mongolian</option>
																	  <option value="Nepali">Nepali</option>
																	  <option value="Norwegian">Norwegian</option>
																	  <option value="Persian">Persian</option>
																	  <option value="Polish">Polish</option>
																	  <option value="Portuguese">Portuguese</option>
																	  <option value="Punjabi">Punjabi</option>
																	  <option value="Quechua">Quechua</option>
																	  <option value="Romanian">Romanian</option>
																	  <option value="Russian">Russian</option>
																	  <option value="Samoan">Samoan</option>
																	  <option value="Serbian">Serbian</option>
																	  <option value="Slovak">Slovak</option>
																	  <option value="Slovenian">Slovenian</option>
																	  <option value="Spanish">Spanish</option>
																	  <option value="Swahili">Swahili</option>
																	  <option value="Swedish ">Swedish </option>
																	  <option value="Tamil">Tamil</option>
																	  <option value="Tatar">Tatar</option>
																	  <option value="Telugu">Telugu</option>
																	  <option value="Thai">Thai</option>
																	  <option value="Tibetan">Tibetan</option>
																	  <option value="Tonga">Tonga</option>
																	  <option value="Turkish">Turkish</option>
																	  <option value="Ukranian">Ukranian</option>
																	  <option value="Urdu">Urdu</option>
																	  <option value="Uzbek">Uzbek</option>
																	  <option value="Vietnamese">Vietnamese</option>
																	  <option value="Welsh">Welsh</option>
																	  <option value="Xhosa">Xhosa</option>
																</select>	
																<p style="margin-top: 0px; margin-bottom: 20px; color: #f56363;" id="lanerror"></p> 				
															</p>
 

															<p class="form-row input-required">
																
																<p style="margin-bottom: 10px; background-color: #ff4e03; color: white; border-radius: 5px; padding: 5px; width: 300px; text-align: center;">Genre [Current: <?php echo $row['bkGenre'] ?>]</p>
																<p>(Select New Genre to Change Genre. Leaving Unselected retains current Genre)</p>
																
																<select id="genre" name="genre" >
																	<option>--Select Genre-- *</option>
																		<option>Action and adventure	</option>
																	<option>Alternate history	</option>
																	<option>Anthology	</option>
																	<option>Art</option>
																	<option>Autobiography</option>
																	<option>Biography</option>
																	<option>Book review</option>
																	<option>Children's	</option>
																	<option>Comic book	</option>
																	<option>Cookbook</option>
																	<option>Crime	</option>
																	<option>Diary</option>
																	<option>Dictionary</option>
																	<option>Documentary</option>
																	<option>Drama	</option>
																	<option>Encyclopedia</option>
																	<option>Facts</option>
																	<option>Fairytale	</option>
																	<option>Fantasy	</option>
																	<option>Fiction</option>
																	<option>Graphic novel	</option>
																	<option>Guide</option>
																	<option>Health</option>
																	<option>Historical fiction	</option>
																	<option>History</option>
																	<option>Horror	</option>
																	<option>Journal</option>
																	<option>Math</option>
																	<option>Memoir</option>
																	<option>Mystery	</option>
																	<option>Paranormal romance	</option>
																	<option>Picture book	</option>
																	<option>Poetry	</option>
																	<option>Political thriller	</option>
																	<option>Prayer</option>
																	<option>Religion, spirituality, and new age</option>
																	<option>Review</option>
																	<option>Romance	</option>
																	<option>Satire	</option>
																	<option>Science fiction	</option>
																	<option>Science</option>
																	<option>Self help</option>
																	<option>Short story	</option>
																	<option>Suspense	</option>
																	<option>Textbook</option>
																	<option>Thriller	</option>
																	<option>Travel</option>
																	<option>True crime</option>
																	<option>Young adult</option>
																</select>
																<p style="margin-top: 0px; margin-bottom: 20px; color: #f56363;" id="genreerror"></p> 
															</p>
															
															<p class="form-row input-required" style="margin-bottom: 0px;">
																<p style="margin-bottom: 10px; background-color: #ff4e03; color: white; border-radius: 5px; padding: 5px; width: 100px; text-align: center;">Availability</p>  
																
																<input type="number" id="availability" name="availability" class="input-text"  maxlength="5" required value="<?php echo $row['bkAvailability'] ?>">					
															</p>


                                                            
                                                            <p class="form-row input-required" style="">
																
																<p style="margin-bottom: 10px; background-color: #ff4e03; color: white; border-radius: 5px; padding: 5px; width: 100px; text-align: center;">Description</p>  
																
																<textarea class="form-control" rows="6" maxlength="1000" placeholder="Book Description.............." name="description" id="description"><?php echo $row['bkDescription'] ?></textarea>			
																	
															</p>
															
															<p class="form-row input-required" style="">
															
																<p class="form-row input-required">  
																<p id="fileName" style="display: inline;"> Choose New Book Image If Need to Change: </p>

																<input type="file" id="bookimage" name="bookimage" accept="image/jpeg, image/x-png, image/jpg" class="input-text" style="display: inline;" >
																</p>	
																
																<p style="margin-top: 0px; margin-bottom: 20px; color: #f56363;" id="imageerror"></p>		
																	
															</p>
                                  
                                                            <?php
																					}
																		}
															}
															?>  
                                                                                                                                                                                                                    
                                                            <div class="clear"></div>
                                                            <input type="submit" value="Save Changes" name="submit" id="submit" class="button btn btn-default" >
                                                            <div class="clear"></div>
                                                        </form> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <!-- End: Cart Section -->
        
		<?php
            include('includes/pagebottom.inc.php');
        ?>