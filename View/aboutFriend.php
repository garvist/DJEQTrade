<?php

require_once 'View/View.php'; //defines the View class

class AboutFriendView extends View
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
		return ["/Static/main.css","/Static/aboutFriend.css"]; //return an array containing the string "/Static/main.css" and "/Static/postlist.css"
	}
	
	/** Outputs this view's HTML */
	public function outputHTML()
	{
		/* >>>>>>>>>>>>>>>>>>>IMPLEMENT THIS<<<<<<<<<<<<<<<<<<<<<<<<<
		//what customer ID should we display information for?
		$customer_id = $this->db->getLoggedInId(); //change to friend's id
		if( isset($_GET['id']) )
			$customer_id = $_GET['id'];
		
		//get info
		$customer = $this->db->getCustomerById( $customer_id );
		$friendCount = count( $this->db->getFriendsForUser( $customer_id ) );
		$postCount = count( $this->db->getAllPostsForUser( $customer_id ) );
		*/

		//display profile
		echo "<div class=\"aboutPage\">";
		//echo "	<h1 class=\"title\">{$customer['first_name']} {$customer['last_name']}</h1>";
		echo "	<h1 class=\"title\">[Friend's name]</h1>"; //remove this when above is implemented
		echo "	<div class=\"contents\">";
		echo "		<h3>Email:</h3>";
		//echo "		<p>{$customer['email']}</p>";add when implemented
		echo "		<p>draw info from db</p>";//remove when above is implemented
		echo "		<h3>User Rating: </h3>";
		echo "		<p>draw info from db</p>";//remove when above is implemented
		echo "		<h3>Number of Friends: </h3>";
		//echo "		<p>{$friendCount}</p>";
		echo "		<p>draw info from db</p>";//remove when above is implemented
		echo "		<h3>Number of Posts: </h3>";
		//echo "		<p>{$postCount}</p>";
		echo "		<p>draw info from db</p>";//remove when above is implemented
		echo "	</div>";
		echo "</div>";
	}
}

?>