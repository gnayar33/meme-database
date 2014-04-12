#!/usr/local/bin/php
<?PHP
	ob_clean();
	$username = ($_GET['username']);

	$conn  = pg_connect('user=njiang host=postgres dbname=db password=asdfasdf');

	if (!$conn) { 
		echo "ConError";
		exit;
	}


	$query = sprintf("select * from followerNames where followername = '$username'");
	$result = pg_query($conn, $query);

	if (!$result) {
		echo "QueryError";
		exit;
	}

	if (pg_fetch_all($result) == false) {
		echo "NOFOLLOWS";
		exit;
	} else {
		foreach (pg_fetch_all($result) as $rows) {
			echo '<a href = \'javascript:loadProfile("' . $rows['username'] . '");\'>' . $rows['username'] . '</a><br>'; 
		}
	}
?>