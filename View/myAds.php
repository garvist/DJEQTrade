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
		//what customer ID should we display posts for?
		$customer_id = $this->db->getLoggedInId();
		if( isset($_GET['id']) )
			$customer_id = $_GET['id'];

		$customer = $this->db->getCustomerById( $customer_id );
		
		//display ads
		echo "<div class=\"page\">";
		echo "	<h1>{$customer['first_name']}'s Advertisements</h1>";
		echo "<div class=\"post-list\">";
		foreach( $this->db->getAllPostsForUser( $customer_id ) as $post )
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
			
			if( $this->db->getCustomerById( $this->db->getLoggedInId() )['administrator'] || $post['customer_id'] == $this->db->getLoggedInId() ) //if this is the user's post, or they are an administrator, show the "Delete Post" button
				echo "<button type=\"button\" onclick=\"alert('Make this function work properly')\">Delete Post!</button>";
			
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
		echo "</div>";
		echo "</div>";
	}
}

?>