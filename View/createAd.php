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
		echo "		<h1>Create an Advertisement</h1>";
		echo "	</div>";
		echo "	<div class=\"form\">";
		echo "		<form action=\"/\" method='post' id=\"createAdForm\" enctype='multipart/form-data'>";
		echo "			<input type='text' name='c' value='create ad' style='display: none' />";
		echo "			Title:<br><input type=\"text\" name=\"postTitle\"><br>";
		echo "			tags (for search): <br><input type=\"text\" name=\"postTags\"><br>";
		echo "			Image url:<br><input type\"text\" name=\"postImage\"><br>";
		echo "			<input type='hidden' name='MAX_FILE_SIZE' value='2097152' />";
		echo "			Image: <br><input type='file' name='postImageData' />";
		echo "			<br>Description:<br>";
		echo "			<textarea rows=\"6\" cols=\"50\" name=\"postDescription\" form=\"createAdForm\">Enter text here...</textarea><br>";
		echo "			<input type=\"submit\" value=\"Submit advertisement\">";
		echo "		</form>";
		echo "	</div>";
		echo "</div>";
	}
}

?>