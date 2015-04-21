<?php

require_once 'View/View.php'; //defines the View class

class AboutMeView extends View
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
		return ["/Static/main.css, /Static/aboutMe.css"]; //return an array containing the string "/Static/main.css" and "/Static/postlist.css"
	}
	
	/** Outputs this view's HTML */
	public function outputHTML()
	{
		echo "<div class=\"aboutPage\">";
		echo "	<h1 class=\"title\">About Me</h1>";
		echo "	<div class=\"contents\">";
		echo "		<h3>First Name: </h3>";
		echo "		<p>draw info from db</p>";
		echo "		<h3>Last Name: </h3>";
		echo "		<p>draw info from db</p>";
		echo "		<h3>Email:</h3>";
		echo "		<p>draw infro from db</p>";
		echo "		<h3>My Rating: </h3>";
		echo "		<p>draw info from db</p>";
		echo "		<h3>Number of Friends: </h3>";
		echo "		<p>draw info from db</p>";
		echo "		<h3>Number of Posts: </h3>";
		echo "		<p>draw info from db</p>";
		echo "	</div>";
		echo "</div>";
	}
}

?>