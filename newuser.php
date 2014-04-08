#!/usr/local/bin/php
<?PHP

	ob_clean();
	$username = ($_GET['username']);
	$password = ($_GET['password']);
	$email = ($_GET['email']);
	$phone = $_GET['phone'];

	$conn  = pg_connect('user=njiang host=postgres dbname=db password=asdfasdf');

	if (!$conn) { 
		echo "ConError";
		exit;
	}
<<<<<<< HEAD
	$query = sprintf("select * from users where username = '$username'");
=======
	$query = sprintf("select * from users where username = '" . $username .  "'");
>>>>>>> a17684fa33b4971abd68cd8a3906c7c89b79f40f
	$result = pg_query($conn, $query);

	if (!$result) {
		echo "QueryError";
		exit;
	}

	
	if (pg_fetch_all($result) == false) {
<<<<<<< HEAD
		$query = sprintf("insert into users values (DEFAULT, '$username','$email','$password','$phone')");
=======
		$query = sprintf("insert into users values (DEFAULT, '" . $username . "','"  . $email . "','" .  $password . "','" . $phone . "')");
>>>>>>> a17684fa33b4971abd68cd8a3906c7c89b79f40f

		$result = pg_query($conn, $query);
		if (!$result) {
			echo "QueryError";
			exit;
		}

		echo "SUCCESS";
		exit;
	} else {
		echo "EXISTS";
		exit;
	}
	

?>