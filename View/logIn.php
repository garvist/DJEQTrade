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
		echo "<div class=\"welcome\">";
		echo "	<h1>Welcome to DJ Equipment Trade!</h1>";
		echo "	<p>About the website</p>";
		echo "</div>";
		echo "	<div class =\"page-title\">";
		echo "		<h1>Login</h1>";
		echo "	</div>";
		echo "	<div class=\"form\">";
		echo "		<form action=\"/\" method='post' id=\"login\">";
		echo "			<input type='text' name='c' value='log in' style='display: none' />";
		echo "			Email:<br><input type=\"text\" name=\"userEmail\"><br>";
		echo "			Password:<br><input type=\"password\" name=\"userPassword\"><br>";
		echo "			<input type=\"submit\" value=\"Login\">";
		echo "		</form>";
		echo "	</div>";
		echo "</div>";
	}
}

?>