#!/usr/local/bin/php
<?php
	ob_clean();
	$username = $_GET['username'];
		
	$conn = pg_connect('user=njiang host=postgres dbname=db password=asdfasdf');

	$query = sprintf("select * from users where username = '$username'");
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
		$email = $arr['email'];
		$phone = $arr['phone'];
	
		pg_close($conn);
		echo $email . "<br>" . $phone;
	}


?>