#!/usr/local/bin/php
<?php
	session_start();
	$uploaddir = '/cise/homes/njiang/public_html/images/';
	$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
	$name = $_POST['name'];
	$prof = $_POST['prof'];

	if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {   
		// echo "File is valid, and was successfully uploaded.\n";
	} else {   
		echo "File size greater than 300kb!\n\n";
		exit;
	}

	
	$conn = pg_connect("dbname=db host=postgres user=njiang password=asdfasdf");
	pg_query($conn, "begin");
	$oid = pg_lo_import($conn, $uploadfile);
	pg_query($conn, "commit");

	$query = sprintf("select userid from users where username = '" . $_SESSION['userName'] . "'");
	$result = pg_query($conn, $query);
	$arr = pg_fetch_array($result, 0, PGSQL_ASSOC);
	$uid = $arr['userid'];
	
	$query = sprintf("insert into memes values (default, '$name', '$oid', '$uid', default)");
	$result = pg_query($conn, $query);

	if($result) {
		echo "File is valid, and was successfully uploaded.\n";
		unlink($uploadfile);
	} else {
		echo "Filename already exists. Use another filename. Enter all the values.";
		unlink($uploadfile);
	}

	if ($prof == "set") {
		$query = sprintf("update users set profpic = '$oid' where userid = '$uid'");
		$result = pg_query($conn, $query);
	}
	
	pg_close($conn);
	header("Location: memedb.php");
	die();
?>