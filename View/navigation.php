<?php

require_once 'View/View.php'; //defines the View class

class NavigationView extends View
{
	/** Returns an array of CSS files that this view needs */
	public function requiredCSS()
	{
		return ["/Static/main.css", "/Static/nav.css"]; //return an array containing the string "/Static/main.css"
	}
	
	/** Returns an array of JavaScript files that this view needs */
	public function requiredJS()
	{
		return ["http://code.jquery.com/jquery-1.11.2.min.js"];
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
		echo "	<script>";
		echo "		$('form').submit( function(event) {";
		echo "			var searchtext = $('form input[name=search]').val();";
		echo "			window.location = '/?c=search&s=' +searchtext; //redirect to the search page";
		echo "			event.preventDefault(); //prevent the browser from submitting the form";
		echo "		});";
		echo "  </script>";
		echo "</div>";
	}
}

?>