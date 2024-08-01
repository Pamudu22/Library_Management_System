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
									<li class="active"><a href="admindashboard.books.php"><i class="fa fa-book"></i> Manage Books</a></li>
									<li><a href="admindashboard.reservations.php"><i class="fa fa-calendar"></i> Reservations</a></li>
									<li ><a href="admindashboard.borrowal.php"><i class="fa fa-hand-grab-o"></i> Borrowal</a></li>
								</ul>
                                
                                <hr>	
                                
                                <!----------START: Code for Delete Functioanlaities----------->
                                <?php
									if($_GET) {
										if(isset($_GET['btndelete'])) {
											// When Delete Button clicked
																						
											if(isset($_GET['taskbookid'])) {
												include("includes/dbconnection.inc.php");
												
												$taskbookid = $_GET['taskbookid'];
												$sql_delete = "DELETE FROM book WHERE bkId='".$taskbookid."'";
												
												if ($conn->query($sql_delete)===TRUE){
													 echo '<script>location.href="admindashboard.books.php?success=Book+Has+Been+Successfully+Removed"</script>';
												 }
												 else {
													 print("Error: ".$sql_delete."<br>".$conn->error);
												 }

												 $conn->close();
											}
										}
									}
								?>
                               	
                               	<!----------END: Code for Delete Functioanlaities----------->
                               
                               	<div class="col-md-12">
									<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
										<div class="col-md-4 col-sm-6 col-lg-offset-3">
											<div class="form-group">
												<label class="sr-only" for="keywords">Search by Keyword</label>
												<input class="form-control" placeholder="Search by Keyword" id="keywords" name="keywords" type="text" value="<?php if(isset($_GET['keywords'])){echo $_GET['keywords'];} ?>">
											</div>
										</div>
										 
										<div class="col-md-2 col-sm-6">
											<div class="form-group">
												<input class="form-control" type="submit" value="Search">
											</div>
										</div>                                      		
									</form>
									
									<div class="col-md-2">
									
										<a href="newbook.php" class="btn btn-lg" style="border: #ff4e03 solid thin"><i class="fa fa-plus-circle"></i> Add New Books</a>
																			
									</div>
								</div>
                               
                                <div class="col-md-12">
                                  	<div id="successmessage" style="text-align: center; background-color: green; color: white; padding: 5px; font-weight: 600; display: none;">
									Book Has Been Sucessfully removed
								</div>

							<div id="errormessage" style="text-align: center; background-color: #f56363; color: white; padding: 5px; font-weight: 600; display: none;">
								Error Message
							</div>

							<?php
							if (isset($_GET['error'])) {

								$error = $_GET['error'];

								echo '<script type="text/javascript"> document.getElementById("errormessage").style.display ="block"; </script>';
								echo '<script type="text/javascript"> document.getElementById("errormessage").innerHTML ="'.$error.'"; </script>';

							}
							?>

							<?php
							if (isset($_GET['success'])) {
								
								
								$successmessage = $_GET['success'];
								
								if (isset($_GET['success'])) {
									echo '<script type="text/javascript"> document.getElementById("successmessage").style.display ="block"; </script>';
									echo '<script type="text/javascript"> document.getElementById("successmessage").innerHTML ="'.$successmessage.'"; </script>';
									
									
								}
							}
							?>
                                   
                                    <div class="page type-page status-publish hentry">

                                        <div class="entry-content">
                                           
                                            <div class="woocommerce table-tabs" id="responsiveTabs">
                                              	                                             	
                                            	<div class="table-responsive">
													<table class="table" id="resulttable">
														<thead>
															<tr>
																<th> </th>
																<th> Title </th>
																<th> ISBN10 </th>
																<th> ISBN13 </th>
																<th> Author </th>
																<th> Genre </th>
																<th> Availability </th>     	  	
																<th> Action </th>     	  	
															</tr>
														</thead>
																
														<tbody>
														
														<!-------------START: Code for Search------------------->
														
														<?php
															include("includes/dbconnection.inc.php");
															
															
															if (!isset($_GET['keywords'])) { // Check if search made
															
																$sql_table = "SELECT * FROM book ORDER BY bkTitle ASC;";
																															
															} else {
																if ($_GET['keywords'] == "") { 
																	
																	$sql_table = "SELECT * FROM book ORDER BY bkTitle ASC;";
																	
																} else {
																	$keywords = $_GET['keywords'];
																	
																	$sql_table = "SELECT * FROM book WHERE bkTitle LIKE '%".$keywords."%' OR ISBN10 LIKE '%".$keywords."%' OR ISBN13 LIKE '%".$keywords."%' ORDER BY bkTitle ASC;";
																}
															}
															$result_table = $conn->query($sql_table);
															
															if ($result_table->num_rows>0) {
																		//Output data of each row
																		while ($row=$result_table->fetch_assoc()){
															
															
															
														?>
														<tr>
															<td>
																<?php
																	if (isset($row['bkImage'])) {
																?>
																
																<img src="images/booksimage/<?php echo $row['bkImage']?>" style="width: 100px;" alt="Book Image">
																
																<?php
																	} else {
																?>
																
																<p>Image Failed to Load</p>
																
																<?php
																	}
																?>
															</td>
															<td><?php echo $row['bkTitle'] ?></td>
															<td><?php echo $row['ISBN10'] ?></td>
															<td><?php echo $row['ISBN13'] ?></td>
															<td><?php echo $row['bkAuthor'] ?></td>
															<td><?php echo $row['bkGenre'] ?></td>
															<td><?php echo $row['bkAvailability'] ?></td>								
															<td class="product-action">
																<a href="bookview.php?btnview=1&taskbookid=<?php echo $row['bkId'] ?>"><i class="fa fa-search">&nbsp;View</i></a> <br>
																
																<a href="bookedit.php?btnedit=1&taskbookid=<?php echo $row['bkId'] ?>"><i class="fa fa-edit">&nbsp;Edit</i></a>
																
																<a href="?btndelete=1&taskbookid=<?php echo $row['bkId'] ?>"><i class="fa fa-times">&nbsp;Delete</i></a> <br>
																 
															</td>							
														</tr>
														<?php
																		}
															} else {
															
														?>
														<?php
																echo '<p>No Results Found!</p>';
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