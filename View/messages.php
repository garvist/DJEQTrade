<?php

require_once 'View/View.php'; //defines the View class

class MessagesView extends View
{
	/** Returns an array of CSS files that this view needs */
	public function requiredCSS()
	{
		//update css
		return ["/Static/main.css", "/Static/messages.css"];
	}
	
	/** Outputs this view's HTML */
	public function outputHTML()
	{
		//$searchterm = ( isset($_GET['s']) ? $_GET['s'] : '' );
		
		echo "<div class=\"page\">";
		echo "	<div class=\"messages\">";
		echo "		<h1 class=\"messages-title\">Messages</h1>";
		echo "  </div>";
		echo "	<body><p>This page holds your messages.</p></body>";
		echo "</div>";
	}
}

?>