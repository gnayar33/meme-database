#!/usr/local/bin/php
<?php
	session_start();
	$loggedUser = $_SESSION["userName"];
	ob_clean();
	$username = $_GET['username'];
		
	$conn = pg_connect('user=njiang host=postgres dbname=db password=asdfasdf');

	$query = sprintf("select image, uploadtime, caption from memes, users where userid = ownerid
				and username = '$username' order by uploadtime desc");

	$result = pg_query($conn, $query);

	if (!$result) {
		echo "QueryError";
		exit;
	}

	if (pg_fetch_all($result) == false) {
		echo "NOTFOUND";
		exit;
	} else {

		for ($i = 0; $i < count(pg_fetch_all($result)) - 1; $i++) {
			$arr = pg_fetch_array($result, $i, PGSQL_ASSOC);
			$oid = $arr['image'];
			$temp = '/cise/homes/njiang/public_html/images/tmpc' . $i . '.jpg';
			pg_query($conn, "begin");
			pg_lo_export($conn, $oid, $temp); 
			pg_query($conn, "commit");


			$query2 = sprintf("select image, count(*) from likes, memes where likes.mid = 
						memes.mid and image = '" . $arr['image'] . "' group by image");

			$result2 = pg_query($conn, $query2);


			if (pg_fetch_all($result2) == false) {
				$likes = 0;
			} else {
				$arr2 = pg_fetch_array($result2, 0, PGSQL_ASSOC);
				$likes = $arr2['count'];
			}

			echo '<b><font size = 16>' . $arr['caption'] . '</font></b><br>' 
			. $arr['uploadtime'] . '<br>
			<IMG SRC=showimage.php?index=c' . $i . '> <br>
			<a href = "newLike.php?username=' . $loggedUser . '&image=' . $oid . '&owner=' . $username . '"> Like: </a> ' . $likes
			. '<br><br>';

		}
	
		pg_close($conn);
		
	}


?>