<?php

require_once 'View/View.php'; //defines the View class

class ReviewListView extends View
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
		return ["/Static/main.css", "/Static/reviewlist.css"]; //return an array containing the string "/Static/main.css" and "/Static/reviewlist.css"
	}
	
	/** Outputs this view's HTML */
	public function outputHTML()
	{
		$customer_id = $this->db->getLoggedInId();
		if( isset($_GET['id']) )
			$customer_id = $_GET['id'];
		
		echo "<div class=\"review-page\">";
		echo "<div class =\"review-title\">";
		echo "	<h1>All Reviews</h1>";
		echo "</div>";
		echo "<div class=\"review-list\">";
		
		foreach( $this->db->getReviewsForUser( $customer_id ) as $review )
		{
			/*
			$review = [ "author_customer_id" => $author_customer_id, "author_first_name" => $author_first_name, "author_last_name" => $author_last_name,
						"target_customer_id" => $target_customer_id, "target_first_name" => $target_first_name, "target_last_name" => $target_last_name,
						"review_text" => $review_text, "score" => $score ];
			*/
						
			echo "	<div class=\"review\">";
			echo "	<h1 class=\"review-title\">Score: {$review['score']}</h1>";
			echo "	";
			echo "	<p class=\"review-description\">";
			echo "	{$review['review_text']}";
			echo "	</p>";
			echo "	";
			echo "	<span class=\"review-byline\">Review written by {$review['author_first_name']} {$review['author_last_name']}</span>";
		}
		
		echo "</div>";
		echo "</div>";
	}
}

?>