#!/usr/local/bin/php
<?PHP
	ob_clean();
	$search = ($_GET['search']);

	$conn  = pg_connect('user=njiang host=postgres dbname=db password=asdfasdf');

	if (!$conn) { 
		echo "ConError";
		exit;
	}

	$query = sprintf("select * from users where username like '%%$search%%'");
	$result = pg_query($conn, $query);

	if (!$result) {
		echo "No results";
		exit;
	}
	echo '<table style="width:100%" border="1"><tr><th  class = "searchth">Result</th><th  class = "searchth">Value</th></tr>';
	while($row = pg_fetch_row($result)){
		echo '<tr>';
		echo '<td  class = "searchtd">Profile:</td><td  class = "searchtd"> <a href = \'javascript:loadProfile("' . $row[1] . '");dispTab("tab5");\'>' . $row[1] . '</a></td>'; 
		//echo "Name: " . $row[1] . "<br /n>";
		echo '</tr>';
	}

	$query = sprintf("select * from users where email like '%%$search%%'");
	$result = pg_query($conn, $query);
	while($row = pg_fetch_row($result)){
		echo '<tr>';
		echo '<td class = "searchtd">Email:</td><td  class = "searchtd"> <a href = \'javascript:loadProfile("' . $row[1] . '");dispTab("tab5");\'>' . $row[2] . '</a></td>'; 
		//echo "Name: " . $row[1] . "<br /n>";
		echo '</tr>';
	}
	$query = sprintf("select * from getRank where caption like '%%$search%%'");
	$result = pg_query($conn, $query);
	while($row = pg_fetch_row($result)){
		echo '<tr>';
		echo '<td class = "searchtd">Meme :</td><td  class = "searchtd"> <a href = \'javascript:loadTrending("' . $row[0] . '");dispTab("tab2");\'>' . $row[1] . '</a></td>'; 
		//echo "Name: " . $row[1] . "<br /n>";
		echo '</tr>';
	}
	echo '</table>';
?>
