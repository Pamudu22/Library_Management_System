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
        <title>User Details</title>
        
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
			pageheader2('User Details');        
        ?>   
        <!-- End: Page Banner -->
        
        <!----------START: Code for Deactivate and Activate Functioanlaities----------->
		<?php
			if($_GET) {
				if(isset($_GET['btnactivate'])) {
					// When Activate Button clicked
					include("includes/dbconnection.inc.php");

					if(isset($_GET['taskuserid'])) {
						//If userID is present

						$taskuserid = $_GET['taskuserid'];
						$taskmemid = $_GET['taskmemid'];
						$sql_activate = "UPDATE logindetails SET status='active' WHERE userId='".$taskuserid."'";

						 if ($conn->query($sql_activate)===TRUE){
							 echo '<script>location.href="?btnview=1&taskmemid='.$taskmemid.'&taskuserid='.$taskuserid.'"</script>';
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
						$taskmemid = $_GET['taskmemid'];
						
						$sql_deactivate = "UPDATE logindetails SET status='inactive' WHERE userId='".$taskuserid."'";

						 if ($conn->query($sql_deactivate)===TRUE){
							 echo '<script>location.href="?btnview=1&taskmemid='.$taskmemid.'&taskuserid='.$taskuserid.'"</script>';
						 }
						 else {
							 print("Error: ".$sql_deactivate."<br>".$conn->error);
						 }

						 $conn->close();
					}											
				} elseif(isset($_GET['btndelete'])) {
					// When Reject Button Clicked
					include("includes/dbconnection.inc.php");

					if(isset($_GET['taskmemid'])) {

						$taskmemid = $_GET['taskmemid'];
						$taskuserid = $_GET['taskuserid'];
						
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
        
        
        <!-- Start: Cart Section -->
        <div id="content" class="site-content">
            <div id="primary" class="content-area">
                <main id="main" class="site-main">
                    <div class="signin-main">
                        <div class="container">
                            <div class="woocommerce">
                                <div class="woocommerce-login">
                                    <div class="company-info signin-register">
                                        <div class="col-md-8 col-md-offset-2 new-user">
                                            	
                                               <div class="row">
                                                <div class="col-md-12" style="box-shadow: 0 0 14px 0 rgba(0, 0, 0, 0.07);">
                                                  	
                                                  	<?php
															if (isset($_GET['btnview']) && isset($_GET['taskmemid']) && isset($_GET['taskuserid'])) {
																
																$taskmemid = $_GET['taskmemid'];
																$taskuserid = $_GET['taskuserid'];
																
																include("includes/dbconnection.inc.php");

																$sql_profile = "SELECT `member`.*, `logindetails`.* FROM `member` LEFT JOIN `logindetails` ON `logindetails`.`memId` = `member`.`memId` WHERE `member`.`memId` = '".$taskmemid."' ORDER BY `member`.`fName` ASC ";
																$result_profile = $conn->query($sql_profile);

																		if ($result_profile->num_rows>0) {
																					//Output data of each row
																					while ($row=$result_profile->fetch_assoc()){
													?>
                                                    <div>
                                                      	<div class="col-lg-2">
                                                      		<a class="" onClick="javascript:history.go(-1)" style="margin-top: 20px; font-size: 50px"><i class="fa fa-arrow-circle-left"></i></a>
                                                      	</div>
                                                       	
                                                        <div class="col-lg-4 col-lg-offset-2" style="margin-bottom:; margin-top: 20px;">
                                                           	
                                                           	<?php
																$imagename = "";
																if ($row['profileImage'] == "notassigned" || $row['profileImage'] == "") {
																	$imagename = 'default.png';
																} else {
																	$imagename = $row['profileImage'];
																}
															
															?>
                                                           
                                                           
                                                            <img src="images/profile/<?php echo $imagename;?>" width="100%" style="">
                                                        </div>
                                                        
                                                        <div class="col-lg-4 col-lg-offset-4" style="margin-bottom: 50px; margin-top: 5px; background-color: #ff7236; color: white; border-radius: 10px;">
                                                            <center><?php echo $row['memId'];?></center>
                                                        </div>
                                                        
														<div class="col-lg-6">
															<small>First Name</small>
															<p><?php echo $row['fName'];?></p>
														</div>   
														
														<div class="col-lg-6">
															<small>Last Name</small>
															<p><?php echo $row['lName'];?></p>
														</div> 
                                                      	
	 		                                            <div class="col-lg-6">
															<small>Gender</small>
															<p><?php echo $row['gender'];?></p>
														</div>   
														
														<div class="col-lg-6">
															<small>Contact Number</small>
															<p><?php echo $row['contactNo'];?></p>
														</div>  
                                                      	
                                                      	<div class="col-lg-6">
															<small>Address</small>
															<p><?php echo $row['address'];?></p>
														</div>              		
                                                       	
                                                       	<div class="col-lg-6">
															<small>Email</small>
															<p><?php echo $row['email'];?></p>
														</div>   	
                                                                                                            
                                                        
                                                        <div class="col-lg-6">
															<small>User Type</small>
															<p><?php echo strtoupper($row['authLevel']) ;?></p>
														</div>   
                                                   
                                                        <div class="col-lg-6">
															<small>Status</small>
															<p><?php echo strtoupper($row['status']) ;?></p>
														</div>
                                                   		
                                                   		<div class="clearfix"></div>
                                                   		
                                                  		<div class="col-lg-6">
                                                  			<?php
																if ($row['status'] == "active") {
															?>
															<a class="btn btn-default" href="?btndeactivate=1&taskmemid=<?php echo $row['memId'];?>&taskuserid=<?php echo $row['userId'];?>"><i class="fa fa-power-off"></i>&nbsp;Deactivate</a>
															<?php
																} elseif ($row['status'] == "inactive" || $row['status'] == "pending") {
															?>
																<a class="btn btn-default" href="?btnactivate=1&taskmemid=<?php echo $row['memId'];?>&taskuserid=<?php echo $row['userId'];?>"><i class="fa fa-check"></i>&nbsp;Activate</a>
															<?php
																}
															?>
                                                  		</div>
                                                  		<div class="col-lg-6">
                                                  			<a class="btn btn-default" href="?btndelete=1&taskmemid=<?php echo $row['memId'];?>"><i class="fa fa-times"></i>&nbsp;Delete User</a> 
                                                  		</div>
                                                  		<div style="margin-bottom: 75px;"></div>
                                                   		<?php
																					}
																		}
															}
														?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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