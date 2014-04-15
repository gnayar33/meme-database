#!/usr/local/bin/php
<?php

?>

<html>
	<head>
		<title>%TITLE%</title>
	</head>

	<body onload = "init()">
		<table border = "1" align = "center" height = 100% width = 100%>
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
		
		</script>

	</body>


</html>