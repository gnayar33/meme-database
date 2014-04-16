#!/usr/local/bin/php
<?PHP
	$username = $_GET['username'];
	$image = $_GET['image'];
	$owner = $_GET['owner'];
<<<<<<< HEAD
	$notLiked = $_GET['notLiked'];
=======
>>>>>>> eea4b616e4ad96a463a96ac03dd75fe69fb26f10

	$conn = pg_connect("dbname=db host=postgres user=njiang password=asdfasdf");
	$query = sprintf("select mid from memes where image = '$image'");

	$result1 = pg_query($conn, $query);

	$query = sprintf("select userid from users where username = '$username'");
	$result2 = pg_query($conn, $query);

	$arr1 = pg_fetch_row($result1, 0);
	$arr2 = pg_fetch_row($result2, 0);

	$mid = $arr1[0];
	$uid = $arr2[0];

<<<<<<< HEAD
	if ($notLiked == 'true') {
		$query = sprintf("insert into likes values ( '$uid', '$mid', default)");
		$result = pg_query($conn, $query);
	} else {
		$query = sprintf("delete from likes where userid = '$uid' and mid = '$mid'");
		$result = pg_query($conn, $query);
	}

	$query3 = sprintf("select image, count(*) from likes, memes where likes.mid = 
			memes.mid and image = '" . $image . "' group by image");

	$result3 = pg_query($conn, $query3);

	if (pg_fetch_all($result3) == false) {
		$likes = 0;
	} else {
		$arr3 = pg_fetch_array($result3, 0, PGSQL_ASSOC);
		$likes = $arr3['count'];
	}

	echo $likes;

	pg_close($conn);
=======
	$query = sprintf("insert into likes values ( '$uid', '$mid', default)");
	$result = pg_query($conn, $query);
	
	if ($result) 
		echo "SUCCESS";
	else
		echo "FAILURE";

	pg_close($conn);
	header("Location: profile.php?username=$owner");
>>>>>>> eea4b616e4ad96a463a96ac03dd75fe69fb26f10
	die();

?>