<?php
function pageheader1($pagename){

?>


<header id="header-v1" class="navbar-wrapper">
	<div class="container">
		<div class="row">
			<nav class="navbar navbar-default">
				<div class="row">
					<div class="col-md-3">
						<div class="navbar-header">
							<div class="navbar-brand">
								<h1>
									<a href="index.html">
										<img src="images/logo/mainlogo.png" alt="LSU Library" />
									</a>
								</h1>
							</div>
						</div>
					</div>
					<div class="col-md-9">
						<!-- Header Topbar -->
						<div class="header-topbar hidden-sm hidden-xs">
							<div class="row">
								<div class="col-sm-6">
									<div class="topbar-info">
										<a href="tel:+61-3-8376-6284"><i class="fa fa-phone"></i>+94-7-7819-2969</a>
										<span>/</span>
										<a href="mailto:library@lsuniversity.com"><i class="fa fa-envelope"></i>library@lsuniversity.com</a>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="topbar-links">
										<?php
											if(isset($_SESSION['userid'])){
												echo '<a href="userprofile.php"><i class="fa fa-user"></i>My Account</a>';
												echo '<span>|</span>';
												echo '<a href="includes/logout.inc.php"><i class="fa fa-sign-out"></i>Logout</a>';
											} else {
												echo '<a href="register.php"><i class="fa fa-edit"></i>Register</a>';
												echo '<span>|</span>';
												echo '<a href="login.php"><i class="fa fa-sign-in"></i>Login</a>';
											}
										?>						
									</div>
								</div>
							</div>
						</div>
						<div class="navbar-collapse hidden-sm hidden-xs">
							<ul class="nav navbar-nav">
								<li id="homemenu"><a href="index.php">HOME</a></li>
								<li id="booksmenu"><a href="searchbooks.php">Books</a></li>
								<li id="aboutmenu"><a href="about.php">About</a></li>
								<li id="contactmenu"><a href="contact.php">Contact</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="mobile-menu hidden-lg hidden-md">
					<a href="#mobile-menu"><i class="fa fa-navicon"></i></a>
					<div id="mobile-menu">
						<ul>
							<li class="mobile-title">
								<h4>Navigation</h4>
								<a href="#" class="close"></a>
							</li>
								<li id="homemenu"><a href="index.php">HOME</a></li>
								<li id="booksmenu"><a href="searchbooks.php">Books</a></li>
								<li id="servicesmenu"><a href="services.php">Services</a></li>
								<li id="aboutmenu"><a href="about.php">About</a></li>
								<li id="contactmenu"><a href="contact.php">Contact</a></li>
						</ul>
					</div>
				</div>
				
			</nav>
		</div>
	</div>
</header>

<?php
	
	if ($pagename == 'index.php') {
		echo "<script>document.getElementById('homemenu').className = 'active';</script>";
	} else if($pagename == 'searchbooks.php') {
		echo "<script>document.getElementById('booksmenu').className = 'active';</script>";
	} else if($pagename == 'services.php') {
		echo "<script>document.getElementById('servicesmenu').className = 'active';</script>";
	} else if($pagename == 'about.php') {
		echo "<script>document.getElementById('aboutmenu').className = 'active';</script>";
	} else if($pagename == 'contact.php') {
		echo "<script>document.getElementById('contactmenu').className = 'active';</script>";
	}
	
					  }
?>