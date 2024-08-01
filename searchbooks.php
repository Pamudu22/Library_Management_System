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
        <title> Explore Books </title>

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
			pageheader2('Search Books');        
        ?>   
        		
        <!-- End: Page Banner -->

        <!-- Start: Products Section -->
        <div id="content" class="site-content">
            <div id="primary" class="content-area">
                <main id="main" class="site-main">
                    <div class="books-full-width">
                        <div class="container">
                            <!-- Start: Search Section -->
                            <section class="search-filters">
                                <div class="filter-box">
                                    <h3>What are you looking for at the library?</h3>
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
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
                                                
                                                <?php
													if (isset($_GET['searchgenre'])){
														if ($_GET['searchgenre'] == "Search by Genre" || $_GET['searchgenre'] == "") { } else {
															echo "<p>Current: ".$_GET['searchgenre']."</p>";
														}
													}
												?>
                                                
                                                <?php
													if (isset($_GET['searchkeyword'])){
														echo "<script> document.getElementById('searchkeyword').value ='".$_GET['searchkeyword']."'</script>";
													}
												?>
                                                
                                                
                                               
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
                            
                            <?php
								include('includes/pagination.inc.php')
							?>
                            
                            
                            
                            <div class="booksmedia-fullwidth">
                                <ul>
                                   	<?php
										
										$item_per_page      = 9; //item to display per page
										$page_url 			= "searchbooks.php";
									
										include("includes/dbconnection.inc.php");
							

										if(isset($_GET["page"])){ //Get page number from $_GET["page"]
											$page_number = filter_var($_GET["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
											if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
										}else{
											$page_number = 1; //if there's no page number, set it to 1
										}


										$results = $conn->query("SELECT COUNT(*) FROM book"); //get total number of records from database
										$get_total_rows = $results->fetch_row(); //hold total records in variable

										$total_pages = ceil($get_total_rows[0]/$item_per_page); //break records into pages

										################# Display Records per page ############################
										$page_position = (($page_number-1) * $item_per_page); //get starting position to fetch the records
										
										//Fetch a group of records using SQL LIMIT clause
										
										if (!isset($_GET['searchkeyword']) || !isset($_GET['searchgenre'])) { //If Search Button not clicked
											$sql_display = "SELECT * FROM book ORDER BY bkTitle ASC LIMIT $page_position, $item_per_page";
										} else { //If search button is clicked
											$searchkeyword = mysqli_escape_string($conn, $_GET['searchkeyword']) ;
											$searchgenre = mysqli_escape_string($conn, $_GET['searchgenre']) ;
											if ($searchkeyword == ""){
												if ($searchgenre == "Search by Genre" || $searchgenre == "") {
													$sql_display = "SELECT * FROM book ORDER BY bkTitle ASC LIMIT $page_position, $item_per_page";
												} else {
													$sql_display = "SELECT * FROM book WHERE bkGenre = '".$searchgenre."' ORDER BY bkTitle ASC LIMIT $page_position, $item_per_page";
												}
											} else {
												if ($searchgenre == "Search by Genre" || $searchgenre == "") {
													$sql_display = "SELECT * FROM book WHERE bkTitle LIKE '%".$searchkeyword."%' OR bkAuthor LIKE '%".$searchkeyword."%' OR ISBN10 LIKE '%".$searchkeyword."%' OR ISBN13 LIKE '%".$searchkeyword."%' ORDER BY bkTitle ASC LIMIT $page_position, $item_per_page";
												} else {
													$sql_display = "SELECT * FROM book WHERE (bkTitle LIKE '%".$searchkeyword."%' OR bkAuthor LIKE '%".$searchkeyword."%' OR ISBN10 LIKE '%".$searchkeyword."%' OR ISBN13 LIKE '%".$searchkeyword."%') AND bkGenre = '".$searchgenre."' ORDER BY bkTitle ASC LIMIT $page_position, $item_per_page";
												}
											}
											
										}
							
										
										$results_display = $conn->query($sql_display);

										//Display records fetched from database.
										while($row = $results_display->fetch_assoc()) {
									
									?>
                                    <li>
                                        <figure>
                                            <a href="bookview.php?btnview=1&taskbookid=<?php echo $row['bkId'] ?>"><img src="images/booksimage/<?php echo $row['bkImage'] ?>" style="height:400px" alt="Book"></a>
                                            <figcaption>
                                                <header>
                                                    <h5><a href="bookview.php?btnview=1&taskbookid=<?php echo $row['bkId'] ?>"><?php echo $row['bkTitle'] ?></a></h5>
                                                    <p><strong>Author:</strong>  <?php echo $row['bkAuthor'] ?></p>
                                                    <p><strong>ISBN:</strong>  <?php echo $row['ISBN10'] ?> / <?php echo $row['ISBN13'] ?></p>
                                                    
                                                </header>
                                                
                                            </figcaption>
                                        </figure>                                                
                                    </li>
                                    <?php
										}
									?>
                                </ul>
                            </div>
                            
                            <?php
								//create pagination 
								echo '<div align="center">';
								// We call the pagination function here. 
								echo paginate($item_per_page, $page_number, $get_total_rows[0], $total_pages, $page_url);
								echo '</div>';
							?>
                            
                            
                        </div>
                        
                    </div>
                </main>
            </div>
        </div>
        <!-- End: Products Section -->

        <?php
            include('includes/pagebottom.inc.php');
        ?>