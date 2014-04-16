#!/usr/local/bin/php
<<<<<<< HEAD
<html>
	<head>
		<title>%TITLE%</title>

		<style>
			table, td, th {
				border-width:3px; 
				border-style:groove;
				border-color:#75A3FF;
				background-color:white;
			}
		</style>
	</head>

	<body onload = "init()">
		<table align = "center" height = 100% width = 100%>
=======
<?php

?>

<html>
	<head>
		<title>%TITLE%</title>
	</head>

	<body onload = "init()">
		<table border = "1" align = "center" height = 100% width = 100%>
>>>>>>> eea4b616e4ad96a463a96ac03dd75fe69fb26f10
			<tr>
				<td width = 50% align = "center"> <div id="profPic"> </div> </td>
				<td width = 30% align = "center"> <div id="username"> </div> <br> <div id = "profile"> </div> </td>
			</tr>
			<tr>
				<td colspan = 2 align= "center"><div id = "imageFeed"></div></td>
			</tr>
		</table>
		
		

		<script type = "text/javascript">
			function init() {
				var userName = "<?php echo ($_GET['username']); ?>";
				getPicture();
				getProfile();
				getFeed();
				document.getElementById("username").innerHTML = "<b><font size = 10>" + userName + "</font></b>";

			}

			function getPicture() {
				if (window.XMLHttpRequest) {
					// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();
				}
				else {
					// code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange=function() {
					if (xmlhttp.readyState==4 && xmlhttp.status==200) {
						document.getElementById("profPic").innerHTML = xmlhttp.responseText;
					}
				}
		
				var userName = "<?php echo ($_GET['username']); ?>";
				xmlhttp.open("GET","fetchprofpic.php?username=" + userName,true);
				xmlhttp.send();

			}

			function getProfile() {
				if (window.XMLHttpRequest) {
					// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp2=new XMLHttpRequest();
				}
				else {
					// code for IE6, IE5
					xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp2.onreadystatechange=function() {
					if (xmlhttp2.readyState==4 && xmlhttp2.status==200) {
						document.getElementById("profile").innerHTML = xmlhttp2.responseText;
					}
				}
		
				var userName = "<?php echo ($_GET['username']); ?>";
				xmlhttp2.open("GET","fetchprof.php?username=" + userName,true);
				xmlhttp2.send();


			}

			function getFeed() {

				if (window.XMLHttpRequest) {
					// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp3=new XMLHttpRequest();
				}
				else {
					// code for IE6, IE5
					xmlhttp3=new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp3.onreadystatechange=function() {
					if (xmlhttp3.readyState==4 && xmlhttp3.status==200) {
						document.getElementById("imageFeed").innerHTML = xmlhttp3.responseText;
					}
				}
		
				var userName = "<?php echo ($_GET['username']); ?>";
				xmlhttp3.open("GET","fetchproffeed.php?username=" + userName,true);
				xmlhttp3.send();

			}
<<<<<<< HEAD

			function newLike(username, loggeduser, image, notLiked) {
		
				if (window.XMLHttpRequest) {
					// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp4=new XMLHttpRequest();
				}
				else {
					// code for IE6, IE5
					xmlhttp4=new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp4.onreadystatechange=function() {
					if (xmlhttp4.readyState==4 && xmlhttp4.status==200) {
						document.getElementById(image).innerHTML = xmlhttp4.responseText;
						if (notLiked) {
							document.getElementById("b" + image).innerHTML = "Unlike";
							document.getElementById("b" + image).onclick = function() {
								newLike(username, loggeduser, image, false);
							}

						} else {
							document.getElementById("b" + image).innerHTML = "Like";
							document.getElementById("b" + image).onclick = function() {
								newLike(username, loggeduser, image, true);
							}
						}
					}
				}
		
				var userName = "<?php echo ($_GET['username']); ?>";
				xmlhttp4.open("GET","newLike.php?username=" + loggeduser + "&image=" + image 
						+ "&owner=" + username + "&notLiked=" + notLiked,true);
				xmlhttp4.send();
				
			}
=======
>>>>>>> eea4b616e4ad96a463a96ac03dd75fe69fb26f10
		
		</script>

	</body>


</html>