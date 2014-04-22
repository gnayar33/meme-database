#!/usr/local/bin/php
<?php
	ob_clean();
	session_start();
	$loggedUser = $_SESSION['userName'];
	$username = $_GET['username'];
		
	$conn = pg_connect('user=njiang host=postgres dbname=db password=asdfasdf');

	$query = sprintf("select profpic from users where username = '$username'");
	$result = pg_query($conn, $query);

	if (!$result) {
		echo "QueryError";
		exit;
	}

	if (pg_fetch_all($result) == false) {
		echo "NOTFOUND";
		exit;
	} else {
		$arr = pg_fetch_array ($result, 0, PGSQL_ASSOC);
		$oid = $arr['profpic'];
		$temp = '/cise/homes/njiang/public_html/images/tmpb' . $loggedUser . '1.jpg';
		pg_query($conn, "begin");
		$result = pg_lo_export($conn, $oid, $temp); 
		pg_query($conn, "commit");
	
		pg_close($conn);
		echo '<IMG class="prof img-rounded img-responsive" SRC=showimage.php?index=b' . $loggedUser . '1>';
	}


?>
