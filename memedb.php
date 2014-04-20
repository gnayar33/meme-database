#!/usr/local/bin/php
<?php
session_start();
if (!isset($_SESSION["userName"])){
	header("Location: login.html");
}
?>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>%TITLE%</title>

	<link href="css/bootstrap.min.css" rel="stylesheet">

	<link href="css/bootstrap-theme.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</head>

<body onload="init()">
	<div class="navbar navbar-inverse navbar-fixed-top " role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">MemeDB</a>
			</div>
			<div class="navbar-collapse collapse">
				<ul id = "tabs" class="nav navbar-nav">
					<li><a href="#tab1">News Feed</a></li>
					<li><a href="#tab2">Browse</a></li>
					<li><a href="#tab3">Upload</a></li>
					<li><a href="#tab4">Search</a></li>
					<li><a href="#tab5">Profile</a></li>
					<li><a href="#tab6">Favorites</a></li>
					

				</ul>
				<ul class = "nav navbar-nav">
					<li><a href ="login.html">Log Out</a></li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div>


	<div align = "right"><a href ="login.html">Log Out</a> </div>

	<div class="container">
		<div class="tabContent" id="tab1">
			<div id="newsFeed" align = "center">


			</div>

		</div>

		<div class="tabContent" id="tab2">
			<table width = 100% height = 90%>
				<tr>

					<td width = "15%" align = "right"> <a href = "javascript:trendLeft();">Previous</a></td>
					<td width = "70%" height = 100%>
						<div id = "trendDiv" align = "center"> </div>
					</td>
					<td width = "15%" align = "left"> <a href = "javascript:trendRight();">Next</a></td>
				</tr>
			</table>
		</div>

		<div class="tabContent" id="tab3">


			<form enctype="multipart/form-data" action="image.php" method="POST">

				<input type="hidden" name="MAX_FILE_SIZE" value="300000" />
				Caption : <input type="text" name="name" size="25" length="25" value="">
				<br>
				<input type="hidden" name="MAX_FILE_SIZE" value="300000" />
				File: <input name="userfile" type="file" size="25"/>
				<br>
				<input type="submit" value="Upload" />
			</form>
		</div>
		<div class="tabContent" id="tab4">

			
			<div class = "form-group">
				<form name = "myform" action = "" method = "GET">
					<input type = "text" class = "form-control" name = "name" placeholder ="Search" maxlength="10"><br>
					
					<input type = "button" class = "btn btn-default" value = "Submit" onClick = "redirectToProfile(this.form)" >
				</form>
			</div>
			<div align = "center" id = "resultsTable">
				<div id = "resultsTable">

				</div>
			</div>


		</div>

		<div class="tabContent" id="tab5">
			<table width = 100% height = 90%>
				<tr>
					<td width = "85%" height = 100%>
						<iframe id = "profFrame" width = "95%" height = "95%"></iframe>
					</td>
					<td align = "center">
						<div id = "userLink"> </div><br><br>
						Your Friends: <br><br>
						<div id = "followerTable">

						</div>
					</td>
				</tr>
			</table>
		</div>
		<div class="tabContent" id="tab6">
			<div id="favorites" align = "center">


			</div>

		</div>
	</div>

	<?php 
	$buffer=ob_get_contents();
	ob_end_clean();
	$buffer=str_replace("%TITLE%","Welcome, " . $_SESSION['userName'],$buffer);
	echo $buffer;
	?>
</body>

<script type = "text/javascript">
	var userName;
	var tabLinks = new Array();
	var contentDivs = new Array();
	var currentIndex = 1;

	function init() {
		userName = "<?php echo $_SESSION['userName']; ?>";
		initTabs();
		loadNewsFeed();
		loadFollowers();
		loadProfile(userName);
		loadTrending(currentIndex);
		loadFavorites();
	}

	function loadProfile(newProfile) {
		document.getElementById('profFrame').src = "profile.php?username=" + newProfile;
	}

	function newLike(username, loggeduser, image, notLiked) {
		
		if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp4=new XMLHttpRequest();
			} else {
				// code for IE6, IE5
				xmlhttp4=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp4.onreadystatechange=function() {
				if (xmlhttp4.readyState==4 && xmlhttp4.status==200) {
					document.getElementById(image).innerHTML = xmlhttp4.responseText + " like(s)";
					if (notLiked) {
						document.getElementById("c" + image).innerHTML = "Unlike";
						document.getElementById("c" + image).onclick = function() {
							newLike(username, loggeduser, image, false);
						}
					} else {
						document.getElementById("c" + image).innerHTML = "Like";
						document.getElementById("c" + image).onclick = function() {
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

		function loadNewsFeed() {
			
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
					document.getElementById("newsFeed").innerHTML = xmlhttp.responseText;
				}
			}

			xmlhttp.open("GET","fetchnewsfeed.php?username=" + userName,true);
			xmlhttp.send();

		}

		function loadFavorites() {
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
					document.getElementById("favorites").innerHTML = xmlhttp5.responseText;
				}
			}

			xmlhttp5.open("GET","fetchfavorites.php?username=" + userName,true);
			xmlhttp5.send();
		}

		function loadFollowers() {
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
					document.getElementById("followerTable").innerHTML = xmlhttp2.responseText;
				}
			}
			
			xmlhttp2.open("GET","followers.php?username=" + userName,true);
			xmlhttp2.send();

			document.getElementById("userLink").innerHTML = 
			'<a href = "javascript:loadProfile(&quot;' + userName + '&quot;);">Your Profile</a>'
		}

		function initTabs() {
			// Grab the tab links and content divs from the page
			var tabListItems = document.getElementById('tabs').childNodes;
			for ( var i = 0; i < tabListItems.length; i++ ) {
				if ( tabListItems[i].nodeName == "LI" ) {
					var tabLink = getFirstChildWithTagName( tabListItems[i], 'A' );
					var id = getHash( tabLink.getAttribute('href') );
					tabLinks[id] = tabLink;
					contentDivs[id] = document.getElementById( id );
				}
			}
			// Assign onclick events to the tab links, and
			// highlight the first tab
			var i = 0;
			for ( var id in tabLinks ) {
				tabLinks[id].onclick = showTab;
				tabLinks[id].onfocus = function() { this.blur() };
				if ( i == 0 ) tabLinks[id].className = 'selected';
				i++;
			}

			// Hide all content divs except the first
			var i = 0;
			for ( var id in contentDivs ) {
				if ( i != 0 ) contentDivs[id].className = 'tabContent hide';
				i++;
			}
		}

		function showTab() {
			var selectedId = getHash( this.getAttribute('href') );
			// Highlight the selected tab, and dim all others.
			// Also show the selected content div, and hide all others.
			for ( var id in contentDivs ) {
				if ( id == selectedId ) {
					tabLinks[id].className = 'selected';
					contentDivs[id].className = 'tabContent';
				} else {
					tabLinks[id].className = '';
					contentDivs[id].className = 'tabContent hide';
				}
			}

		// Stop the browser following the link
		return false;
	}

	function dispTab(selectedId) {

			// Highlight the selected tab, and dim all others.
			// Also show the selected content div, and hide all others.
			for ( var id in contentDivs ) {
				if ( id == selectedId ) {
					tabLinks[id].className = 'selected';
					contentDivs[id].className = 'tabContent';
				} else {
					tabLinks[id].className = '';
					contentDivs[id].className = 'tabContent hide';
				}
			}

		// Stop the browser following the link
		return false;
	}

	function getFirstChildWithTagName( element, tagName ) {
		for ( var i = 0; i < element.childNodes.length; i++ ) {
			if ( element.childNodes[i].nodeName == tagName ) return element.childNodes[i];
		}
	}

	function getHash( url ) {
		var hashPos = url.lastIndexOf ( '#' );
		return url.substring( hashPos + 1 );
	}

	function redirectToProfile(form) {
		var search = form.name.value;

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
					document.getElementById("resultsTable").innerHTML = xmlhttp3.responseText;
				}
			}
			
			xmlhttp3.open("GET","search.php?search=" + search,true);
			xmlhttp3.send();
		}

		function loadTrending(selectedIndex) {
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
					if (xmlhttp3.responseText == "NOIMAGE") {
						if (currentIndex == 0) {
							currentIndex += 1;
							loadTrending(currentIndex);
						} else {
							currentIndex -= 1;
							loadTrending(currentIndex);
						}
					} else {
						document.getElementById("trendDiv").innerHTML = xmlhttp3.responseText;
					}
				}
			}
			
			xmlhttp3.open("GET","fetchtrending.php?index=" + selectedIndex,true);
			xmlhttp3.send();
		}

		function trendRight() {
			currentIndex += 1;
			loadTrending(currentIndex);
		}

		function trendLeft() {
			currentIndex -= 1;
			loadTrending(currentIndex);
		}
	</script>
	</html>
