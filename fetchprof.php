#!/usr/local/bin/php
<?php
	session_start();
	ob_clean();
	$username = $_GET['username'];
	$loggedUser = $_SESSION["userName"];
		
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
		$query2 = sprintf("select * from followernames where followername = '$loggedUser' and username = '$username'");
		$result2 = pg_query($conn, $query2);
			
		$arr = pg_fetch_array ($result, 0, PGSQL_ASSOC);
		$email = $arr['email'];
		$phone = $arr['phone'];
		echo $email . "<br>" . $phone . "<br>";
		if ($loggedUser == $username) {

		} else if (pg_fetch_all($result2) == false) {
			$followLink = 'follow(&quot;' . $username . '&quot;,&quot;' . 
				$loggedUser . '&quot;, false)';
			echo '<button id = "follow" onclick = "' . $followLink . '">Follow</button>';
		} else {
			$followLink = 'follow(&quot;' . $username . '&quot;,&quot;' . 
				$loggedUser . '&quot;, true)';
			echo '<button id = "follow" onclick = "' . $followLink . '">Unfollow</button>';
		}
		pg_close($conn);
		
	}
?>