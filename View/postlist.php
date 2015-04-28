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
		echo "	<h1>All Advertisements</h1>";
		echo "</div>";
		echo "<div class=\"post-list\">";
		foreach( $this->db->getAllPosts() as $post )
		{
			$profileUrl = '/?c=profile&id=' .$post['customer_id'];
			//convert the tags from an array to a string
			$tags = "";
			if( count($post['tags']) > 0 )
			{
				foreach( $post['tags'] as $t )
					$tags = $tags . $t . ", ";
				
				$tags = substr($tags, 0, strlen($tags)-2);
			}
			
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

			if( $this->db->isloggedIn() ){
				echo "	<span class=\"ad-byline\">Posted by <a href=\"{$profileUrl}\">{$post['first_name']} {$post['last_name']}</a></span>";
				
				//delete post - admin and user's own post
				if( $this->db->getCustomerById( $this->db->getLoggedInId() )['administrator'] || $post['customer_id'] == $this->db->getLoggedInId() ) //if this is the user's post, or they are an administrator, show the "Delete Post" button
				{
					echo "<form action='/' method='post'>";
					echo "<input type=\"hidden\" name=\"c\" value=\"remove ad\">";
					echo "<input type=\"hidden\" name=\"postId\" value=\"{$post['post_id']}\">";
					echo "<input type=\"submit\" value=\"Delete Post!\">";
					echo "</form>";
				}

				//write comment
				if ( $post['customer_id'] != $this->db->getLoggedInId() ) {
					echo "<form action=\"/\" method='post' id=\"comment\">";
					echo "  <input type='hidden' name='c' value='add comment' />";
					echo "  <input type='hidden' name='post_id' value='{$post['post_id']}' />";
					echo "	Write a Comment: <br><textarea name='message' form='comment'></textarea>";
					echo "	<br><input type=\"submit\" value=\"Post Comment\">";
					echo "</form>";
				}
			}
			else {
				echo "	<span class=\"ad-byline\">Posted by {$post['first_name']} {$post['last_name']}</span>";
			}

			if(count($this->db->getAllPostComments($post['post_id'])) > 0){
				echo "<hr>";
				echo"<h3>Comments:</h3>";
				echo "<hr>";
			}
			
				foreach( $this->db->getAllPostComments($post['post_id']) as $comment){

					echo "<div class=\"comment\">";
					echo "	<h4>Author: {$comment['first_name']} {$comment['last_name']}</h4>";
					echo "	<p>Date Written: {$comment['date_written']}<br>{$comment['comment_text']}</p>";
					echo "<hr>";
					echo "</div>";
				}

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
		echo "</div>";
	}
}

?>