#!/usr/local/bin/php
<?php
	session_start();
	$loggedUser = $_SESSION["userName"];			
	$selectedIndex = $_GET['index'];
	$conn = pg_connect('user=njiang host=postgres dbname=db password=asdfasdf');

	$query = sprintf("select * from getrank");
			
	$result = pg_query($conn, $query);
	$arr = pg_fetch_array($result, $selectedIndex - 1, PGSQL_ASSOC);

	if (! $arr || $selectedIndex == 0 ) {
		echo "NOIMAGE";
		exit;
	}

	$temp = '/cise/homes/njiang/public_html/images/tmpt' . $i . '.jpg';
	$oid = $arr['image'];

	pg_query($conn, "begin");
	pg_lo_export($conn, $oid, $temp); 
	pg_query($conn, "commit");

	$query3 = sprintf("select * from likes, users, memes
			where likes.userid = users.userid
			and memes.mid = likes.mid
			and username = '" . $loggedUser . "' and image = '" . $oid . "'");
	$result3 = pg_query($conn, $query3);

	$query2 = sprintf("select image, count(*) from likes, memes where likes.mid = 
			memes.mid and image = '" . $arr['image'] . "' group by image");

	$result2 = pg_query($conn, $query2);

	if (pg_fetch_all($result2) == false) {
		$likes = 0;
	} else {
		$arr2 = pg_fetch_array($result2, 0, PGSQL_ASSOC);
		$likes = $arr2['count'];
	}


	echo '<a href = "javascript:loadProfile(&quot;' 
				. $arr['username'] . '&quot;);dispTab(&quot;tab5&quot;);">' 
				. $arr['username'] . '</a>';
	echo "<br>";
	echo '<IMG SRC=showimage.php?index=t><br>';
	echo "<b>" . $arr['caption'] . "</b><br>";
	echo '(Rank ' . $selectedIndex . ')<br>';
	if (pg_fetch_all($result3) == false) {
		$likeLink = 'newLike(&quot;' . 
		$loggedUser . '&quot;,&quot;' . $oid . '&quot;, true, &quot;trend&quot;)';
		echo '<button id = t' . $oid . ' type = "button" onclick="' . $likeLink . '">Like</button>';
	} else {
		$likeLink = 'newLike(&quot;' . 
		$loggedUser . '&quot;,&quot;' . $oid . '&quot;, false, &quot;trend&quot;)';

		echo '<button id = t' . $oid . ' type = "button" onclick="' . $likeLink . '">Unlike</button>';
	}

	echo '<div id = tl' . $oid . '>' . $likes . " like(s)". '</div>'

?>
