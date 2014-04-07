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

		<ul id="tabs">
			<li><a href="#tab1">News Feed</a></li>
			<li><a href="#tab2">Trending</a></li>
			<li><a href="#tab3">Following</a></li>
		</ul>
 
		<div class="tabContent" id="tab1">
			<INPUT TYPE = "Text" VALUE ="username" NAME = "username">
		</div>
 
		<div class="tabContent" id="tab2">

		</div>
	 
		<div class="tabContent" id="tab3">

		</div>

		<?php 
			$buffer=ob_get_contents();
			ob_end_clean();
			$buffer=str_replace("%TITLE%","Welcome, " . $_SESSION['userName'],$buffer);
			echo $buffer;
		
			$conn  = pg_connect('user=njiang host=postgres dbname=db password=asdfasdf');
			echo $_SESSION['userName'];
			echo '<br><br><br>';
			if (!$conn) { 
				echo "Connection failed";
				exit;
			}

			$query = sprintf("select * from Users");

			$result = pg_query($conn, $query);

			if (!$result) {
				echo "An error occured.\n";
				exit;
			}

			$thearr = pg_fetch_all($result);

			foreach ($thearr as $tar) {
				foreach ($tar as $ta) {
					echo $ta;
					echo '<br>';
				}

			}

		?>
	</body>

	<script type = "text/javascript">

		var tabLinks = new Array();
		var contentDivs = new Array();
 
		function init() {
	 
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