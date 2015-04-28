<?php

require_once 'View/View.php'; //defines the View class

class AboutMeView extends View
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
		return ["/Static/main.css","/Static/aboutMe.css", "/Static/reviewlist.css"]; //return an array containing the string "/Static/main.css" and "/Static/postlist.css"
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
		$friendCount = count( $this->db->getFriendsForUser( $customer_id ) );
		$postCount = count( $this->db->getAllPostsForUser( $customer_id ) );
		
		//display profile
		echo "<div class=\"aboutPage\">";
		echo "	<h1 class=\"title\">{$customer['first_name']} {$customer['last_name']}</h1>";
		echo "	<div class=\"contents\">";
		if ( $customer_id != $this->db->getLoggedInId() ) {
			echo " (<a href=\"/?c=send message&id={$customer_id}\">Send a message</a>)";
		}
		echo "		<h3>Email:</h3>";
		echo "		<p>{$customer['email']}</p>";
		echo "		<h3>User Rating: </h3>";
		
		$reviewCount = count($this->db->getReviewsForUser( $customer_id ));
		
		echo "		<p>{$this->db->getUserRating( $customer_id )} ({$reviewCount} reviews)</p>";
		echo "		<h3>Number of Friends: </h3>";
		echo "		<p>{$friendCount}</p>";
		echo "		<h3>Number of Posts: </h3>";
		echo "		<p>{$postCount}</p>";
		if( $this->db->getLoggedInId() != $customer['customer_id'] ){
			echo "		<h3>Relationship:</h3>";
			if($this->db->isFriend($customer['customer_id']) == false){
		echo "	<form action=/ method=post>";
		echo "		<input type = hidden name=c value=createFriend />";
		echo "		<input type = hidden name=friend_id value= {$customer['customer_id']} />";
		echo "		<input type=\"submit\" value=\"add Friend\" />";	
		echo "	</from>";
			}else{
				echo "	<p>Your Friend</p>";
				echo "<h3>Their Friends</h3>";
				foreach( $this->db->getFriendsForUser( $customer['customer_id'] ) as $friend )
				{
					$profileUrl = '/?c=profile&id=' .$friend['customer_id'];
					echo "			<li>";
					echo "<a href=\"{$profileUrl}\">{$friend['first_name']} {$friend['last_name']}</a>";
					//echo " (<a href=\"/?c=send message&id={$friend['customer_id']}\">Send a message</a>)";
					echo "</li>";
				}
			}
		}
		echo "";
		echo "	</div>";
		
		echo "<div class =\"review-title\">";
		echo "	<h1>All Reviews</h1>";
		echo "</div>";
		echo "<div class=\"review-list\">";

		//write review
		if ( $customer_id != $this->db->getLoggedInId() ) {
			echo "<form action=\"/\" method='post' id=\"review\">";
			echo "  <input type='hidden' name='c' value='create review' />";
			echo "  <input type='hidden' name='target_id' value='{$customer_id}' />";
			echo "	Write a Review for this User: <br><textarea name='message' form='comment'></textarea>";
			echo "	<br>Rating (0-5):<br><input type=\"text\" name=\"rating\">";
			echo "	<br><input type=\"submit\" value=\"Post Review\">";
			echo "</form>";
		}

		foreach( $this->db->getReviewsForUser( $customer_id ) as $review )
		{
			/*
			$review = [ "author_customer_id" => $author_customer_id, "author_first_name" => $author_first_name, "author_last_name" => $author_last_name,
						"target_customer_id" => $target_customer_id, "target_first_name" => $target_first_name, "target_last_name" => $target_last_name,
						"review_text" => $review_text, "score" => $score ];
			*/
						
			echo "	<div class=\"review\">";
			echo "	<h3 class=\"review-title\">Rating: {$review['score']}</h3>";
			echo "	";
			echo "	<p class=\"review-description\">";
			echo "	{$review['review_text']}";
			echo "	</p>";
			echo "	";
			echo "	<span class=\"review-byline\">Review written by {$review['author_first_name']} {$review['author_last_name']}</span>";
			echo "  </div>";
		}
		
		echo "</div>";
		
		echo "</div>";
	}
}

?>