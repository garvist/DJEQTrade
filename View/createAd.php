<?php

require_once 'View/View.php'; //defines the View class

class CreateAdView extends View
{
	/** Returns an array of CSS files that this view needs */
	public function requiredCSS()
	{
		//update css
		return ["/Static/main.css", "/Static/createad.css"];
	}
	
	/** Outputs this view's HTML */
	public function outputHTML()
	{
		//$searchterm = ( isset($_GET['s']) ? $_GET['s'] : '' );
		
		echo "<div class=\"page\">";
		echo "	<div class=\"createAd\">";
		echo "		<h1 class=\"createAd-title\">Create Ad</h1>";
		echo "  </div>";
		echo "	<body><p>This page creates an ad. Insert a form here that connects to the database.</p></body>";
		echo "</div>";
	}
}

?>