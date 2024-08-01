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
        <title>Home</title>
        
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
        
        
        
        
        <!-- Start: Slider Section -->
        
        
        <div data-ride="carousel" class="carousel slide" id="home-v1-header-carousel">
            
            <!-- Carousel slides -->
            <div class="carousel-inner">
                <div class="item active">
                    <figure>
                        <img alt="Home Slide" src="images/header-slider/home-v1/header-slide.jpg" />
                    </figure>
                    <div class="container">
                        <div class="carousel-caption">
                            <h3>Whenever, Wherever!</h3>
                            <h2>Online Books Reservation!</h2>
                            <p>Now you have the ability to remotely reserve book from our library for 24 Hours. Only for University Students and Professors</p>
                            <div class="slide-buttons hidden-sm hidden-xs">    
                                <a href="searchbooks.php" class="btn btn-primary" style="color: white;">View Books</a>
                                <a href="register.php" class="btn btn-default">Register</a>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            
            <!-- Controls -->
            <a class="left carousel-control" href="#home-v1-header-carousel" data-slide="prev"></a>
            <a class="right carousel-control" href="#home-v1-header-carousel" data-slide="next"></a>
        </div>
        <!-- End: Slider Section -->
        
        <!-- Start: Search Section -->
        <section class="search-filters">
                                <div class="filter-box">
                                    <h3>What are you looking for at the library?</h3>
                                    <form action="searchbooks.php" method="get">
                                        <div class="col-md-4 col-md-offset-1 col-sm-6 ">
                                            <div class="form-group">
                                                <input class="form-control" placeholder="Search by Keyword" id="searchkeyword" name="searchkeyword" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="form-group">
                                                <select name="searchgenre" id="searchgenre" class="form-control">
                                                    <option>Search by Genre</option>
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
                                                
                                                                                             
                                                
                                               
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-2 col-sm-6">
                                            <div class="form-group">
                                                <input class="form-control" type="submit" value="Search">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="clear"></div>
                            </section>
        <!-- End: Search Section -->
        
        <!-- Start: Welcome Section -->
        <section class="welcome-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12" >
                        <div class="welcome-wrap">
                            <div class="welcome-text">
                                <h2 class="section-title">Welcome to LSU Library Management System</h2>
                                <span class="underline left"></span>
                                <p class="lead">Lowa State University</p>
                                <p>Lowa State University of Science and Technology (Lowa State) is a flagship public land-grant and space-grant research university in Ames, Lowa. It is the largest university in the state of Lowa and the third largest university in the Big 12 athletic conference. Lowa State is classified as a research university with "highest research activity" by the Carnegie Foundation for the Advancement of Teaching. Lowa State is also a member of the prestigious Association of American Universities (AAU), which consists of 60 leading research universities in North America.

								Lowa State's academic offerings are administered today through eight colleges, including the graduate college, that offer over 100 bachelor's degree programs, 112 master's degree programs, and 83 at the Ph.D. level, plus a professional degree program in Veterinary Medicine.</p>
                               
                            </div>
                        </div>
                    </div>

                    <div id="newsContainer">
                        <h1 id="title">"Your Daily Dose of News"</h1>
                        <form action="News.php">
                        <button id="ButtonN" type="submit"> Explore News </button>
                        </form>
                        
                    </div>
                    
                    <?php
						include("includes/dbconnection.inc.php");
						
						$sql_books= "SELECT * FROM book;";
						$result_books = $conn->query($sql_books);
						
						$no_ofBooks = $result_books->num_rows;
					
						$sql_users= "SELECT * FROM member;";
						$result_users = $conn->query($sql_users);
						
						$no_ofUsers = $result_users->num_rows;
					?>
                   
                   
                    <div class="col-md-6">
                        <div class="facts-counter">
                            <ul>
                                <li class="bg-light-green">
                                    <div class="fact-item">
                                        <span>Total Books<strong class="fact-counter"><?php echo $no_ofBooks;?></strong></span>
                                    </div>
                                </li>                               
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="facts-counter">
                            <ul>
                                <li class="bg-green">
                                    <div class="fact-item">
                                        <span>Registered Users<strong class="fact-counter"><?php echo $no_ofUsers;?></strong></span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
        </section>
        <!-- End: Welcome Section -->

       <?php
			include('includes/pagebottom.inc.php');
		?>
        