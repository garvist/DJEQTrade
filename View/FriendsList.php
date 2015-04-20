<?php

require_once 'View/View.php'; //defines the View class

class FriendsListView extends View
{
	/** Returns an array of CSS files that this view needs */
	public function requiredCSS()
	{
		//update css
		return ["/Static/main.css", "/Static/friendslist.css"];
	}
	
	/** Outputs this view's HTML */
	public function outputHTML()
	{
		//$searchterm = ( isset($_GET['s']) ? $_GET['s'] : '' );
		
		echo "<div class=\"page\">";
		echo "<h2>Friends List</h2>";
		echo "	<div class=\"friends-list\">";
		echo "		<p class=\"description\">Run sql code to generate list of friends. Print them out here. Each friend is a link. Click on the link to take them to their profile.</p>";
		echo "		<ul class=\"friends-list\">";
		echo "			<!-- list of friends -->";
		echo "			<li><a href=\"/?c=post an ad\">Adam Sandler (currently has a link to \"post an ad\")</a></li>"; //link to a general friends page, yet to be created.
		echo "			<li>Brad pitt</li>";
		echo "			<li>Emil Gilles</li>";
		echo "		</ul>";
		echo "  </div>";
		echo "</div>";
	}
}

?>