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
        <title>Login</title>
        
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
			pageheader2('Login');        
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
                                        <div class="col-md-6 col-md-offset-3">
                                            <div class="row">
                                                <div class="col-md-12">
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
                                                  	
                                                    <div class="company-detail bg-dark">
                                                        <div class="signin-head">
                                                            <h2>Sign in</h2>
                                                            <span class="underline left"></span>
                                                        </div>
                                                        <form class="login" method="post" name="loginForm" action="includes/login.inc.php">
                                                            <p class="form-row form-row-first input-required">
                                                                <label>
                                                                    <span class="first-letter">Registered Email</span>  
                                                                    <span class="second-letter">*</span>
                                                                </label>
                                                                <input type="email"  id="email" name="email" class="input-text" required onFocus= 'document.getElementById("errormessage").style.display ="none";'>
                                                             </p>
                                                            <p class="form-row form-row-last input-required">
                                                                <label>
                                                                    <span class="first-letter">Password</span>  
                                                                    <span class="second-letter">*</span>
                                                                </label>
                                                                <input type="password" id="password" name="password" class="input-text" required>
                                                            </p>
                                                            <div class="clear"></div>
                                                            <div class="password-form-row">
                                                                <p class="form-row input-checkbox">
                                                                    <input type="checkbox" value="forever" id="rememberme" name="showpassword" onClick="showPassword()">
                                                                    <label class="inline" for="rememberme">Show Password</label>
                                                                </p>
                                                                <p class="lost_password">
                                                                    <a href="register.php">Create New Account</a>
                                                                </p>
                                                            </div>
                                                            <input type="submit" value="Login" name="submit" class="button btn btn-default">
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