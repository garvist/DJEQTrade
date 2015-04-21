<?php

require_once 'View/View.php'; //defines the View class

class FriendsListView extends View
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
		return ["/Static/main.css", "/Static/friendslist.css"];
	}
	
	/** Outputs this view's HTML */
	public function outputHTML()
	{
		//$searchterm = ( isset($_GET['s']) ? $_GET['s'] : '' );
		
		echo "<div class=\"page\">";
		echo "<h1>Friends List</h1>";
		echo "	<div class=\"friends-list\">";
		echo "		<p class=\"description\">Run sql code to generate list of friends. Print them out here. Each friend is a link. Click on the link to take them to their profile. Change the search bar so it searches through your friends list.</p>";
		echo "		<ul class=\"friends-list\">";
		
		foreach( $this->db->getFriendsForUser( $this->db->getLoggedInId() ) as $friend )
		{
			$profileUrl = '/?c=profile&id=' +$friend['customer_id'];
			echo "			<li><a href=\"{$profileUrl}\">{$friend['first_name']} {$friend['last_name']}</a></li>";
		}
		
		/*
		echo "			<!-- list of friends -->";
		echo "			<li><a href=\"/?c=post an ad\">Adam Sandler (currently ink to \"post an ad\")</a></li>"; //link to a general friends page, yet to be created.
		echo "			<li>Brad pitt</li>";
		echo "			<li>Emma Watson</li>";
		echo "			<li>Emil Gilles</li>";
		echo "			<li>Karl Preisner</li>";
		echo "			<li>Maurice Andre</li>";
		echo "			<li>Orlando Bloom</li>";
		echo "			<li>Karl Preisner</li>";
		echo "			<li>Warren Smith</li>";
		echo "			<li>Zachary Frankfort</li>";
		*/
		echo "		</ul>";
		echo "  </div>";
		echo "</div>";
	}
}

?>