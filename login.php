#!/usr/local/bin/php
<?PHP
	ob_clean();
	$username = ($_GET['username']);
	$password = ($_GET['password']);

	$conn  = pg_connect('user=njiang host=postgres dbname=db password=asdfasdf');

	if (!$conn) { 
		echo "ConError";
		exit;
	}
	$query = sprintf("select password from users where username = '$username'");
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
		if ($arr['password'] == $password)
			echo "VALID";
		else
			echo "INVALID";	
	}
?>