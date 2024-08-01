<?php
session_start();
?>

<!DOCTYPE html>
<html lang="zxx">
    

<head>        
        
        <!-- Meta -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1">
        
        <!-- Title -->
        <title>Error 404</title>
        
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
			pageheader2('Error 404');        
        ?>   
        		
        <!-- End: Page Banner -->
        
        <!-- Start: 404 Section -->
        <div id="content" class="site-content">
            <div id="primary" class="content-area">
                <main id="main" class="site-main">
                    <div class="error-main">
                        <div class="container">
                            <div class="error-view">
                                <div class="company-info">
                                    <div class="col-md-6 col-md-offset-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="error-box bg-dark  text-center">
                                                    <img src="images/error-img.png" alt="Error Image">
                                                    <h2>OOPS <small>Page Not Found!</small></h2>
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
        <!-- End: 404 Section -->
        
        <?php
            include('includes/pagebottom.inc.php');
        ?>
