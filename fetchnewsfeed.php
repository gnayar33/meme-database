#!/usr/local/bin/php
<?php
	session_start();
	$loggedUser = $_SESSION["userName"];
	ob_clean();
	$username = $_GET['username'];
		
	$conn = pg_connect('user=njiang host=postgres dbname=db password=asdfasdf');

	$query = sprintf("select image, uploadtime, caption, users.username from memes, users, followernames where userid = ownerid
				and followername = '$loggedUser' and users.username = followernames.username order by uploadtime desc");

	$result = pg_query($conn, $query);

	if (!$result) {
		echo "QueryError";
		exit;
	}

	if (pg_fetch_all($result) == false) {
		echo "No images found";
		exit;
	} else {
		echo "<br>";
		for ($i = 0; $i < count(pg_fetch_all($result)); $i++) {
			$arr = pg_fetch_array($result, $i, PGSQL_ASSOC);
			$oid = $arr['image'];
			$temp = '/cise/homes/njiang/public_html/images/tmpd' . $loggedUser . $i . '.jpg';
			pg_query($conn, "begin");
			pg_lo_export($conn, $oid, $temp); 
			pg_query($conn, "commit");


			$query2 = sprintf("select image, count(*) from likes, memes where likes.mid = 
						memes.mid and image = '" . $arr['image'] . "' group by image");

			$result2 = pg_query($conn, $query2);

			$query3 = sprintf("select * from likes, users, memes
					where likes.userid = users.userid
					and memes.mid = likes.mid
					and username = '" . $loggedUser . "' and image = '" . $oid . "'");
			$result3 = pg_query($conn, $query3);


			if (pg_fetch_all($result2) == false) {
				$likes = 0;
			} else {
				$arr2 = pg_fetch_array($result2, 0, PGSQL_ASSOC);
				$likes = $arr2['count'];
			}

			echo '<div class="jumbotron">';
			echo '<h2>' . $arr['caption'] . '</h2><h4>';
			echo '<a href = "javascript:loadProfile(&quot;' 
				. $arr['username'] . '&quot;);dispTab(&quot;tab5&quot;);">' 
				. $arr['username'] . '</a>' . '</h4>';			
			echo '<div align = "center"><p><IMG class="img-rounded img-responsive" SRC=showimage.php?index=d' . $loggedUser . $i . '> </p></div>';
			
			echo '<div align="center"><div class="left">';
			if (pg_fetch_all($result3) == false) {
				$likeLink = 'newLike(&quot;' . 
					$loggedUser . '&quot;,&quot;' . $oid . '&quot;, true, &quot;feed&quot;)';
				echo '<button id = c' . $oid . ' class="btn btn-success" type = "button" onclick="' . $likeLink . '">Like</button>';
			} else {
				$likeLink = 'newLike(&quot;' . 
					$loggedUser . '&quot;,&quot;' . $oid . '&quot;, false, &quot;feed&quot;)';
				echo '<button id = c' . $oid . ' class="btn btn-danger" type = "button" onclick="' . $likeLink . '">Unlike</button>';
			}

			echo '</div><div class="right"><div id = ' . $oid . '>' . $likes . " like(s)" . '</div>';
			echo  substr($arr['uploadtime'], 0, 19) . '</div>';
			echo '</div></div>';
			
		}
	
		pg_close($conn);
		
	}


?>