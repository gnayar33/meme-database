#!/usr/local/bin/php
<?php
	session_start();
	$_SESSION['userName'] = ($_GET['username']);
?>

<html>
	<head>
		<title>%TITLE%</title>

		<style type="text/css">
			body { font-size: 80%; font-family: 'Lucida Grande', Verdana, Arial, Sans-Serif; }
			ul#tabs { list-style-type: none; margin: 30px 0 0 0; padding: 0 0 0.3em 0; }
			ul#tabs li { display: inline; }
			ul#tabs li a { color: #42454a; background-color: #dedbde; border: 1px solid #c9c3ba; border-bottom: none; padding: 0.3em; text-decoration: none; }
			ul#tabs li a:hover { background-color: #f1f0ee; }
			ul#tabs li a.selected { color: #000; background-color: #f1f0ee; font-weight: bold; padding: 0.7em 0.3em 0.38em 0.3em; }
			div.tabContent { border: 1px solid #c9c3ba; padding: 0.5em; background-color: #f1f0ee; }
			div.tabContent.hide { display: none; }
		</style>
	</head>

	<body onload="init()">

		<div id="profLink"> </div>
		<ul id="tabs">
			<li><a href="#tab1">News Feed</a></li>
			<li><a href="#tab2">Trending</a></li>
			<li><a href="#tab3">Upload</a></li>
			<li><a href="#tab4">Search</a></li>
			<li><a href="#tab5">Profile</a></li>
		</ul>
 
		<div class="tabContent" id="tab1">
			<select id = "picCount">
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
			</select>
			<div id="newsFeed">


			</div>

		</div>
 
		<div class="tabContent" id="tab2">

		</div>

		<div class="tabContent" id="tab3">


			<form enctype="multipart/form-data" action="image.php" method="POST">

				<input type="hidden" name="MAX_FILE_SIZE" value="300000" />
				Name : <input type="text" name="name" size="25" length="25" value="">
				<br>
				<input type="hidden" name="MAX_FILE_SIZE" value="300000" />
				File: <input name="userfile" type="file" size="25"/>

				<input type="submit" value="Upload" />
			</form>
		</div>
		<div class="tabContent" id="tab4">
			

		</div>

		<div class="tabContent" id="tab5">
			<table border = 1 width = 100% height = 70%>
				<tr>
					<td width = "75%">
						<iframe id = "profFrame" width = "100%" height = "100%"></iframe>0
					</td>
					<td>
						Friends: <br><br>
						<div id = "followerTable">

						</div>
					</td>
				</tr>
			</table>
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
 
		function init() {
			userName = "<?php echo $_SESSION['userName']; ?>";
	 		initTabs();
			loadNewsFeed();
			loadFollowers();
			loadProfile(userName);
		}

		function loadProfile(newProfile) {
			document.getElementById('profFrame').src = "profile.php?username=" + newProfile;
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

			xmlhttp.open("GET","fetchimage.php?count=2",true);
			xmlhttp.send();

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
	</script>
</html>