#!/usr/local/bin/php
<?php
	ob_clean();
	$count = $_GET['count'];

	//add query to calculate most recent images
	//change placeholder 2084713 to correct oid

	for ($i = 1; $i <= $count; $i++) {
		
<<<<<<< HEAD
		$temp = '/cise/homes/njiang/public_html/images/tmpa' . $i . '.jpg';

		$conn = pg_connect('user=njiang host=postgres dbname=db password=asdfasdf');
		pg_query($conn, "begin");
		$result = pg_lo_export($conn, '2085034', $temp); 
		pg_query($conn, "commit");
	
		pg_close($conn);
		echo "<IMG SRC=showimage.php?index=a" . $i .  ">";
=======
		$temp = '/cise/homes/njiang/public_html/images/tmp' . $i . '.jpg';

		$conn = pg_connect('user=njiang host=postgres dbname=db password=asdfasdf');
		pg_query($conn, "begin");
		$result = pg_lo_export($conn, '2084713', $temp); 
		pg_query($conn, "commit");
	
		pg_close($conn);
		echo "<IMG SRC=showimage.php?index=" . $i .  ">";
>>>>>>> 1c4a0399a35cd965e4ed5b9c46338b24ad7d5f74

		
	}



?>