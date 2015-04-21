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
		echo "	<div class =\"page-title\">";
		echo "		<h1>Login</h1>";
		echo "	</div>";
		echo "	<div class=\"form\">";
		echo "		<form action=\"/\" method='post' id=\"login\">";
		echo "			<input type='text' name='c' value='post an ad' style='display: none' />";
		echo "			Email:<br>";
		echo "			<textarea rows=\"1\" cols=\"50\" name=\"userEmail\" form=\"login\"></textarea><br>";
		echo "			Password:<br>";
		echo "			<textarea rows=\"1\" cols=\"50\" name=\"userPassword\" form=\"login\"></textarea><br>";
		echo "			<input type=\"submit\" value=\"Login\">";
		echo "			<p>If you click \"Submit\", the form-data will be sent to a page called \"action_page.php\". This is what W3 told me to do. -Karl</p>";
		echo "		</form>";
		echo "	</div>";
		echo "</div>";





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