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
        <title>About</title>
        
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
			pageheader2('About Us');        
        ?>   
        <!-- End: Page Banner -->
        <!-- Start: Services Section -->
        <div id="content" class="site-content">
            <div id="primary" class="content-area">
                <main id="main" class="site-main">
                    <div class="services-main">
                        <div class="services-pg">                            
                            
                            <section class="who-we-are">
                                <div class="company-info">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm-8 border">
                                                <div class="row">
                                                    <div class="col-sm-11">
                                                        <div class="company-detail">
                                                            <h3 class="section-title">Who we are</h3>
                                                            <span class="underline left"></span>
                                                            <p>Lowa State University of Science and Technology (Lowa State) is a flagship public land-grant and space-grant research university in Ames, Lowa. It is the largest university in the state of Lowa and the third largest university in the Big 12 athletic conference. Lowa State is classified as a research university with "highest research activity" by the Carnegie Foundation for the Advancement of Teaching. Lowa State is also a member of the prestigious Association of American Universities (AAU), which consists of 60 leading research universities in North America.

															Founded in 1858 and coeducational from its start, Lowa State became the nation's first designated land-grant institution when the Lowa Legislature accepted the provisions of the 1862 Morrill Act on September 11, 1862, making Lowa the first state in the nation to do so.

															Lowa State's academic offerings are administered today through eight colleges, including the graduate college, that offer over 100 bachelor's degree programs, 112 master's degree programs, and 83 at the Ph.D. level, plus a professional degree program in Veterinary Medicine.

															Lowa State University's athletic teams, the Cyclones, compete in Division I of the NCAA and are a founding member of the Big 12 Conference. The Cyclones field 16 varsity teams and have won numerous NCAA national championships.
                                                       </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="company-image"></div>
                                </div>
                            </section>
                    
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <!-- End: Services Section -->
        
        <?php
            include('includes/pagebottom.inc.php');
        ?>