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
									<li class="active"><a href="admindashboard.users.php"><i class="fa fa-users"></i> Manage Users</a></li>
									<li><a href="admindashboard.books.php"><i class="fa fa-book"></i> Manage Books</a></li>
									<li><a href="admindashboard.reservations.php"><i class="fa fa-calendar"></i> Reservations</a></li>
									<li ><a href="admindashboard.borrowal.php"><i class="fa fa-hand-grab-o"></i> Borrowal</a></li>
								</ul>
                                
                                <hr>	
                                
                                <!----------START: Code for Deactivate and Activate Functioanlaities----------->
                                <?php
									if($_GET) {
										if(isset($_GET['btnactivate'])) {
											// When Activate Button clicked
											include("includes/dbconnection.inc.php");
											
											if(isset($_GET['taskuserid'])) {
												//If userID is present
												
												$taskuserid = $_GET['taskuserid'];
												$sql_activate = "UPDATE logindetails SET status='active' WHERE userId='".$taskuserid."'";
												
												 if ($conn->query($sql_activate)===TRUE){
													 echo '<script>location.href="admindashboard.users.php#resulttable"</script>';
												 }
												 else {
													 print("Error: ".$sql_activate."<br>".$conn->error);
												 }

												 $conn->close();											
											}
											
											
										} elseif(isset($_GET['btndeactivate'])) {
											// When Deactivate Button Clicked
											include("includes/dbconnection.inc.php");
											
											if(isset($_GET['taskuserid'])) {
												
												$taskuserid = $_GET['taskuserid'];
												$sql_deactivate = "UPDATE logindetails SET status='inactive' WHERE userId='".$taskuserid."'";
												
												 if ($conn->query($sql_deactivate)===TRUE){
													 echo '<script>location.href="admindashboard.users.php#resulttable"</script>';
												 }
												 else {
													 print("Error: ".$sql_deactivate."<br>".$conn->error);
												 }

												 $conn->close();
											}											
										} elseif(isset($_GET['btndelete'])) {
											// When Delete Button Clicked
											include("includes/dbconnection.inc.php");
											
											if(isset($_GET['taskmemid'])) {
												
												$taskmemid = $_GET['taskmemid'];
												$sql_reject = "DELETE FROM member WHERE memId='".$taskmemid."'";
												
												 if ($conn->query($sql_reject)===TRUE){
													 echo '<script>location.href="admindashboard.users.php#resulttable"</script>';
												 }
												 else {
													 print("Error: ".$sql_reject."<br>".$conn->error);
												 }

												 $conn->close();
											}											
										}
									}
								?>
                               	
                               	<!----------END: Code for Deactivate and Activate Functioanlaities----------->
                               
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
													<option>All Users</option>
													<option>Students</option>
													<option>Professors</option>
													<option>Suspended</option>
												</select>
												<p>Current: <?php if(isset($_GET['category'])){echo $_GET['category'];} ?></p>
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
													<table class="table" id="resulttable">
														<thead>
															<tr>
																<th> Member ID </th>
																<th> Name </th>
																<th> Gender </th>
																<th> Contact </th>
																<th> Address </th>
																<th> Email </th>     	
																<th> User Type </th>     	
																<th> Status </th>     	
																<th> Action </th>     	
															</tr>
														</thead>
																
														<tbody>
														
														<!-------------START: Code for Search------------------->
														
														<?php
															include("includes/dbconnection.inc.php");
															
															
															if (!isset($_GET['keywords'])) { // Check if search made
															
																$sql_table = "SELECT `member`.*, `logindetails`.* FROM `member` LEFT JOIN `logindetails` ON `logindetails`.`memId` = `member`.`memId` ORDER BY `member`.`fName` ASC";
																															
															} else {
																if ($_GET['keywords'] == "") { //Cheacks if search is done leaving seacrh box empty
																	if (isset($_GET['category'])) {
																		if ($_GET['category'] == "All Users") {
																			$sql_table = "SELECT `member`.*, `logindetails`.* FROM `member` LEFT JOIN `logindetails` ON `logindetails`.`memId` = `member`.`memId` ORDER BY `member`.`fName` ASC";
																		} elseif ($_GET['category'] == "Students"){
																			$sql_table = "SELECT `member`.*, `logindetails`.* FROM `member` LEFT JOIN `logindetails` ON `logindetails`.`memId` = `member`.`memId` WHERE authLevel = 'student' ORDER BY `member`.`fName` ASC ; ";
																		} elseif ($_GET['category'] == "Professors"){
																			$sql_table = "SELECT `member`.*, `logindetails`.* FROM `member` LEFT JOIN `logindetails` ON `logindetails`.`memId` = `member`.`memId` WHERE authLevel = 'professor' ORDER BY `member`.`fName` ASC; ";
																		} elseif ($_GET['category'] == "Suspended"){
																			$sql_table = "SELECT `member`.*, `logindetails`.* FROM `member` LEFT JOIN `logindetails` ON `logindetails`.`memId` = `member`.`memId` WHERE status = 'inactive' ORDER BY `member`.`fName` ASC; ";
																		}
																	} else {
																		$sql_table = "SELECT `member`.*, `logindetails`.* FROM `member` LEFT JOIN `logindetails` ON `logindetails`.`memId` = `member`.`memId` ORDER BY `member`.`fName` ASC";
																	}
																	
																} else {
																	if (isset($_GET['category'])) {
																		if ($_GET['category'] == "All Users") {
																			$keywords = mysqli_real_escape_string($conn ,$_GET['keywords']);
																			$sql_table = "SELECT `member`.*, `logindetails`.* FROM `member` LEFT JOIN `logindetails` ON `logindetails`.`memId` = `member`.`memId` WHERE `member`.`memId` LIKE '%".$keywords."%' OR `member`.`fName` LIKE '%".$keywords."%' OR `member`.`lName` LIKE '%".$keywords."%' OR `member`.`contactNo` LIKE '%".$keywords."%' OR `member`.`address` LIKE '%".$keywords."%' OR `logindetails`.`email` LIKE '%".$keywords."%' ORDER BY `member`.`fName` ASC";
																		} elseif ($_GET['category'] == "Students"){
																			$keywords = mysqli_real_escape_string($conn ,$_GET['keywords']);
																			$sql_table = "SELECT `member`.*, `logindetails`.* FROM `member` LEFT JOIN `logindetails` ON `logindetails`.`memId` = `member`.`memId` WHERE (`member`.`memId` LIKE '%".$keywords."%' OR `member`.`fName` LIKE '%".$keywords."%' OR `member`.`lName` LIKE '%".$keywords."%' OR `member`.`contactNo` LIKE '%".$keywords."%' OR `member`.`address` LIKE '%".$keywords."%' OR `logindetails`.`email` LIKE '%".$keywords."%') AND `logindetails`.`authLevel` = 'student' ORDER BY `member`.`fName` ASC";
																		} elseif ($_GET['category'] == "Professors"){
																			$keywords = mysqli_real_escape_string($conn ,$_GET['keywords']);
																			$sql_table = "SELECT `member`.*, `logindetails`.* FROM `member` LEFT JOIN `logindetails` ON `logindetails`.`memId` = `member`.`memId` WHERE (`member`.`memId` LIKE '%".$keywords."%' OR `member`.`fName` LIKE '%".$keywords."%' OR `member`.`lName` LIKE '%".$keywords."%' OR `member`.`contactNo` LIKE '%".$keywords."%' OR `member`.`address` LIKE '%".$keywords."%' OR `logindetails`.`email` LIKE '%".$keywords."%') AND `logindetails`.`authLevel` = 'professor' ORDER BY `member`.`fName` ASC";
																		} elseif ($_GET['category'] == "Suspended"){
																			$keywords = mysqli_real_escape_string($conn ,$_GET['keywords']);
																			$sql_table = "SELECT `member`.*, `logindetails`.* FROM `member` LEFT JOIN `logindetails` ON `logindetails`.`memId` = `member`.`memId` WHERE (`member`.`memId` LIKE '%".$keywords."%' OR `member`.`fName` LIKE '%".$keywords."%' OR `member`.`lName` LIKE '%".$keywords."%' OR `member`.`contactNo` LIKE '%".$keywords."%' OR `member`.`address` LIKE '%".$keywords."%' OR `logindetails`.`email` LIKE '%".$keywords."%') AND status = 'inactive' ORDER BY `member`.`fName` ASC; ";
																		}
																	}
																}
															}
															$result_table = $conn->query($sql_table);
															
															if ($result_table->num_rows>0) {
																		//Output data of each row
																		while ($row=$result_table->fetch_assoc()){
															
															
															
														?>
														<tr>
															<td><?php echo $row['memId']?></td>
															<td><?php echo $row['fName']." ".$row['lName']?></td>
															<td><?php echo $row['gender']?></td>
															<td><?php echo $row['contactNo']?></td>
															<td><?php echo $row['address']?></td>
															<td><?php echo $row['email']?></td>
															<td><?php echo $row['authLevel'] ?></td>
															<td><?php echo strtoupper($row['status'])?></td>
															<td >
																<a href="userview.php?btnview=1&taskmemid=<?php echo $row['memId'];?>&taskuserid=<?php echo $row['userId'];?>" ><i class="fa fa-search"></i> View</a> <br>
																<?php
																	if ($row['status'] == "active") {
																?>
																<a href="?btndeactivate=1&taskmemid=<?php echo $row['memId'];?>&taskuserid=<?php echo $row['userId'];?>"><i class="fa fa-power-off">&nbsp;Deactivate</i></a> <br>
																<?php
																	} elseif ($row['status'] == "inactive" || $row['status'] == "pending") {
																?>
																	<a href="?btnactivate=1&taskmemid=<?php echo $row['memId'];?>&taskuserid=<?php echo $row['userId'];?>"><i class="fa fa-check"></i>&nbsp;Activate</a> <br>
																<?php
																	}
																?>
																<a href="?btndelete=1&taskmemid=<?php echo $row['memId'];?>"><i class="fa fa-times"></i>&nbsp;Delete</a> 
																 
															</td>
														</tr>
														<?php
																		}
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