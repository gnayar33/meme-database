#!/usr/local/bin/php
<?php

	$uploaddir = '/cise/homes/njiang/public_html/images/';
	$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
	$name = $_POST['name'];

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

	
	$query = sprintf("insert into memes values (default, '$name', 'tag', '$oid')");
	$result = pg_query($conn, $query);
	//echo "insert into memes values (default, '$name', '', '$oid')" . "<br>";

	if($result) {
		echo "File is valid, and was successfully uploaded.\n";
		unlink($uploadfile);
	} else {
		echo "Filename already exists. Use another filename. Enter all the values.";
		unlink($uploadfile);
	}
	
	pg_close($conn);
	header("Location: memedb.php");
	die();
?>