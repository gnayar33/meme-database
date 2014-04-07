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
	$query = sprintf("select password from users where username = '" . $username .  "'");
	$result = pg_query($conn, $query);

	if (!$result) {
		echo "QueryError";
		exit;
	}

	$arr = pg_fetch_array ($result, 0, PGSQL_ASSOC);
	if ($arr['password'] == $password)
		echo "TRUE";
	else
		echo "FALSE";

?>