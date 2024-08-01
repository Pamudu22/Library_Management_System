<?php
session_start();
if (!isset($_SESSION['userid'])) {
	header('Location: login.php');
	exit();
} else {
	if ($_SESSION['usertype']=="librarian") {
		header('Location: admindashboard.php');
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
        <title>Account Settings</title>
        
        <!-- Favicon -->
        <link href="images/favicon.ico" rel="icon" type="image/x-icon" />
        
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i%7CLato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet" />
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        
        <!-- Mobile Menu -->
        <link href="css/mmenu.css" rel="stylesheet" type="text/css" />
        <link href="css/mmenu.positioning.css" rel="stylesheet" type="text/css" />
        
        <!-- Responsive Table -->
        <link rel="stylesheet" type="text/css" href="css/responsivetable.css" />
        
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
			pageheader2('Account Settings');        
        ?>   
        <!-- End: Page Banner -->
        <!-- Start: Cart Section -->
        <div id="content" class="site-content">
            <div id="primary" class="content-area">
                <main id="main" class="site-main">
                    <div class="cart-main">
                        <div class="container">
                            <div class="row">
                                <div class="cart-head">
                                    <div class="col-xs-12 col-sm-6 account-option">
                                    	<?php
											include("includes/dbconnection.inc.php");
											
											$userid = $_SESSION['userid'];
											
											//Check if email is valid
											$sql="SELECT `logindetails`.*, `member`.* FROM `logindetails` LEFT JOIN `member` ON `logindetails`.`memId` = `member`.`memId` WHERE `logindetails`.`userId` = '".$userid."';";
											$result = $conn->query($sql);
											
											if ($result->num_rows==1) { 
												while($row=$result->fetch_assoc()){
													
										
										?>
                                        <strong style="display: inline;"><?php echo $row['fName']." ".$row['lName'] ?> </strong>
                                        <small style="display: inline; background-color: yellowgreen; color: white; padding: 3px; border-radius: 5px;"> <?php echo strtoupper($row['authLevel']) ?> </small>
                                        <p></p>
                                        <ul>
                                            <li><a href="userprofile.php">Dashboard</a></li>
                                            <li class="divider">|</li>
                                            <li><a href="includes/logout.inc.php">Log Out </a></li>
                                        </ul>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 library-info">
                                        <ul>
                                            <li>
                                                <strong>Email:</strong>
                                                <?php echo $row['email']?>
                                            </li>
                                            <li>
                                               <?php
													$imagename = "";
													if ($row['profileImage'] == "notassigned" || $row['profileImage'] == "") {
														$imagename = 'default.png';
													} else {
														$imagename = $row['profileImage'];
													}
															
												?>

                                               <img src="images/profile/<?php echo $imagename?>" width="100px">
                                                
                                            </li> 
                                        </ul>
                                    </div>
                                    <?php 
												}
											}
									?>
                                    <div class="clearfix"></div>
                                </div>
                                <form>
                                	
                                </form>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        
        <!-- End: Cart Section -->
        
        <!-- Start: Update Form -->
        <div id="content" class="site-content">
            <div id="primary" class="content-area">
                <main id="main" class="site-main">
                    <div class="signin-main">
                        <div class="container">
                            <div class="woocommerce">
                                <div class="woocommerce-login">
                                    <div class="company-info signin-register" style="padding-top: 0;">
                                        <div class="col-md-6  new-user">
                                            <div class="row">
                                                <div class="col-md-12">
                                                  	<div id="successmessage" style="text-align: center; background-color: green; color: white; padding: 5px; font-weight: 600; display: none;">
                                                  		Changes Made Successfully
                                                  	</div>
                                                  	
                                                  	<?php
													if (isset($_GET['update'])) {
														$update = $_GET['update'];

														if ($update == 'success') {
															echo '<script type="text/javascript"> document.getElementById("successmessage").style.display ="block"; </script>';
														}
													}
													?>
                                                 	
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
                                                   
                                                    <div class="company-detail new-account bg-light">
                                                        	
                                                        <div class="new-user-head">
                                                            <h2>Modify Profile Information</h2>
                                                            <p></p>
                                                            <span class="underline left"></span>
                                                        </div>
                                                        <form class="login" name="registrationForm" method="post" action="includes/modifyprofile.inc.php" enctype="multipart/form-data">
															
 
															<?php
																include("includes/dbconnection.inc.php");

																$userid = $_SESSION['userid'];

																//Check if email is valid
																$sql="SELECT `logindetails`.*, `member`.* FROM `logindetails` LEFT JOIN `member` ON `logindetails`.`memId` = `member`.`memId` WHERE `logindetails`.`userId` = '".$userid."';";
																$result = $conn->query($sql);

																if ($result->num_rows==1) { 
																	while($row=$result->fetch_assoc()){
																		
																		
										
															?>
															<p class="form-row input-required" style="margin-bottom: 0px;">
																<strong style="margin-bottom: 0;" >Contact Number</strong>
																
																<input type="text" id="contactno" name="contactno" class="input-text" maxlength="10" onChange="validatecontactno()" value="<?php echo $row['contactNo']; ?>" onFocus= 'document.getElementById("errormessage").style.display ="none"; document.getElementById("successmessage").style.display ="none";' required>
																
																<p style="margin-top: 0px; margin-bottom: 20px; color: #f56363;" id="contactnoerror"></p> 
															</p> 

															<p class="form-row input-required">
																<strong style="margin-bottom: 0;">Address</strong>
																
																<input type="text" id="address" name="address" class="input-text" value="<?php echo $row['address'];?>" required>
															</p>


                                                            
                                                            <p class="form-row input-required">
																<strong style="margin-bottom: 0;">Email</strong>
																
																<input type="email" id="email" name="email" class="input-text" value="<?php echo $row['email'];?>" required>
		
															</p> 
                                                                                                                                                                                       
                                                            <?php
																	}
																}
															?>
                                                                                                                             
  
                                                            <div class="clear"></div>
                                                            <input type="submit" value="Save" name="submit" id="submit" class="button btn btn-default" >
                                                            <div class="clear"></div>
                                                        </form> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6  new-user">
                                            <div class="row">
                                                <div class="col-md-12">
                                                  	<div id="pwdsuccessmessage" style="text-align: center; background-color: green; color: white; padding: 5px; font-weight: 600; display: none;">
                                                  		Changes Made Successfully
                                                  	</div>
                                                  	
                                                  	<?php
													if (isset($_GET['pwdupdate'])) {
														$pwdupdate = $_GET['pwdupdate'];

														if ($pwdupdate == 'success') {
															echo '<script type="text/javascript"> document.getElementById("pwdsuccessmessage").style.display ="block"; </script>';
														}
													}
													?>
                                                 	
                                                 	<div id="pwderrormessage" style="text-align: center; background-color: #f56363; color: white; padding: 5px; font-weight: 600; display: none;">
                                                  				Error Message
                                                  	</div>
                                                  	
													<?php
													if (isset($_GET['pwderror'])) {

														$pwderror = $_GET['pwderror'];

														echo '<script type="text/javascript"> document.getElementById("pwderrormessage").style.display ="block"; </script>';
														echo '<script type="text/javascript"> document.getElementById("pwderrormessage").innerHTML ="'.$pwderror.'"; </script>';

													}
													?>
                                                    <div class="company-detail new-account bg-light">
                                                        <div class="new-user-head">
                                                            <h2>Change Password</h2>
                                                            <p></p>
                                                            <span class="underline left"></span>
                                                        </div>
                                                        <form class="login" name="changePwdForm" method="post" action="includes/changepassword.inc.php" enctype="multipart/form-data" onSubmit="return paswordChangeValidate()">
															
 
                                                                                                                             
															<p class="form-row input-required">
																<label>
																	<span class="first-letter">Old Password</span>  
																	<span class="second-letter">*</span>
																</label>
																<input type="password" id="password" name="password" class="input-text" required>
															</p>                                                                                                                                             
															<p class="form-row input-required">
																<label>
																	<span class="first-letter">New Password</span>  
																	<span class="second-letter">*</span>
																</label>
																<input type="password" id="newpassword" name="newpassword" class="input-text" required>
															</p>
															
															<p class="form-row input-required" style="margin-bottom: 0px;">
																<label>
																	<span class="first-letter">Confirm New Password</span>  
																	<span class="second-letter">*</span>
																</label>
																<input type="password" id="confirmpassword" name="confirmpassword" class="input-text" required>
																																
																<p id="pwderror" style="margin-top: 0px; margin-bottom: 20px; color: #f56363; display: none;">* Passwords does not match.</p>
															</p>                                                       
                                                                                                                                                                                                                       
                                                                                                                                                                                                                        
                                                            <div class="clear"></div>
                                                            <input type="submit" value="Save" name="submit" id="submitpwd" class="button btn btn-default" >
                                                            <div class="clear"></div>
                                                        </form> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
										<div class="clearfix"></div>
                                   <div class="col-md-6  new-user">
                                            <div class="row">
                                                <div class="col-md-12">
                                                  	<div class="company-detail new-account bg-light">
                                                        <div class="new-user-head">
                                                            <h2>Change Profile Image</h2>
                                                            <p></p>
                                                            <span class="underline left"></span>
                                                        </div>
                                                        <form class="login" method="post" enctype="multipart/form-data" action="includes/modifyprofileimage.inc.php">
															
                                                    	  <p class="form-row input-required" style="">
															
																<p class="form-row input-required">  
																<p id="fileName" style="display: inline;"> Choose New Profile Image: </p>

																<input type="file" id="profileimage" name="profileimage" accept="image/jpeg, image/x-png, image/jpg" class="input-text" style="display: inline;" required>
																</p>	
																
																<p style="margin-top: 0px; margin-bottom: 20px; color: #f56363;" id="imageerror"></p>		
																	
															</p>
                                                    	  
                                                     	  <input type="submit" value="Save" name="submit" id="submitpwd" class="button btn btn-default" >
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
        <!-- End: Update Form -->
        
        <?php
            include('includes/pagebottom.inc.php');
        ?>