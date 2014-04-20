#!/usr/local/bin/php
<?PHP
	ob_clean();
	session_start();
	$comment = ($_GET['comment']);
	$loggedUser = $_SESSION["userName"];
	$mid = ($_GET['mid']);
	$conn  = pg_connect('user=njiang host=postgres dbname=db password=asdfasdf');

	if (!$conn) { 
		// echo "ConError";
		exit;
	}
	$query = sprintf("select userid from users where username = '$loggedUser'");
	// echo $query;
	$result = pg_query($conn, $query);
	$userid = pg_fetch_row($result, 0);
	//echo $userid[0];

	$query = sprintf("insert into comments(userid,comment,mid) values ($userid[0],'$comment',$mid)");
	// echo $query;
	$result = pg_query($conn, $query);





	$query2 = sprintf("select username,comment from comments,users where comments.mid = '" . $mid . "'  and comments.userid = users.userid");
	// echo $query2;
	$result2 = pg_query($conn, $query2);
		if (!$result2) {
		//echo "No results";
		exit;
	}

	echo '<table id="comments" class="table table-striped table-bordered table-condensed table-hover">';
	while($row = pg_fetch_row($result2)){
		echo '<tr>';
		echo '<td  class = "searchtd">' . $row[0] . '</td><td  class = "searchtd">' . $row[1] . '</td>'; 
		echo '</tr>';
	}
	echo '</table>';
	pg_close($conn);
	die();
?>
