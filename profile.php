#!/usr/local/bin/php
<html>
	<head>
		<title>%TITLE%</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>%TITLE%</title>

		<link href="http://bootswatch.com/slate/bootstrap.min.css" rel="stylesheet">
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="style.css">
		<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</head>

	<body onload = "init()">
		<table align = "center" height = 100% width = 100%>
			<tr>
				<td width = 40% align = "center"> <div class = "jumbotron" id="profPic"> </div> </td></tr><tr>
				<td width = 40% align = "center"> 
					<div id = "username"> </div> <br> 
					<div id = "profile"> </div> <br><p>
					<div id = "following"> </div></p>
				</td>
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
						document.getElementById(image).innerHTML = xmlhttp4.responseText + " like(s)";
						if (notLiked) {
							document.getElementById("b" + image).innerHTML = "Unlike";
							document.getElementById("b" + image).onclick = function() {
								newLike(username, loggeduser, image, false);
							}
							document.getElementById("b" + image).className = "btn btn-failure";
						} else {
							document.getElementById("b" + image).innerHTML = "Like";
							document.getElementById("b" + image).onclick = function() {
								newLike(username, loggeduser, image, true);
							}
							document.getElementById("b" + image).className = "btn btn-success";
						}
					}
					parent.loadFavorites();
				}
		
				var userName = "<?php echo ($_GET['username']); ?>";
				xmlhttp4.open("GET","newLike.php?username=" + loggeduser + "&image=" + image 
						+ "&owner=" + username + "&notLiked=" + notLiked,true);
				xmlhttp4.send();
			}

			function follow(username, follower, isfollowed) {
				if (window.XMLHttpRequest) {
					// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp5=new XMLHttpRequest();
				}
				else {
					// code for IE6, IE5
					xmlhttp5=new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp5.onreadystatechange=function() {
					if (xmlhttp5.readyState==4 && xmlhttp5.status==200) {
						if (isfollowed) {
							document.getElementById("follow").innerHTML = "Follow";
							document.getElementById("follow").onclick = function() {
								follow(username, follower, false);
							}
							document.getElementById("follow").className = "btn btn-success";
						} else {
							document.getElementById("follow").innerHTML = "Unfollow";
							document.getElementById("follow").onclick = function() {
								follow(username, follower, true);
							}
							document.getElementById("follow").className = "btn btn-warning";
						}
						parent.loadFollowers();
						parent.loadNewsFeed();
					}
				}
				xmlhttp5.open("GET","newFollow.php?username=" + username + "&follower=" + follower + 
						"&isFollowed=" + isfollowed,true);
				xmlhttp5.send();
			}
		
		</script>

	</body>


</html>
