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
		echo "		<p class=\"description\">Click on a friend to visit their profile. You can message your friends to ask more specific questions about the items they are advertising. You can also exchange contact information. If you both agree on a trade, you can rate the user based on your experience.</p>";
		echo "		<ul class=\"friends-list\">";
		
		foreach( $this->db->getFriendsForUser( $this->db->getLoggedInId() ) as $friend )
		{
			$profileUrl = '/?c=profile&id=' .$friend['customer_id'];
			echo "			<li>";
			echo "<a href=\"{$profileUrl}\">{$friend['first_name']} {$friend['last_name']}</a>";
			echo " (<a href=\"/?c=send message&id={$friend['customer_id']}\">Send a message</a>)";
			echo "</li>";
		}
		
		// to be removed 
		echo "			<!-- list of friends -->";
		echo "			<li>Adam Sandler</li>";
		echo "			<li>Brad pitt</li>";
		echo "			<li>Emma Watson</li>";
		echo "			<li>Emil Gilles</li>";
		echo "			<li>Karl Preisner</li>";
		echo "			<li>Maurice Andre</li>";
		echo "			<li>Orlando Bloom</li>";
		echo "			<li>Karl Preisner</li>";
		echo "			<li>Warren Smith</li>";
		echo "			<li>Zachary Frankfort</li>";
		//remove above


		echo "		</ul>";
		echo "  </div>";
		echo "</div>";
	}
}

?>