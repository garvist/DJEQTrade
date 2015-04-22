<?php

require_once 'View/View.php'; //defines the View class

class CreateAccountView extends View
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
		echo "		<h1>Create an Account</h1>";
		echo "	</div>";
		echo "	<p>With a free account at DJ Equipment Trade, you can post an advertisement, create a profile, add friends, and message your friends.</p>";
		echo "	<div class=\"form\">";
		echo "		<form action=\"/\" method='post' id=\"createUserForm\">";
		echo "			<input type='text' name='c' value='create account' style='display: none' />";
		echo "			First Name:<br><input type=\"text\" name=\"firstName\"><br>";
		echo "			Last Name: <br><input type=\"text\" name=\"lastName\"><br>";
		echo "			Email:<br><input type=\"text\" name=\"userEmail\"><br>";
		echo "			Password:<br><input type=\"password\" name=\"userPassword\"><br>";
		echo "			<input type=\"submit\" value=\"Create Account\">";
		echo "		</form>";
		echo "	</div>";
		echo "</div>";
	}
}

?>