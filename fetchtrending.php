#!/usr/local/bin/php
<?php			
	$selectedIndex = $_GET['index'];
	$conn = pg_connect('user=njiang host=postgres dbname=db password=asdfasdf');

	$query = sprintf("select row_number() over (order by sum(trendscore) desc), caption, 
				d.mid, sum(trendscore) as s, username, image from (select *, 1/(2^ 
				(extract(epoch from age(current_timestamp,time))/100000)) as trendScore from likes) d, 
				memes, users where d.mid = memes.mid and users.userid = ownerid 
				group by d.mid, image, caption, username order by s desc");
			
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



	echo '<a href = "javascript:loadProfile(&quot;' 
				. $arr['username'] . '&quot;);dispTab(&quot;tab5&quot;);">' 
				. $arr['username'] . '</a>';
	echo "<br>";
	echo '<IMG SRC=showimage.php?index=t><br>';
	echo "<b>" . $arr['caption'] . "</b><br>";
	echo '(Rank ' . $selectedIndex . ')<br>';
	

?>
