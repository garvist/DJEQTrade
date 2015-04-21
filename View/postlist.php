<?php

require_once 'View/View.php'; //defines the View class

class PostListView extends View
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
		return ["/Static/main.css", "/Static/postlist.css"]; //return an array containing the string "/Static/main.css" and "/Static/postlist.css"
	}
	
	/** Outputs this view's HTML */
	public function outputHTML()
	{
		echo "<div class=\"page\">";
		echo "<div class =\"page-title\">";
		echo "	<h1>Posts by others</h1>";
		echo "</div>";
		
		foreach( $this->db->getAllPosts() as $post )
		{
			echo "	<div class=\"ad\">";
			echo "	<h1 class=\"ad-title\">{$post['title']}</h1>";
			echo "	<div class=\"ad-meta\">";
			echo "		<span>Categories: unknown</span>";
			echo "		<span>Tags: unknown</span>";
			echo "	</div>";
			echo "	";
			echo "	<p class=\"ad-description\">";
			echo "	{$post['message']}";
			echo "	</p>";
			echo "	";
			echo "	<p>Image URL: {$post['image_url']}</p>";
			echo "	<p>From Customer Id: {$post['from_customer_id']}</p>";
			echo "	</div>";
		}
		
		/*
		echo "	<div class=\"ad\">";
		echo "		<h1 class=\"ad-title\">Jimbo's Amazing Speakers</h1>";
		echo "		<div class=\"ad-meta\">";
		echo "			<span>Categories: speakers</span>";
		echo "			<span>Tags: tags-r-fun, high-range</span>";
		echo "		</div>";
		echo "		";
		echo "		<p class=\"ad-description\">";
		echo "			I'm selling my old speakers. Message me with offers. This is such a funny little post. -Karl approves.";
		echo "		</p>";
		echo "		";
		echo "		<img class=\"ad-image\" src=\"/blownspeakers.jpg\" />";
		echo "		";
		echo "		<span class=\"ad-byline\">Posted by DJ Jimbo on Apr 2 @ 4:30pm</span>";
		echo "	</div>";
		echo "	";
		echo "	<div class=\"ad\">";
		echo "		<h1 class=\"ad-title\">Jimbo's Amazing, Wonderful, loud, big, noisy, adjectives Subwoofers</h1>";
		echo "		<div class=\"ad-meta\">";
		echo "			<span class=\"ad-author\">Posted by DJ Jimbo</span>";
		echo "			<span>Categories: speakers</span>";
		echo "			<span>Tags: tags-r-fun, high-range</span>";
		echo "		</div>";
		echo "		";
		echo "		<p class=\"ad-description\">";
		echo "			Check out my awesome subwoofers! Message me with offers.";
		echo "		</p>";
		echo "		";
		echo "		<img class=\"ad-image\" src=\"/blownspeakers.jpg\" />";
		echo "		";
		echo "		<span class=\"ad-byline\">Posted by DJ Jimbo on Apr 2 @ 4:37pm</span>";
		echo "	</div>";
		*/
		echo "</div>";
	}
}

?>