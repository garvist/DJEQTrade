<?php

require_once 'View/View.php'; //defines the View class

class NavigationView extends View
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

		//what customer ID should we display information for?
		$customer_id = $this->db->getLoggedInId();
		if( isset($_GET['id']) )
			$customer_id = $_GET['id'];
		
		//get info
		$customer = $this->db->getCustomerById( $customer_id );



		echo "<div class=\"header\">";
		echo "	<ul class=\"nav\">";
		echo "		<!-- logo -->";
		echo "		<li class=\"logo\">";
		echo "			<a href=\"/?c=homepage\">";
		echo "			<span class=\"logo-dj\">DJ</span><!--";
		echo "			--><span class=\"logo-eq\">eq</span><!--";
		echo "			--><span class=\"logo-x\">X</span>";
		echo "			</a>";
		echo "		</li>";
		echo "";
		
		if( $this->db->isLoggedIn() )
		{
			echo "		<!-- nav options -->";
			echo "		<li><a href=\"/?c=create ad\">Create Ad</a></li>";
			echo "		<li><a href=\"/?c=profile\">My Profile - {$customer['first_name']} {$customer['last_name']}</a></li>";
			echo "		<li><a href=\"/?c=friends\">Friends</a></li>";
			echo "		<li><a href=\"/?c=messages\">Messages</a></li>";
			echo "		<li><a href=\"/?c=log out\">Logout</a></li>";
			echo "</ul>";
		}
		else
		{
			echo "		<li class=\"login\"><a href=\"/?c=log in\">Login / Create Account</a></li>";
			echo "</ul>";
			echo "		<p>This is a description of the website.</p>";
		}
		/*
		echo "<div class=\"page-description\">";
		echo "	<h3>My Profile (homepage):</h3>";
		echo "	<p>On my profile, you see the ads that you have posted. The search bar searches all ads on the database, including your own. It takes you to the search results page. In the search bar, the prewritten text says \"search for equipment\".<br></p>";
		echo "	<h3>Post an ad:</h3>";
		echo "	<p>This page takes you to a general form where you can post an ad to the database. There is no search bar.</p>";
		echo "	<h3>Browse ads</h3>";
		echo "	<p>This page lists all ads in your area sorted by date. There are checkbox options to refine your general results. You can also type in the search bar to futher refine results.<br></p>";
		echo "	<h3>Friends:</h3>";
		echo "	<p>This page shows all of your friends in alphabetical order. The search bar searches your friends by name.<br></p>";
		echo "	<h3>Messages:</h3>";
		echo "	<p>This page is as similar to facebook messages page as possible. They have it figured out.<br></p>";
		echo "	<h3>Logout:</h3>";
		echo "	<p>This logs you out and brings you to the login screen. The login screen will become the new index.php eventually.</p>";
		echo " </div>";
		*/
		echo "	<form>";
		echo "		<input type=\"text\" placeholder=\"Search for an Advertisement\" name=\"search\" />";
		echo "	</form>";
		echo "	<script>\n";
		echo "		$('form').submit( function(event) {\n";
		echo "			var searchtext = $('form input[name=search]').val();\n";
		echo "			window.location = '/?c=search&s=' +searchtext; //redirect to the search page\n";
		echo "			event.preventDefault(); //prevent the browser from submitting the form\n";
		echo "		});\n";
		echo "  </script>\n";
		echo "</div>";
	}
}

?>