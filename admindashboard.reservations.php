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



?>


<!DOCTYPE html>
<html lang="zxx">
    
    

<head>        
        
        <!-- Meta -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1">
        
        <!-- Title -->
        <title> Dashboard </title>
        
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
			pageheader2('Dashboard');        
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
											$sql="SELECT `logindetails`.*, `librarian`.* FROM `logindetails` LEFT JOIN `librarian` ON `logindetails`.`libId` = `librarian`.`libId` WHERE `logindetails`.`userId` = '".$userid."';";
											$result = $conn->query($sql);
											
											if ($result->num_rows==1) { 
												while($row=$result->fetch_assoc()){
													
										
										?>
                                        <strong style="display: inline;"><?php echo $row['fName']." ".$row['lName'] ?> </strong>
                                        <small style="display: inline; background-color: yellowgreen; color: white; padding: 3px; border-radius: 5px;"> <?php echo strtoupper($row['authLevel']) ?> </small>
                                        <p></p>
                                        <ul>
                                            <li><a href="adminsettings.php">Account Setting</a></li>
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
                                           
                                        </ul>
                                    </div>
                                    <?php 
												}
											}
									?>
                                    <div class="clearfix"></div>
                                </div>
                                
                                <!------------------------------------------------------------------------------------>
                                
                                
                                <ul class="nav nav-pills nav-justified">
									<li><a href="admindashboard.php"><i class="fa fa-list"></i> Main</a></li>
									<li><a href="admindashboard.users.php"><i class="fa fa-users"></i> Manage Users</a></li>
									<li><a href="admindashboard.books.php"><i class="fa fa-book"></i> Manage Books</a></li>
									<li class="active"><a href="admindashboard.reservations.php"><i class="fa fa-calendar"></i> Reservations</a></li>
									<li ><a href="admindashboard.borrowal.php"><i class="fa fa-hand-grab-o"></i> Borrowal</a></li>
								</ul>
                                
                                <hr>	
                                
                                <!----------START: Code for Button Functioanlaities----------->
                                <?php
									if($_GET) {
										if(isset($_GET['btncancelres'])) {
											// When Cancel Button clicked
											include("includes/dbconnection.inc.php");
											
											if (isset($_GET['taskresid'])){
												
												$reservationid = $_GET['taskresid'];
												$bookid = $_GET['taskbookid'];
												
												//Obtaining the current status
												$sql_status = "SELECT * FROM reservation WHERE resId='".$reservationid."'";
												$result_status = $conn->query($sql_status);


												if ($result_status->num_rows>0) {
													//Getting book availability value and add 1 ro it.
													while ($row1=$result_status->fetch_assoc()) {

														$currentstatus = $row1['status'];

													}
												}
												
												if ($currentstatus == 'active') { //If current status is active
													
													// Set Status to canceled_by_librarian
													$sql_updatestatus = "UPDATE reservation SET status = 'cancelled_by_librarian' WHERE resId ='".$reservationid."'";

													if ($conn->query($sql_updatestatus)===TRUE) {
														// Get book availability value
														$sql_avail = "SELECT * FROM book WHERE bkId='".$bookid."'";
														$result_avail = $conn->query($sql_avail);


														if ($result_avail->num_rows>0) {
															//Getting book availability value and add 1 ro it.
															while ($row2=$result_avail->fetch_assoc()) {

																$currentavailability = $row2['bkAvailability'];
																$newavailability =  $currentavailability + 1;

															}
														}

														// Update Book table with increased book count
														$sql_availupdate = "UPDATE book SET bkAvailability = '".$newavailability."' WHERE bkId='".$bookid."'";

														if ($conn->query($sql_availupdate)===TRUE) {
															echo '<script>location.href="?successmessage=Reservation+has+been+cancellled+successfully"</script>';

														} else {
															print("Error: ".$sql_availupdate."<br>".$conn->error);
															exit();
														}
													} else {
														print("Error: ".$sql_updatestatus."<br>".$conn->error);
														exit();
													}
													
												} else {
													echo '<script>location.href="?errormessage=Unexpected+Error"</script>';
												}
												
												
												
												
											}
										
											
											
										} elseif(isset($_GET['btnborrowed'])) {
											// When Mark Borrowed Dropdown Button Clicked
											include("includes/dbconnection.inc.php");
											
											if (isset($_GET['taskresid'])) {
												
												
												date_default_timezone_set('Asia/Kolkata');
												$currentdatetime = date('Y/m/d H:i:s');
												
												$reservationid = $_GET['taskresid'];
												
												//Insert into borrowal table
												
												$sql_insertborrow = "INSERT INTO `borrowal`(`bbDateTime`, `returnStatus`, `resId`) VALUES ('".$currentdatetime."','not_returned','".$reservationid."')";
												
												if ($conn->query($sql_insertborrow)===TRUE){
													
													//Update Reservation Status
													$sql_updateres = "UPDATE reservation SET status = 'completed' WHERE resId='".$reservationid."'";
												
													if ($conn->query($sql_updateres)===TRUE){
														echo '<script>location.href="?successmessage=Reservation+Marked+Borrowed"</script>';
													}
													else {
														echo '<script>location.href="?errormessage=Unexpected+Error"</script>';
													}
												}
												else {
													echo '<script>location.href="?errormessage=Unexpected+Error"</script>';
												}
											}
																					
										} 
									}
								?>
                               	
                               	<!----------END: Code for Button Functioanlaities----------->
                               
                               	<div class="col-md-12">
									<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
										<div class="col-md-4 col-sm-6 col-lg-offset-2">
											<div class="form-group">
												<label class="sr-only" for="keywords">Search by Keyword</label>
												<input class="form-control" placeholder="Search by Keyword" id="keywords" name="keywords" type="text" value="<?php if(isset($_GET['keywords'])){echo $_GET['keywords'];} ?>">
											</div>
										</div>
										<div class="col-md-2 col-sm-6">
											<div class="form-group">
												<select name="category" id="category" class="form-control">
													<option value="1">All Reservations</option>
													<option value="status='active'">Active</option>
													<option value="status='completed'">Completed</option>
													<option value="status='expired'">Expired</option>
													<option value="(status='cancelled_by_librarian' OR status ='cancelled_by_user')">Cancelled</option>
												</select>
												<?php if(isset($_GET['category'])){ 
													if ($_GET['category'] == "1") {
														
													} elseif ($_GET['category'] == "status='active'") {
														echo '<p>Current: Active Reservations</p>';
													} elseif ($_GET['category'] == "status='completed'") {
														echo '<p>Current: Completed Reservations</p>';
													} elseif ($_GET['category'] == "status='expired'") {
														echo '<p>Current: Expired Reservations</p>';
													} elseif ($_GET['category'] == "(status='cancelled_by_librarian' OR status ='cancelled_by_user')") {
														echo '<p>Current: Cancelled Reservations</p>';
													}
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
                               
                                <div class="col-md-12">
                                   
                                    <div class="page type-page status-publish hentry">

                                        <div class="entry-content">
                                           
                                            <div class="woocommerce table-tabs" id="responsiveTabs">
                                              	                                             	
                                            	<div class="table-responsive">
													
													<table class="table table-bordered shop_table cart">
														<thead>
															<tr>
																<th class="product-name"></th>
																<th class="product-quantity">Reserved Date / Time</th>
																<th class="product-quantity">Status </th>
																<th class="product-subtotal">&nbsp;</th>
															</tr>
														</thead>
                                               			<tbody>
                                               			 <?php					
															
															
															// Querying the results
															if (!isset($_GET['category']) ){
																$_GET['category'] = "1";
															}
															
															
															if (!isset($_GET['keywords'])) { // Check if search made
															
																$sql_res = "SELECT `reservation`.*, `book`.*, `member`.* FROM `book` INNER JOIN `reservation` ON `reservation`.`bkId` = `book`.`bkId` INNER JOIN `member` ON `reservation`.`memId` = `member`.`memId` WHERE ".$_GET['category']." ORDER BY `reservation`.`resDateTime` DESC";
																															
															} else {
																if ($_GET['keywords'] == "") { 
																$sql_res = "SELECT `reservation`.*, `book`.*, `member`.* FROM `book` INNER JOIN `reservation` ON `reservation`.`bkId` = `book`.`bkId` INNER JOIN `member` ON `reservation`.`memId` = `member`.`memId` WHERE ".$_GET['category']." ORDER BY `reservation`.`resDateTime` DESC";
																} else {
																	$keywords = $_GET['keywords'];
																	$sql_res = "SELECT `reservation`.*, `book`.*, `member`.* FROM `book` INNER JOIN `reservation` ON `reservation`.`bkId` = `book`.`bkId` INNER JOIN `member` ON `reservation`.`memId` = `member`.`memId` WHERE ".$_GET['category']." AND (resId LIKE '%".$keywords."%' OR `reservation`.`memId` LIKE '%".$keywords."%' OR fName LIKE '%".$keywords."%' OR `reservation`.`bkId` LIKE '%".$keywords."%' OR bkTitle LIKE '%".$keywords."%' OR resDateTime LIKE '%".$keywords."%') ORDER BY `reservation`.`resDateTime` DESC";
																}
															}
															
															
															

															$result_res = $conn->query($sql_res);


															if ($result_res->num_rows>0) {
																//Getting book availability value and add 1 ro it.
																while ($row=$result_res->fetch_assoc()) {
																	
														?>   
                                               				<tr class="cart_item">
																<td data-title="Product" class="product-name">
																	
																	<span class="product-detail">
																		<span><strong>Reservation ID:</strong> <?php echo $row['resId'];?></span>
																		<span><strong>Member ID: </strong><a href="userview.php?btnview=1&taskmemid=<?php echo $row['memId'];?>&taskuserid="><?php echo $row['memId'];?> - <?php echo $row['fName'];?></a> </span>
																		<span><strong>Book ID:</strong><a href="bookview.php?btnview=1&taskbookid=<?php echo $row['bkId'] ?>"><?php echo $row['bkId'];?> - <?php echo $row['bkTitle'];?> </a> </span>
																	</span>
																</td>
																<td data-title="action" class="product-remove">
																	<p><?php echo $row['resDateTime'];?></p>
																</td>
																<td data-title="action" class="product-remove">
																	<p><?php echo $row['status'];?></p>
																</td>
																<td class="product-action">
																	
																	<?php
																		
																		if ($row['status'] == "active") {
																	
																	?>
																	
																	<div class="dropdown">
																		<a href="#" data-toggle="dropdown" class="dropdown-toggle">Action <b class="caret"></b></a>
																		<ul class="dropdown-menu">
																			<li><a href="?btnborrowed=1&taskresid=<?php echo $row['resId'];?>&taskbookid=<?php echo $row['bkId'] ?>">Mark Borrowed</a></li>
																			<li><a href="?btncancelres=1&taskresid=<?php echo $row['resId'];?>&taskbookid=<?php echo $row['bkId'] ?>">Cancel Reservation </a></li>
																		</ul>
																	</div>
																	
																	<?php
																		} else {
																	?>
																		
																	<div class="dropdown">
																		<a href="#" data-toggle="dropdown" class="dropdown-toggle">No Action </a>
																		
																	</div>
																	
																	
																	<?php
																		}
																	?>
																</td>
                                                            </tr>
															<?php
																	}
																} else {
																	
																	echo "<p>No Results Found</p>";
																}
															?> 
                                               		</tbody>
													</table>
                                                </div> 
                                                                                       
                                                                                          	
                                            </div>
                                        </div><!-- .entry-content -->
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