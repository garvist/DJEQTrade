<?php

require_once 'View/View.php'; //defines the View class

class MyAdsListView extends View
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
		echo "	<h1>My Ads</h1>";
		
		foreach( $this->db->getAllPostsForUser( $this->db->getLoggedInId() ) as $post )
		{
			//convert the tags from an array to a string
			$tags = "";
			foreach( $post['tags'] as $t )
				$tags = $tags . $t . ", ";
			
			echo "	<div class=\"ad\">";
			echo "	<h1 class=\"ad-title\">{$post['title']}</h1>";
			echo "	<div class=\"ad-meta\">";
			echo "		<span>Tags: {$tags}</span>";
			echo "	</div>";
			echo "	";
			echo "	<p class=\"ad-description\">";
			echo "	{$post['message']}";
			echo "	</p>";
			echo "	";
			echo "	<img src=\"{$post['image_url']}\" width=\"150\" />";
			echo "	<span class=\"ad-byline\">Posted by {$post['first_name']} {$post['last_name']}</span>";
			echo "	</div>";
		}
		/*
		echo " 	<p>Here you will find a list of your ads generated from the sql database.</p>";
		echo "<div class=\"page\">";
		echo "	<div class=\"ad\">";
		echo "		<h1 class=\"ad-title\">My Amazing Speakers</h1>";
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
		echo "		<h1 class=\"ad-title\">My's Amazing, Wonderful, loud, big, noisy, adjectives Subwoofers</h1>";
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
		echo "</div>";
		*/
	}
}

?>