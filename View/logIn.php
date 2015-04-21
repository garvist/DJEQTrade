<?php

require_once 'View/View.php'; //defines the View class

class LogInView extends View
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
		return ["/Static/main.css", "/Static/logIn.css"];
	}
	
	/** Outputs this view's HTML */
	public function outputHTML()
	{
		//$searchterm = ( isset($_GET['s']) ? $_GET['s'] : '' );
		
		echo "<div class=\"page\">";
		echo "	<div class=\"logIn\">";
		echo "		<h1 class=\"logIn-title\">Log In</h1>";
		echo "  </div>";
		echo "Visible Description:";
		echo "<form method=\"post\" action='/'>";
		echo "	<input type='text' name='c' value='log in' style='display: none' />";
		echo "	<input type=\"text\" name=\"email\" size=\"20\">";
		echo "	<input type=\"password\" name=\"password\" />";
		echo "	<input type=\"submit\" value=\"Log In\" />";
		echo "</form>";
		echo "</div>";
	}
}

?>