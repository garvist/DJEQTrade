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
		echo "	<div class=\"friend\">";
		echo "		<h1 class=\"friend-title\">Friends List</h1>";
		echo "  </div>";
		echo "	<body><p>This is a description of your friend.</p></body>"
		echo "</div>";
	}
}

?>