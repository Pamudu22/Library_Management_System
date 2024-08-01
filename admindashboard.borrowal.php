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
                                    	
                                    	<!--- User Name, Email, Account Settings, Logout --->

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
									<li ><a href="admindashboard.reservations.php"><i class="fa fa-calendar"></i> Reservations</a></li>
									<li class="active"><a href="admindashboard.reservations.php"><i class="fa fa-hand-grab-o"></i> Burrowal</a></li>
								</ul>
                                
                                <hr>	
                                
                                <!----------START: Code for Button Functioanlaities----------->

                                <?php
									if($_GET) {
										// When Mark Returned Button clicked
										if(isset($_GET['btnborrowed'])) {	
											
											include("includes/dbconnection.inc.php");
											
											
											if (isset($_GET['taskborrowid']) && isset($_GET['taskbookid'])) {
												
												$borrowid = $_GET['taskborrowid'];
												$bookid = $_GET['taskbookid'];
												
												
												//Obtain Status
												$sql3 = "SELECT * FROM borrowal WHERE bbId=".$borrowid;
												$result3 = $conn->query($sql3);
												
												if ($result3->num_rows>0){
													while ($row=$result3->fetch_assoc()){
														$status = $row['returnStatus'];
														$borrowdate = $row['bbDateTime'];
													}													
												}
												
												/// Check if borrowal status is not_returned
												if ($status=="not_returned") {
													// Check if late return
													date_default_timezone_set('Asia/Kolkata');
													$currentdatetime = date('Y/m/d H:i:s');
													
													$date1Timestamp = strtotime($borrowdate);
													$date2Timestamp = strtotime($currentdatetime);
													
													$difference = $date2Timestamp - $date1Timestamp; //Stores the time difference in seconds
													
													
													
													$days = floor($difference/86400); //The time in seconds is divided by 86400, as 1 day has 86400 second. Floor keeps it as whole number
													
													


													if ($days >= 7) {
														
														$newstatus = "return_late";
														
													} else {
														
														$newstatus = "return_ontime";
														
													}
													
													// Update borrowal
													$sql_bupdate = "UPDATE borrowal SET bkReturnDate='".$currentdatetime."', returnStatus='".$newstatus."' WHERE bbId='".$borrowid."'";
												
													if ($conn->query($sql_bupdate)===TRUE){
														// ---Update book stock in book table---
														
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
															echo '<script>location.href="?successmessage=Borrowal+has+been+updated+sucessfuly"</script>';
														} else {
															echo '<script>location.href="?errormessage=Unexpected+error.+Please+try+again"</script>';
														}
														
													}
													else {
														echo '<script>location.href="?errormessage=Unexpected+error.+Please+try+again"</script>';											
													}													
													
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
													<option value="1">All Borrowal</option>
													<option value="returnStatus='not_returned'">Not Returned</option>
													<option value="returnStatus='return_ontime'">Returned (On Time)</option>
													<option value="returnStatus='return_late'">Returned (Late)</option>
													<option value="(returnStatus='return_ontime' OR returnStatus ='return_late')">All Returned</option>
												</select>
												<?php 
												if(isset($_GET['category'])){ 
													if ($_GET['category'] == "1") {
														
													} elseif ($_GET['category'] == "returnStatus='not_returned'") {
														echo '<p>Current: Not Returned</p>';
													} elseif ($_GET['category'] == "returnStatus='return_ontime'") {
														echo '<p>Current: Returned (On Time)</p>';
													} elseif ($_GET['category'] == "returnStatus='return_late'") {
														echo '<p>Current: Returned (Late)</p>';
													} elseif ($_GET['category'] == "(returnStatus='return_ontime' OR returnStatus ='return_late')") {
														echo '<p>Current: All Returned</p>';
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
																<th class="product-quantity">Borrowed Date / Time</th>
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

																$sql_res = "SELECT `borrowal`.*, `reservation`.`resId`, `member`.`memId`, `member`.`fName`, `book`.`bkId`, `book`.`bkTitle` FROM `borrowal` INNER JOIN `reservation` ON `borrowal`.`resId` = `reservation`.`resId` INNER JOIN `member` ON `reservation`.`memId` = `member`.`memId` INNER JOIN `book` ON `reservation`.`bkId` = `book`.`bkId` WHERE ".$_GET['category']." ORDER BY `borrowal`.`bbDateTime` DESC";
																															
															} else {
																if ($_GET['keywords'] == "") { 
																	$sql_res = "SELECT `borrowal`.*, `reservation`.`resId`, `member`.`memId`, `member`.`fName`, `book`.`bkId`, `book`.`bkTitle` FROM `borrowal` INNER JOIN `reservation` ON `borrowal`.`resId` = `reservation`.`resId` INNER JOIN `member` ON `reservation`.`memId` = `member`.`memId` INNER JOIN `book` ON `reservation`.`bkId` = `book`.`bkId` WHERE ".$_GET['category']." ORDER BY `borrowal`.`bbDateTime` DESC";
																} else {
																	$keywords = $_GET['keywords'];
																	
																	$sql_res = "SELECT `borrowal`.*, `reservation`.`resId`, `member`.`memId`, `member`.`fName`, `book`.`bkId`, `book`.`bkTitle` FROM `borrowal` INNER JOIN `reservation` ON `borrowal`.`resId` = `reservation`.`resId` INNER JOIN `member` ON `reservation`.`memId` = `member`.`memId` INNER JOIN `book` ON `reservation`.`bkId` = `book`.`bkId` WHERE ".$_GET['category']." AND (bbId LIKE '%".$keywords."%' OR `reservation`.`resId` LIKE '%".$keywords."%' OR `reservation`.`memId` LIKE '%".$keywords."%' OR fName LIKE '%".$keywords."%' OR `reservation`.`bkId` LIKE '%".$keywords."%' OR bkTitle LIKE '%".$keywords."%' OR bbDateTime LIKE '%".$keywords."%') ORDER BY `borrowal`.`bbDateTime` DESC";																	
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
																		<span><strong>Borrowal ID:</strong> <?php echo $row['bbId'];?></span>
																		<span><strong>Reservation ID:</strong> <?php echo $row['resId'];?></span>
																		<span><strong>Member ID: </strong><a href="userview.php?btnview=1&taskmemid=<?php echo $row['memId'];?>&taskuserid="><?php echo $row['memId'];?> - <?php echo $row['fName'];?></a> </span>
																		<span><strong>Book ID:</strong><a href="bookview.php?btnview=1&taskbookid=<?php echo $row['bkId'] ?>"><?php echo $row['bkId'];?> - <?php echo $row['bkTitle'];?> </a> </span>
																	</span>
																</td>
																<td data-title="action" class="product-remove">
																	<p><?php echo $row['bbDateTime'];?></p>
																</td>
																
																<?php
																	
																	if($row['returnStatus']=="not_returned") {
																		$returndate = '';
																	} else {
																		$returndate = " (".$row['bkReturnDate'].")";
																	}
																
																?>
																
																
																<td data-title="action" class="product-remove">
																	<p><?php echo $row['returnStatus'].$returndate;?></p>
																</td>
																<td class="product-remove">
																	
																	<?php
																		
																		if ($row['returnStatus'] == "not_returned") {
																	
																	?>
																	
																		
																		<button type="button" class="btn btn-sm" onClick='location.href="?btnborrowed=1&taskborrowid=<?php echo $row['bbId'];?>&taskbookid=<?php echo $row['bkId'] ?>"'><i class="fa fa-check"></i> Mark Returned</button>
																	
																	<?php
																		} elseif ($row['returnStatus'] == "return_late") {
																	?>
																		
																		<button type="button" class="btn btn-sm" onClick='location.href="?btnfine=1&taskborrowid=<?php echo $row['bbId'];?>"'><i class="fa fa-check"></i> Calculate Fine</button>
																		
																		<p style="margin-top: 20px; display: none;" id="finetext<?php echo $row['bbId'];?>">Fine: <span id="fineamount<?php echo $row['bbId'];?>" style="font-size: 20px; background-color: forestgreen; color: white; padding: 5px; margin-bottom: 10px; border-radius: 5px;">LKR 500</span> 
																		<br>
																		<br>
																		(Fine Calculated as LKR 200 for each extra day)
																		</p>
																		
																	<?php
																		} else {
																	?>
																		
																	<div class="dropdown">
																		<button type="button" class="btn btn-sm" disabled> No Action </button>
																		
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
                                                 
                                                <!-------------------- START: Code for calculate fine button --------------->                                      
                                                <?php
													if (isset($_GET['btnfine']) && isset($_GET['taskborrowid'])) {
											
														$borrowid = $_GET['taskborrowid'];

														//Obtain Borowal Date

														$sql_bdata = "SELECT * FROM borrowal WHERE bbId='".$borrowid."' ";
														$result_bdata = $conn->query($sql_bdata);


														if ($result_bdata->num_rows>0) {
															//Output data of each row
															while ($row=$result_bdata->fetch_assoc()) {
																$borrowdate =  $row['bbDateTime'];
																$returndate =  $row['bkReturnDate'];
																$returnstatus=  $row['returnStatus'];
															}
														}

														if ($returnstatus == "return_late") {

															$date1Timestamp = strtotime($borrowdate);
															$date2Timestamp = strtotime($returndate);

															$difference = $date2Timestamp - $date1Timestamp; //Stores the time difference in seconds

															$days = floor($difference/86400); //The time in seconds is divided by 86400, as 1 day has 86400 second. Floor keeps it as whole number

															if ($days >= 7) {

																$extradays = $days - 7;

																if ($extradays<=0) {
																	$extradays = 1;
																}

																$fineamount = $extradays * 200;
																$fineamountdisplay = "LKR ".$fineamount;

																echo '<script type="text/javascript"> document.getElementById("fineamount'.$borrowid.'").innerHTML ="'.$fineamountdisplay.'"; </script>';

																echo '<script type="text/javascript"> document.getElementById("finetext'.$borrowid.'").style.display ="block"; </script>';

															}

														}

													}
												?>
                                               
                                                <!-------------------- END: Code for calculate fine button ----------------->                                      
                                                                                          	
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