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
		echo "	<div class =\"page-title\">";
		echo "		<h1>Create an Ad</h1>";
		echo "	</div>";
		echo "	<body><p>This page creates an ad. Insert a form here that connects to the database.</p></body>";
		echo "	<div class=\"form\">";
		echo "		<form action=\"/\" method='post' id=\"creatAdForm\">";
		echo "			<input type='text' name='c' value='post an ad' style='display: none' />";
		echo "			Title:             <input type=\"text\" name=\"postTitle\"><br>";
		echo "			tags (for search): <input type=\"text\" name=\"postTags\"><br>";
		echo "			Image url:         <input type\"text\" name=\"postImage\"><br>";
		echo "			Description:<br>";
		echo "			<input type=\"text\" name=\"postDescription\"><br>";
		echo "			<input type=\"submit\" value=\"Submit your ad\">";
		echo "			<p>If you click \"Submit\", the form-data will be sent to a page called \"action_page.php\". This is what W3 told me to do. -Karl</p>";
		echo "		</form>";
		echo "	</div>";
		echo "</div>";
	}
}

?>