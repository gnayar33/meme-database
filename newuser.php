#!/usr/local/bin/php
<?PHP
/*
	ob_clean();
	$username = ($_GET['username']);
	$password = ($_GET['password']);
	$email = ($_GET['email']);
	$phone = ($_GET['phone']);
*/
/*
	$conn  = pg_connect('user=njiang host=postgres dbname=db password=asdfasdf');

	if (!$conn) { 
		echo "ConError";
		exit;
	}
	$query = sprintf("select * from users where username = '" . $username .  "'");
	$result = pg_query($conn, $query);

	if (!$result) {
		echo "QueryError";
		exit;
	}

	
	if (pg_fetch_all($result) == false) {
		//$query = sprintf("insert into users values (DEFAULT, '" + $username + "','" + $password +  "','" + $email + "','" + $phone + "')");
		echo($query);
		
		exit;
	} else {
		echo "EXISTS";
		exit;
	}
	
	*/
?>