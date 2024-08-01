<?php
session_start();
if (isset($_SESSION['userid'])) {
	header('Location: userprofile.php');
}

?>


<!DOCTYPE html>
<html lang="zxx">
    


<head>        
        
        
        <!-- Meta -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1">
        
        <!-- Title -->
        <title>Register</title>
        
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
			pageheader2('Register');        
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
                                                  		<a href="login.php">Account Created Successfully (Click to Login)</a>
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
                                                 	
                                                 	
                                                  	
                                                  	
                                                   	
                                                    <div class="company-detail new-account bg-light">
                                                        <div class="new-user-head">
                                                            <h2>Create New Account</h2>
                                                            <span class="underline left"></span>
                                                            <p>Please fill this Registration Form to Register.</p>
                                                        </div>
                                                        <form class="login" name="registrationForm" method="post" action="includes/register.inc.php" enctype="multipart/form-data" onSubmit="return validateRegistration()">
															<p class="form-row form-row-first input-required" style="margin-bottom: 0px">
																<label>
																	<span class="first-letter">Student ID / Lecturer ID</span>  
																	<span class="second-letter">*</span>
																</label>
																<input type="text" id="memid" name="memid" class="input-text" maxlength="10" onFocus= 'document.getElementById("errormessage").style.display ="none"; document.getElementById("successmessage").style.display ="none";' onChange="validatememid();" required>
																
																<p style="margin-top: 0px; margin-bottom: 20px; color: #f56363;" id="memiderror"></p> 
															</p>
															<p class="form-row input-required" style="margin-bottom: 0px;">
																<label>
																	<span class="first-letter">First Name</span>  
																	<span class="second-letter">*</span>
																</label>
																<input type="text" id="fname" name="fname" class="input-text" onChange="validatefname()" required>
																<p style="margin-top: 0px; margin-bottom: 20px; color: #f56363;" id="fnameerror"></p> 
															</p>

															<p class="form-row input-required" style="margin-bottom: 0px;">
																<label>
																	<span class="first-letter">Last Name</span>  
																	<span class="second-letter">*</span>
																</label>
																<input type="text" id="lname" name="lname" class="input-text" onChange="validatelname()" required>
																<p style="margin-top: 0px; margin-bottom: 20px; color: #f56363;" id="lnameerror"></p> 
															
															</p> 

															<p class="form-row input-required">
																<span class="first-letter">Gender: </span> 
																<input type="radio" id="genderMale" name="gender" value="Male" class="input-text" required> Male
																<input type="radio" id="genderFemale" name="gender" value="Female" class="input-text" readonly> Female
																<input type="radio" id="genderNSpecified" name="gender" value="NotSpecified" class="input-text" required> Not Specified
															</p>   

															<p class="form-row input-required" style="margin-bottom: 0px;">
																<label>
																	<span class="first-letter">Contact Number</span>  
																	<span class="second-letter">*</span>
																</label>
																<input type="text" id="contactno" name="contactno" class="input-text" maxlength="10" onChange="validatecontactno()" required>
																<p style="margin-top: 0px; margin-bottom: 20px; color: #f56363;" id="contactnoerror"></p> 
															</p> 

															<p class="form-row input-required">
																<label>
																	<span class="first-letter">Address</span>  
																	<span class="second-letter">*</span>
																</label>
																<input type="text" id="address" name="address" class="input-text" required>
															</p>


                                                            
                                                            <p class="form-row input-required" style="margin-bottom: 0px;">
																<label>
																	<span class="first-letter">Email</span>  
																	<span class="second-letter">*</span>
																</label>
																<input type="email" id="email" name="email" class="input-text" required>
																<p style="margin-top: 0px; margin-bottom: 20px; color: #f56363;">* Your Email will be your username to Login to your account.</p> 
															</p> 
                                                                                                                                                                                       
                                                                                                                             
															<p class="form-row input-required">
																<label>
																	<span class="first-letter">Password</span>  
																	<span class="second-letter">*</span>
																</label>
																<input type="password" id="password" name="password" class="input-text" required>
															</p>                                                                                                                                             <p class="form-row input-required" style="margin-bottom: 0px;">
																<label>
																	<span class="first-letter">Confirm-Password</span>  
																	<span class="second-letter">*</span>
																</label>
																<input type="password" id="confirmpassword" name="confirmpassword" class="input-text" required>
																
																<p id="pwderror" style="margin-top: 0px; margin-bottom: 20px; color: #f56363; display: none;">* Passwords does not match.</p>
															</p>                                                       
                                                                                                                                                                                                                       
                                                                                                                                                                                                                        
                                                            <div class="clear"></div>
                                                            <input type="submit" value="Signup" name="submit" id="submit" class="button btn btn-default" >
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