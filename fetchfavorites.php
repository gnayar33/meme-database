#!/usr/local/bin/php
<?php
	session_start();
	$loggedUser = $_SESSION["userName"];
	ob_clean();
	$username = $_GET['username'];
		
	$conn = pg_connect('user=njiang host=postgres dbname=db password=asdfasdf');

	$query = sprintf("select image, uploadtime, caption, users.username from memes, users, likes
	 where users.username = '$loggedUser' and users.userid=likes.userid and likes.mid = memes.mid");

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
			$temp = '/cise/homes/njiang/public_html/images/tmpe' . $i . '.jpg';
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

			if (pg_fetch_all($result3) == false) {
				$likeLink = 'newLike(&quot;' . $username . '&quot;,&quot;' . 
					$loggedUser . '&quot;,&quot;' . $oid . '&quot;, true)';

				echo '<table style="background:white; width:75%; border-width: thin">
				<tr><td width = 5%></td><td align = "middle" width = 65%>
				<b><font size = 16>' . $arr['caption'] . '</font></b><br>'
				. '<a href = "javascript:loadProfile(&quot;' 
				. $arr['username'] . '&quot;);dispTab(&quot;tab5&quot;);">' 
				. $arr['username'] . '</a>' . '<br>				
				<IMG SRC=showimage.php?index=e' . $i . '> <br>
				</td><td align = "middle" width = 20%><button id = c' . $oid . ' type = "button" onclick="' . $likeLink . '">Like</button> 
				<div id = ' . $oid . '>' . $likes . " like(s)"
				. '</div><br>' . substr($arr['uploadtime'], 0, 19) . '</td><td width = 10%></tr></tr></table><br><br>';
			} else {
				$likeLink = 'newLike(&quot;' . $username . '&quot;,&quot;' . 
					$loggedUser . '&quot;,&quot;' . $oid . '&quot;, false)';
				echo '<table style="background:white; width:75%; border-width: thin">
				<tr><td width = 5%></td><td align = "middle" width = 65%>
				<b><font size = 16>' . $arr['caption'] . '</font></b><br>'
				. '<a href = "javascript:loadProfile(&quot;' 
				. $arr['username'] . '&quot;);dispTab(&quot;tab5&quot;);">' 
				. $arr['username'] . '</a>' . '<br>				
				<IMG SRC=showimage.php?index=e' . $i . '> <br>
				</td><td align = "middle" width = 20%><button id = c' . $oid . ' type = "button" onclick="' . $likeLink . '">Unlike</button> 
				<div id = ' . $oid . '>' . $likes . " like(s)"
				. '</div><br>' . substr($arr['uploadtime'], 0, 19) . '</td><td width = 10%></tr></tr></table><br><br>';
			}
			
		}
	
		pg_close($conn);
		
	}


?>