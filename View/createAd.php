<?php

require_once 'View/View.php'; //defines the View class

class CreateAdView extends View
{
	/** Parent constructor for all views.
	 * Parameters:
	 * 	$db -> the connection to the database
	 */
	public function __construct($db)
	{
		parent::__construct($db);
	}
	
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
		echo "<div class =\"page-title\">";
		echo "	<h1>Create an Ad</h1>";
		echo "</div>";
		echo "	<body><p>This page creates an ad. Insert a form here that connects to the database.</p></body>";
		echo "</div>";
	}
}

?>