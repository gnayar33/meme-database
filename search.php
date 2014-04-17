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
	while($row = pg_fetch_row($result)){
		echo '<a href = \'javascript:loadProfile("' . $row[1] . '");dispTab("tab5");\'>' . $row[1] . '</a><br /n>'; 
		//echo "Name: " . $row[1] . "<br /n>";
	}
?>
