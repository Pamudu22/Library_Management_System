<?php

	include("dbconnection.inc.php");

	$sql_rcheck = "SELECT * FROM reservation WHERE status = 'active';";
	$result_rcheck = $conn->query($sql_rcheck);
	
															
	if ($result_rcheck->num_rows>0) {
		//Output data of each row
		while ($row=$result_rcheck->fetch_assoc()) {
			$r_resid = $row['resId'] ;
			$r_bookid = $row['bkId'] ;

			date_default_timezone_set('Asia/Kolkata');
			$r_datetime = $row['resDateTime'] ;
			$dt_now = date('Y/m/d H:i:s') ;

			$date1Timestamp = strtotime($r_datetime);
			$date2Timestamp = strtotime($dt_now);

			$difference = $date2Timestamp - $date1Timestamp; //Stores the time difference in seconds
			
			//The time in seconds is divided by 3600, as 1 hour has 3600 second. Floor keeps it as whole number
			$hours = floor($difference/3600); 

			if ($hours >= 24) {
				//Update status to expired
				$sql_expire = "UPDATE reservation SET status='expired' WHERE resId='".$r_resid."'";
																								
				if ($conn->query($sql_expire)===TRUE) {

					// Get book availability value
					$sql_avail = "SELECT * FROM book WHERE bkId='".$r_bookid."'";
					$result_avail = $conn->query($sql_avail);
					
																			
					if ($result_avail->num_rows>0) {
						//Getting book availability value and add 1 ro it.
						while ($row2=$result_avail->fetch_assoc()) {

							$r_currentavailability = $row2['bkAvailability'];
							$r_newavailability =  $r_currentavailability + 1;

						}
					}

					// Update Book table with increased book count
					$sql_availupdate = "UPDATE book SET bkAvailability = '".$r_newavailability."' WHERE bkId='".$r_bookid."'";
																				
					if ($conn->query($sql_availupdate)===TRUE) {
						echo '<script>console.log("Reservation Expired");</script>';
					} else {
						print("Error: ".$sql_availupdate."<br>".$conn->error);
						exit();
					}

				}
			} else {
				echo '<script>console.log("No Active Reservations for more than 24 Hours");</script>';
			}			
		}
	}

?>