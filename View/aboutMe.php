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
		return ["/Static/main.css"]; //return an array containing the string "/Static/main.css" and "/Static/postlist.css"
	}
	
	/** Outputs this view's HTML */
	public function outputHTML()
	{
		echo "<h1>About Me</h1>";
		echo "<h3>First Name: </h3>";
		echo "<p>draw info from db</p>";
		echo "<h3>Last Name: </h3>";
		echo "<p>draw info from db</p>";
		echo "<h3>Image: </h3>";
		echo "<p>draw info from db</p>";
		echo "<h3>Location: </h3>";
		echo "<p>draw info from db</p>";
		echo "<h3>My Rating: </h3>";
		echo "<p>draw info from db</p>";
		echo "<h3>Number of Friends: </h3>";
		echo "<p>draw info from db</p>";
		echo "<h3>Number of Posts: </h3>";
		echo "<p>draw info from db</p>";
	}
}

?>