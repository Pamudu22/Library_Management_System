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
									<li class="active"><a href="admindashboard.php"><i class="fa fa-list"></i> Main</a></li>
									<li><a href="admindashboard.users.php"><i class="fa fa-users"></i> Manage Users</a></li>
									<li><a href="admindashboard.books.php"><i class="fa fa-book"></i> Manage Books</a></li>
									<li><a href="admindashboard.reservations.php"><i class="fa fa-calendar"></i> Reservations</a></li>
                                    <li ><a href="admindashboard.borrowal.php"><i class="fa fa-hand-grab-o"></i> Borrowal</a></li>
								</ul>
                                
                                <hr>	
                                
                                <?php
									if($_GET) {
										if(isset($_GET['activate'])) {
											// When Activate Button clicked
											include("includes/dbconnection.inc.php");
											
											if(isset($_GET['userid'])) {
												//If userID is present
												
												$taskuserid = $_GET['userid'];
												$sql_activate = "UPDATE logindetails SET status='active' WHERE userId='".$taskuserid."'";
												
												 if ($conn->query($sql_activate)===TRUE){
													 echo '<script>location.href="admindashboard.php#sectionA"</script>';
												 }
												 else {
													 print("Error: ".$sql_activate."<br>".$conn->error);
												 }

												 $conn->close();
												
												
											}

										} elseif(isset($_GET['reject'])) {
											// When Reject Button Clicked
											include("includes/dbconnection.inc.php");
											
											if(isset($_GET['memid'])) {
												
												$taskmemid = $_GET['memid'];
												$sql_reject = "DELETE FROM member WHERE memId='".$taskmemid."'";
												
												 if ($conn->query($sql_reject)===TRUE){
													 echo '<script>location.href="admindashboard.php#sectionA"</script>';
												 }
												 else {
													 print("Error: ".$sql_reject."<br>".$conn->error);
												 }

												 $conn->close();
											}
										}
									}
								?>
                                <div class="col-md-12">
                                   
                                    <div class="page type-page status-publish hentry">
                                        <div class="entry-content">
                                            <div class="woocommerce table-tabs" id="responsiveTabs">
                                                <ul class="nav nav-tabs">
                                                    <li class="active"><b class="arrow-up"></b><a data-toggle="tab" href="#sectionA">Pending Registrations</a></li>
                                                    <li><b class="arrow-up"></b><a data-toggle="tab" href="#sectionB">Active Reservations</a></li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div id="sectionA" class="tab-pane fade in active">
                                                        
                                                    	<div class="table-responsive">
                                                    		<table class="table">
                                                    			<thead>
                                                    				<tr>
                                                    					<th>Member ID</th>
                                                    					<th> Name</th>
                                                    					<th> Contact</th>
                                                    					<th> Email</th>
                                                    					<th> Member Type</th>
                                                    					<th>  </th>     	
                                                    					<th>  </th>     	
                                                    				</tr>
                                                    			</thead>
                                                    			
                                                    			<tbody>
                                                    			<?php
																	include("includes/dbconnection.inc.php");
																	$sql = "SELECT `member`.`memId`, `member`.`fName`, `member`.`lName`, `member`.`contactNo`, `logindetails`.`email`, `logindetails`.`authLevel`, `logindetails`.`status`, `logindetails`.`userId` FROM `member` LEFT JOIN `logindetails` ON `logindetails`.`memId` = `member`.`memId` WHERE `logindetails`.`status` = 'pending'";
																	$result = $conn->query($sql);
					
																	if ($result->num_rows>0) {
																		//Output data of each row
																		while ($row=$result->fetch_assoc()){
																			$taskuserid = $row['userId'];
																			$taskmemid = $row['memId'];
																			$activate = "'?activate=1&userid=".$taskuserid."&memid=".$taskmemid."'";
																			$reject = "'?reject=1&userid=".$taskuserid."&memid=".$taskmemid."'";
																?>
                                                   				
                                                    				<tr>
                                                    					<td> <?php echo $row['memId']?> </td>
                                                    					<td> <?php echo $row['fName']." ".$row['lName']?> </td>
                                                    					<td> <?php echo $row['contactNo']?> </td>
                                                    					<td> <?php echo $row['email']?> </td>
                                                    					<td> <?php echo $row['authLevel']?> </td>
                                                    					<td> <button class="btn-sm" type="button" name="activate" id="activate" onClick="location.href= <?php echo $activate?>">Activate</button> </td>
                                                    					<td> <button class="btn-sm" type="submit" name="reject" id="reject" onClick="location.href= <?php echo $reject?>">Reject</button> </td>
                                                    				</tr>
                                                    			
                                                    			<?php
																		}
																	} elseif ($result->num_rows==0) {
																		echo '<p>No Pending Registrations</p>';
																	}		
																?>
                                                    			</tbody>
                                                    		</table>
                                                    	</div>
                                                        
                                                    </div>
                                                    <div id="sectionB" class="tab-pane fade in">
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
																	
																	
																	// Querying the results
																	$sql_res = "SELECT `reservation`.*, `book`.*, `member`.* FROM `reservation` LEFT JOIN `book` ON `reservation`.`bkId` = `book`.`bkId` LEFT JOIN `member` ON `reservation`.`memId` = `member`.`memId` WHERE status='active'ORDER BY `reservation`.`resDateTime` ASC";
																	$result_res = $conn->query($sql_res);


																	if ($result_res->num_rows>0) {
																		
																		while ($row=$result_res->fetch_assoc()) {

																	
																?>   
                                                                
                                                                    <tr class="cart_item">
                                                                        <td data-title="Product" class="product-name">
                                                                            
                                                                            <span class="product-detail" style="max-width: 300px">
                                                                                <a href="bookview.php?btnview=1&taskbookid=<?php echo $row['bkId'];?>"><strong><?php echo $row['bkTitle'];?></strong></a>
                                                                                <span><strong>Reservation ID:</strong> <?php echo $row['resId'];?></span>
                                                                                <span><strong>Member ID:</strong> <?php echo $row['memId'];?> - <?php echo $row['fName'];?> </span>
                                                                            </span>
                                                                        </td>
                                                                        <td data-title="action" class="product-remove">
                                                                            <p><?php echo $row['resDateTime'];?></p>
                                                                        </td>
                                                                        <td style="border-right: none;" class="product-remove">
                                                                            <p><?php echo $row['status'];?></p>
                                                                        </td>
                                                                        <td class="product-action" style="border-left: none;">
                                                                            <div class="dropdown">
                                                                                
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