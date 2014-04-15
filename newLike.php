#!/usr/local/bin/php
<?PHP
	$username = $_GET['username'];
	$image = $_GET['image'];
	$owner = $_GET['owner'];

	$conn = pg_connect("dbname=db host=postgres user=njiang password=asdfasdf");
	$query = sprintf("select mid from memes where image = '$image'");

	$result1 = pg_query($conn, $query);

	$query = sprintf("select userid from users where username = '$username'");
	$result2 = pg_query($conn, $query);

	$arr1 = pg_fetch_row($result1, 0);
	$arr2 = pg_fetch_row($result2, 0);

	$mid = $arr1[0];
	$uid = $arr2[0];

	$query = sprintf("insert into likes values ( '$uid', '$mid', default)");
	$result = pg_query($conn, $query);
	
	if ($result) 
		echo "SUCCESS";
	else
		echo "FAILURE";

	pg_close($conn);
	header("Location: profile.php?username=$owner");
	die();

?>