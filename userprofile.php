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
        <title>User Dashboard</title>
        
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
			pageheader2('User Dashboard');        
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
                                            <li><a href="usersettings.php">Account Setting</a></li>
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
                                
                                <!----------START: Code for Cancel Function----------->
                                <?php
									if($_GET) {
										// When Cancel Button clicked
										if(isset($_GET['btncancel']) && isset($_GET['taskresid']) && isset($_GET['taskbookid'])) {	
											
											include("includes/dbconnection.inc.php");
											
											$resid = $_GET['taskresid'];
											$bookid = $_GET['taskbookid'];
											
											
											$sql_cancel = "UPDATE reservation SET status='cancelled_by_user' WHERE resId='".$resid."'";
																								
											if ($conn->query($sql_cancel)===TRUE) {

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
													echo '<script>location.href="?errormessage=Unexpected+Error!</script>';
												}

											}
										
											
										}
									}
								?>
                               	
                               	<!----------END: Code for Cancel Function----------->
                                
                                <div class="col-md-12">
                                    <div class="page type-page status-publish hentry">
                                        <div class="entry-content">
                                            <div class="woocommerce table-tabs" id="responsiveTabs">
                                                <ul class="nav nav-tabs">
                                                    <li class="active"><b class="arrow-up"></b><a data-toggle="tab" href="#sectionA">Active Reservation</a></li>
                                                    <li><b class="arrow-up"></b><a data-toggle="tab" href="#sectionB">Completed Reservation</a></li>
                                                    <li><b class="arrow-up"></b><a data-toggle="tab" href="#sectionC">Expired Reservation</a></li>
                                                    <li><b class="arrow-up"></b><a data-toggle="tab" href="#sectionD">Cancelled Reservations</a></li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div id="sectionA" class="tab-pane fade in active">
                                                        
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
																	$userid = $_SESSION['userid'];
																	
																	//Obtaining the member id
																	
																	$sql3 = "SELECT `member`.`memId`, `logindetails`.`userId`, `member`.* FROM `member` LEFT JOIN `logindetails` ON `logindetails`.`memId` = `member`.`memId` WHERE `logindetails`.`userId` = ".$userid;
																	$result3 = $conn->query($sql3);

																	if ($result3->num_rows>0){
																		while ($row=$result3->fetch_assoc()){
																			$memid = $row['memId'];
																		}													
																	}
																	
																	// Querying the results
																	$sql_res = "SELECT `reservation`.*, `book`.* FROM `reservation` LEFT JOIN `book` ON `reservation`.`bkId` = `book`.`bkId` WHERE memId ='".$memid."' AND status = 'active' ORDER BY `reservation`.`resDateTime` DESC";
																	$result_res = $conn->query($sql_res);


																	if ($result_res->num_rows>0) {
																		
																		while ($row=$result_res->fetch_assoc()) {

																	
																?>   
                                                                
                                                                    <tr class="cart_item">
                                                                        <td data-title="Product" class="product-name">
                                                                            <span class="product-thumbnail">
                                                                                <a href="bookview.php?btnview=1&taskbookid=<?php echo $row['bkId'];?>"><img src="images/booksimage/<?php echo $row['bkImage'];?>" style="width: 150px;" alt="cart-product-1"></a>
                                                                            </span>
                                                                            <span class="product-detail" style="max-width: 300px">
                                                                                <a href="bookview.php?btnview=1&taskbookid=<?php echo $row['bkId'];?>"><strong><?php echo $row['bkTitle'];?></strong></a>
                                                                                <span><strong>Author:</strong> <?php echo $row['bkAuthor'];?></span>
                                                                                <span><strong>ISBN:</strong> <?php echo $row['ISBN10'];?> / <?php echo $row['ISBN13'];?></span>
                                                                            </span>
                                                                        </td>
                                                                        <td data-title="action" class="product-remove">
                                                                            <p><?php echo $row['resDateTime'];?></p>
                                                                        </td>
                                                                        <td data-title="action" class="product-remove">
                                                                            <p><?php echo $row['status'];?></p>
                                                                        </td>
                                                                        <td class="product-action">
                                                                            <div class="dropdown">
                                                                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">Cancel <b class="caret"></b></a>
                                                                                <ul class="dropdown-menu">
                                                                                    <li><a href="?btncancel=1&taskbookid=<?php echo $row['bkId'];?>&taskresid=<?php echo $row['resId'];?>">Cancel</a></li>
                                                                                    <li><a href="bookview.php?btnview=1&taskbookid=<?php echo $row['bkId'];?>">View Book</a></li>
                                                                                </ul>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                   <?php
																		}
																	} else {
																		echo '<p>No Results Found</p>';
																	}
																	?>
																</tbody>
                                                            </table>
                                                        
                                                    </div>	
                                                    <div id="sectionB" class="tab-pane fade in">
                                                        <table class="table table-bordered shop_table cart">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="product-name"></th>
                                                                        <th class="product-quantity">Reserved Date / Time</th>
                                                                        <th class="product-quantity">Status </th>
                                                                        <th class="product-action">&nbsp; </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                
                                                                <?php
																	$userid = $_SESSION['userid'];
																	
																	//Obtaining the member id
																	
																	$sql3 = "SELECT `member`.`memId`, `logindetails`.`userId`, `member`.* FROM `member` LEFT JOIN `logindetails` ON `logindetails`.`memId` = `member`.`memId` WHERE `logindetails`.`userId` = ".$userid;
																	$result3 = $conn->query($sql3);

																	if ($result3->num_rows>0){
																		while ($row=$result3->fetch_assoc()){
																			$memid = $row['memId'];
																		}													
																	}
																	
																	// Querying the results
																	$sql_res = "SELECT `reservation`.*, `book`.* FROM `reservation` LEFT JOIN `book` ON `reservation`.`bkId` = `book`.`bkId` WHERE memId ='".$memid."' AND status = 'completed' ORDER BY `reservation`.`resDateTime` DESC";
																	$result_res = $conn->query($sql_res);


																	if ($result_res->num_rows>0) {
																		//Getting book availability value and add 1 ro it.
																		while ($row=$result_res->fetch_assoc()) {

																	
																?>   
                                                                
                                                                    <tr class="cart_item">
                                                                        <td data-title="Product" class="product-name">
                                                                            <span class="product-thumbnail">
                                                                                <a href="bookview.php?btnview=1&taskbookid=<?php echo $row['bkId'];?>"><img src="images/booksimage/<?php echo $row['bkImage'];?>" style="width: 150px;" alt="cart-product-1"></a>
                                                                            </span>
                                                                            <span class="product-detail" style="max-width: 300px">
                                                                                <a href="bookview.php?btnview=1&taskbookid=<?php echo $row['bkId'];?>"><strong><?php echo $row['bkTitle'];?></strong></a>
                                                                                <span><strong>Author:</strong> <?php echo $row['bkAuthor'];?></span>
                                                                                <span><strong>ISBN:</strong> <?php echo $row['ISBN10'];?> / <?php echo $row['ISBN13'];?></span>
                                                                            </span>
                                                                        </td>
                                                                        <td class="product-remove">
                                                                            <p><?php echo $row['resDateTime'];?></p>
                                                                        </td>
                                                                        <td  class="product-remove" style="border-right: none;">
                                                                            <p><?php echo $row['status'];?></p>
                                                                        </td>
                                                                        <td class="product-action" style="border-left: none;">
                                                                            
                                                                        </td>
                                                                    </tr>
                                                                    
                                                                    
                                                                    
                                                                   <?php
																		}
																	} else {
																		echo '<p>No Results Found</p>';
																	}
																	?>
																</tbody>
                                                                    
                                                            </table>
                                                    </div>
                                                    <div id="sectionC" class="tab-pane fade in">
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
																	$userid = $_SESSION['userid'];
																	
																	//Obtaining the member id
																	
																	$sql3 = "SELECT `member`.`memId`, `logindetails`.`userId`, `member`.* FROM `member` LEFT JOIN `logindetails` ON `logindetails`.`memId` = `member`.`memId` WHERE `logindetails`.`userId` = ".$userid;
																	$result3 = $conn->query($sql3);

																	if ($result3->num_rows>0){
																		while ($row=$result3->fetch_assoc()){
																			$memid = $row['memId'];
																		}													
																	}
																	
																	// Querying the results
																	$sql_res = "SELECT `reservation`.*, `book`.* FROM `reservation` LEFT JOIN `book` ON `reservation`.`bkId` = `book`.`bkId` WHERE memId ='".$memid."' AND status = 'expired' ORDER BY `reservation`.`resDateTime` DESC";
																	$result_res = $conn->query($sql_res);


																	if ($result_res->num_rows>0) {
																		//Getting book availability value and add 1 ro it.
																		while ($row=$result_res->fetch_assoc()) {

																	
																?>   
                                                                
                                                                     <tr class="cart_item">
                                                                        <td data-title="Product" class="product-name">
                                                                            <span class="product-thumbnail">
                                                                                <a href="bookview.php?btnview=1&taskbookid=<?php echo $row['bkId'];?>"><img src="images/booksimage/<?php echo $row['bkImage'];?>" style="width: 150px;" alt="cart-product-1"></a>
                                                                            </span>
                                                                            <span class="product-detail" style="max-width: 300px">
                                                                                <a href="bookview.php?btnview=1&taskbookid=<?php echo $row['bkId'];?>"><strong><?php echo $row['bkTitle'];?></strong></a>
                                                                                <span><strong>Author:</strong> <?php echo $row['bkAuthor'];?></span>
                                                                                <span><strong>ISBN:</strong> <?php echo $row['ISBN10'];?> / <?php echo $row['ISBN13'];?></span>
                                                                            </span>
                                                                        </td>
                                                                        <td class="product-remove">
                                                                            <p><?php echo $row['resDateTime'];?></p>
                                                                        </td>
                                                                        <td  class="product-remove" style="border-right: none;">
                                                                            <p><?php echo $row['status'];?></p>
                                                                        </td>
                                                                        <td class="product-action" style="border-left: none;">
                                                                            
                                                                        </td>
                                                                    </tr>
                                                                   
                                                                   <?php
																		}
																	} else {
																		echo '<p>No Results Found</p>';
																	}
																	?>
																</tbody>
                                                                    
                                                            </table>
                                                    </div>
                                                    
                                                    <div id="sectionD" class="tab-pane fade in">
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
																	$userid = $_SESSION['userid'];
																	
																	//Obtaining the member id
																	
																	$sql4 = "SELECT `member`.`memId`, `logindetails`.`userId`, `member`.* FROM `member` INNER JOIN `logindetails` ON `logindetails`.`memId` = `member`.`memId` WHERE `logindetails`.`userId` = ".$userid;
																	$result4 = $conn->query($sql4);

																	if ($result4->num_rows>0){
																		while ($row=$result4->fetch_assoc()){
																			$memid = $row['memId'];
																		}													
																	}
																	
																	// Querying the results
																	$sql_res = "SELECT `reservation`.*, `book`.* FROM `reservation` LEFT JOIN `book` ON `reservation`.`bkId` = `book`.`bkId` WHERE memId ='".$memid."' AND (status = 'cancelled_by_librarian' OR status = 'cancelled_by_user')  ORDER BY `reservation`.`resDateTime` DESC";
																	$result_res = $conn->query($sql_res);


																	if ($result_res->num_rows>0) {
																		//Getting book availability value and add 1 ro it.
																		while ($row=$result_res->fetch_assoc()) {

																	
																?>   
                                                                
                                                                     <tr class="cart_item">
                                                                        <td data-title="Product" class="product-name">
                                                                            <span class="product-thumbnail">
                                                                                <a href="bookview.php?btnview=1&taskbookid=<?php echo $row['bkId'];?>"><img src="images/booksimage/<?php echo $row['bkImage'];?>" style="width: 150px;" alt="cart-product-1"></a>
                                                                            </span>
                                                                            <span class="product-detail" style="max-width: 300px">
                                                                                <a href="bookview.php?btnview=1&taskbookid=<?php echo $row['bkId'];?>"><strong><?php echo $row['bkTitle'];?></strong></a>
                                                                                <span><strong>Author:</strong> <?php echo $row['bkAuthor'];?></span>
                                                                                <span><strong>ISBN:</strong> <?php echo $row['ISBN10'];?> / <?php echo $row['ISBN13'];?></span>
                                                                            </span>
                                                                        </td>
                                                                        <td class="product-remove">
                                                                            <p><?php echo $row['resDateTime'];?></p>
                                                                        </td>
                                                                        <td  class="product-remove" style="border-right: none;">
                                                                            <p><?php echo $row['status'];?></p>
                                                                        </td>
                                                                        <td class="product-action" style="border-left: none;">
                                                                            
                                                                        </td>
                                                                    </tr>
                                                                   
                                                                   <?php
																		}
																	} else {
																		echo '<p>No Results Found</p>';
																	}
																	?>
																</tbody>
                                                                    
                                                            </table>
                                                    </div>
                                                    
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