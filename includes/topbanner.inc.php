<?php

function pageheader2($pagetitle) {
	

?>


<section class="page-banner services-banner">
            <div class="container">
                <div class="banner-header">
                    <h2><?php echo $pagetitle; ?></h2>
                    <span class="underline center"></span>
                </div>
                <div class="breadcrumb">
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><?php echo $pagetitle; ?></li>
                    </ul>
                </div>
            </div>
</section>


<?php
}
?>