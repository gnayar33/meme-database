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

	<link href="http://bootswatch.com/slate/bootstrap.min.css" rel="stylesheet">
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	
</head>

<body onload="init()">
	<div class="navbar navbar-fixed-top " role="navigation">
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

	<div class="container">
		<div class="tabContent" id="tab1">
			<div id="newsFeed">


			</div>

		</div>

		<div class="tabContent" id="tab2">

					<div class = "row">
					<div class = "col-md-1" align="left" align-vertical=><a href = "javascript:trendLeft();"><i class="fa fa-angle-left fa-5x"></i></a></div>
					<div id = "trendDiv" align = "center" class = "col-md-9"> </div>
					<div class = "col-md-1" align = "right"><a href = "javascript:trendRight();"><i class="fa fa-angle-right fa-5x"></i></a></div>
					</div>

		</div>

		<div class="tabContent" id="tab3">


		<div class = "form-horizontal">
			<form enctype="multipart/form-data" action="image.php" method="POST">

				<input type="hidden"  name="MAX_FILE_SIZE" value="300000" />
				<input type="text"class="form-control"  placeholder ="Caption" name="name" size="25" length="25" value="">
				<br>
				<input type="hidden" name="MAX_FILE_SIZE" value="300000" />
				<input name="userfile" placeholder ="File" type="file" size="25"/>
				<br>
				<label>
				<input name="prof" type="checkbox" value ="set"> Set As Profile Picture
				</label>
				<div>
				<input type="submit" class = "btn btn-default" value = "Submit" />
				</div>
			</form>
			</div>
		</div>
		<div class="tabContent" id="tab4">

			
			<div class = "form-group">
				<form name = "myform">
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
				<div class = "row">
					
					<div class ="col-md-11"><iframe id = "profFrame" width = "100%" height = "100%"></iframe></div>
					
					<div class = "col-md-1">
						<div id = "userLink"> </div><br><br>
						Your Friends: <br><br>
						<div id = "followerTable"></div>
					</div>
				</div>
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

	function newLike(loggeduser, image, notLiked, source) {
		
			if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp4=new XMLHttpRequest();
			} else {
				// code for IE6, IE5
				xmlhttp4=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp4.onreadystatechange=function() {
				if (xmlhttp4.readyState==4 && xmlhttp4.status==200) {
					if (source == "trend") {
						document.getElementById("tl" + image).innerHTML = xmlhttp4.responseText + " like(s)";
					} else if (source == "fav") {
						document.getElementById("fl" + image).innerHTML = xmlhttp4.responseText + " like(s)";
					} else {
						document.getElementById(image).innerHTML = xmlhttp4.responseText + " like(s)";
					}
					if (notLiked) {
						if (source == "trend") {
							document.getElementById("t" + image).innerHTML = "Unlike";
							document.getElementById("t" + image).onclick = function() {
								newLike(loggeduser, image, false, "trend");
							}
							document.getElementById("t" + image).className = "btn btn-danger";

						} else if (source == "fav") {
							document.getElementById("f" + image).innerHTML = "Unlike";
							document.getElementById("f" + image).onclick = function() {
								newLike(loggeduser, image, false, "fav");
							}
							document.getElementById("f" + image).className = "btn btn-danger";
						} else {
							document.getElementById("c" + image).innerHTML = "Unlike";
							document.getElementById("c" + image).onclick = function() {
								newLike(loggeduser, image, false, "feed");
							}
							document.getElementById("c" + image).className = "btn btn-danger";
						}
					} else {
						if (source == "trend") {
							document.getElementById("t" + image).innerHTML = "Like";
							document.getElementById("t" + image).onclick = function() {
								newLike(loggeduser, image, true, "trend");
							}
							document.getElementById("t" + image).className = "btn btn-success";
						} else if (source == "fav") { 
							document.getElementById("f" + image).innerHTML = "Like";
							document.getElementById("f" + image).onclick = function() {
								newLike(loggeduser, image, true, "fav");
							}
							document.getElementById("f" + image).className = "btn btn-success";
						} else {
							document.getElementById("c" + image).innerHTML = "Like";
							document.getElementById("c" + image).onclick = function() {
								newLike(loggeduser, image, true, "feed");
							}
							document.getElementById("c" + image).className = "btn btn-success";
						}
					}
				}
				loadFavorites();
				
			}
		
			var userName = "<?php echo ($_GET['username']); ?>";
			xmlhttp4.open("GET","newLike.php?username=" + loggeduser + "&image=" + image 
					+ "&notLiked=" + notLiked,true);
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
		// return false;
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
	function searchkey(e, form) {
		if (e.keyCode == 13) {
			redirectToProfile(form);
		}
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

		function addComment(form, mid) {
		var comment = form.name.value;

		if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp7=new XMLHttpRequest();
			}
			else {
				// code for IE6, IE5
				xmlhttp7=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp7.onreadystatechange=function() {
				if (xmlhttp7.readyState==4 && xmlhttp7.status==200) {
					document.getElementById("comments").innerHTML = xmlhttp7.responseText;
				}
			}
			
			xmlhttp7.open("GET","addcomment.php?comment=" + comment+"&mid="+mid,true);
			xmlhttp7.send();
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
