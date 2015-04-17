<?php

require_once 'View/View.php'; //defines the View class

class NavigationView extends View
{
	/** Returns an array of CSS files that this view needs */
	public function requiredCSS()
	{
		return ["/Static/main.css", "/Static/nav.css"]; //return an array containing the string "/Static/main.css"
	}
	
	/** Outputs this view's HTML */
	public function outputHTML()
	{
		echo "<div class=\"header\">";
		echo "	<ul class=\"nav\">";
		echo "		<!-- logo -->";
		echo "		<li class=\"logo\">";
		echo "			<span class=\"logo-dj\">DJ</span><!--";
		echo "			--><span class=\"logo-eq\">eq</span><!--";
		echo "			--><span class=\"logo-x\">X</span>";
		echo "		</li>";
		echo "";
		echo "		<!-- nav options -->";
		echo "		<li>Logout</li>";
		echo "		<li>Messages</li>";
		echo "		<li>Post an ad</li>";
		echo "		<li>View ads</li>";
		echo "	</ul>";
		echo "	<form>";
		echo "		<input type=\"text\" placeholder=\"search\" name=\"search\" />";
		echo "	</form>";
		echo "</div>";
	}
}

?>