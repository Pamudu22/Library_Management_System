<?php
session_start();

if (!isset($_SESSION['userid'])) {
	header('Location: login.php?error=login+to+use+these+features');
	exit();
} 

if (!isset($_GET['btnview']) || !isset($_GET['taskbookid']) || $_GET['btnview'] == "" || $_GET['taskbookid'] == "") {
	header('Location: searchbooks.php');
	exit();
}
?>



<!DOCTYPE html>
<html lang="zxx">
 
       

<head>        
		
        <!-- Meta -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1">

        <!-- Title -->
        <title>Book Details</title>

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
			pageheader2('Book Details');        
        ?> 
        <!-- End: Page Banner -->

        <!-- Start: Products Section -->
        <div id="content" class="site-content">
            <div id="primary" class="content-area">
                <main id="main" class="site-main">
                    <div class="booksmedia-detail-main">
                        <div class="container">
                            <div class="row">
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
                            </div>
                            
                            <!----------START: Code for Reserve Functioanlaities----------->
                                <?php
									if($_GET) {
										if(isset($_GET['btnreserve'])) {
											// When Delete Button clicked
																						
											if(isset($_GET['taskbookid'])) {
												include("includes/dbconnection.inc.php");
												
												date_default_timezone_set('Asia/Kolkata');
												$userid = $_SESSION['userid'];
												$bookid = $_GET['taskbookid'];
												$currentdatetime = date('Y/m/d H:i:s');
												$status = "active";
												
												
												
												# Gettting member id
												$sql3 = "SELECT `member`.`memId`, `logindetails`.`userId`, `member`.* FROM `member` LEFT JOIN `logindetails` ON `logindetails`.`memId` = `member`.`memId` WHERE `logindetails`.`userId` = ".$userid;
												$result3 = $conn->query($sql3);
												
												if ($result3->num_rows>0){
													while ($row=$result3->fetch_assoc()){
														$memid = $row['memId'];
													}													
												}
												else {
													print("Error: ".$sql1."<br>".$conn->error);	
												}
												
												
												# Gettting new book count after reservation
												$sql1 = "SELECT * FROM book WHERE bkId =".$bookid;
												$result1 = $conn->query($sql1);
												
												if ($result1->num_rows>0){
													while ($row=$result1->fetch_assoc()){
														$newbookavailability = $row['bkAvailability'] - 1;
													}													
												}
												else {
													print("Error: ".$sql1."<br>".$conn->error);	
												}
												
												if ($newbookavailability<0) {
													echo "Unexpected Error. Please Try again";
													exit();
												}
												
												# Inserting into Reservation table
												
												$sql2 = "INSERT INTO reservation (resDateTime, status, memId, bkId) VALUES ('".$currentdatetime."','".$status."','".$memid."','".$bookid."')";
												
												if ($conn->query($sql2)===TRUE){
													#update book availability in book table
													$sql5 = "UPDATE book SET bkAvailability='".$newbookavailability."' WHERE bkId=".$bookid;
												
													if ($conn->query($sql5)===TRUE){
														echo '<script>window.location.href = "userprofile.php?reservation=success";</script>';
														exit();
													}
													else {
														print("Error: ".$sql5."<br>".$conn->error);
													}
												}
												else {
													print("Error: ".$sql2."<br>".$conn->error);
												}

											}										
											
										}
									}
								?>
                               	
                               	<!----------END: Code for Reserve Functioanlaities----------->
							
                            <div class="booksmedia-detail-box">
                                <div class="detailed-box">
                                    <?php
											include("includes/dbconnection.inc.php");


											$bookid = $_GET['taskbookid'];

											$sql_table = "SELECT * FROM book WHERE bkId = '".$bookid."';";

											$result_table = $conn->query($sql_table);

											if ($result_table->num_rows>0) {
														//Output data of each row
														while ($row=$result_table->fetch_assoc()){
										?>
                                    <div class="col-xs-12 col-sm-5 col-md-3">
                                        <div class="post-thumbnail">
                                            <img src="images/booksimage/<?php echo $row['bkImage'] ?>" alt="Book Image" style="height: 370px;">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-7 col-md-6">
                                       
                                       
                                        <div class="post-center-content col-md-12" style="height: 370px;">
                                            <h2><?php echo $row['bkTitle'] ?></h2>
                                            <p><strong>Author:</strong> <?php echo $row['bkAuthor'] ?></p>
                                            <p><strong>ISBN:</strong> <?php echo $row['ISBN10'] ?> / <?php echo $row['ISBN13'] ?> </p>
                                            <p><strong>Edition:</strong> <?php echo $row['bkEdition'] ?></p>
                                            <p><strong>Publisher:</strong> <?php echo $row['bkPublisher'] ?></p>
                                            <p><strong>Year:</strong> <?php echo $row['bkYear'] ?></p>
                                            <p><strong>Length:</strong> <?php echo $row['bkPages'] ?> pages</p>
                                            <p><strong>Language:</strong> <?php echo $row['bkLanguage'] ?></p>
                                            <p><strong>Genre :</strong> <?php echo $row['bkGenre'] ?></p>
                                             
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3 ">
                                        <div class="post-right-content">
                                            <h4>Available now</h4>
                                            <p><strong>Copies Curently Available:</strong> <?php echo $row['bkAvailability'] ?> </p>
                                            
                                            <?php
												if ($row['bkAvailability'] > 0) {
													$availability = "Available";
												} else {
													$availability = "Currently Unavailable";
												}
											?>
                                            
                                            <p><strong>Availability:</strong> <?php echo $availability ?></p>
                                            
                                            <a href="?btnview=1&taskbookid=<?php echo $_GET['taskbookid'] ?>&btnreserve=1" class="btn btn-dark-gray" id="reservebook">Reserve for 24 Hours</a>
                                           
                                            
                                            <?php
                                            
												if ($_SESSION['usertype']=="librarian") {
													echo '<script type="text/javascript">document.getElementById("reservebook").style.display = "none";</script>';
												} 
												
												if ($row['bkAvailability'] <= 0) {
													echo '<script type="text/javascript">document.getElementById("reservebook").style.display = "none";</script>';
												}	
                                            ?>
                                            
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="clearfix"></div>
                                <p><strong>Description:</strong> <?php echo $row['bkDescription'] ?> </p>
                                
                                <?php
														}
											}
								?>

                                
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <!-- End: Products Section -->
        
        

       <?php
            include('includes/pagebottom.inc.php');
        ?>