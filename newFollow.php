#!/usr/local/bin/php
<?PHP
	$username = $_GET['username'];
	$follower = $_GET['follower'];
	$isFollowed = $_GET['isFollowed'];

	$conn = pg_connect("dbname=db host=postgres user=njiang password=asdfasdf");
	$query = sprintf("select userid from users where username = '$follower'");

	$result1 = pg_query($conn, $query);

	$query = sprintf("select userid from users where username = '$username'");
	$result2 = pg_query($conn, $query);

	$arr1 = pg_fetch_row($result1, 0);
	$arr2 = pg_fetch_row($result2, 0);

	$fid = $arr1[0];
	$uid = $arr2[0];

	if ($isFollowed == 'false') {
		$query = sprintf("insert into follower values ( '$fid', '$uid', default)");
		$result = pg_query($conn, $query);
	} else {
		$query = sprintf("delete from follower where userid = '$uid' and fid = '$fid'");
		$result = pg_query($conn, $query);
	}

	pg_close($conn);
	die();

?>