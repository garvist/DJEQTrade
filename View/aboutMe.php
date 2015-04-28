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
		return ["/Static/main.css","/Static/aboutMe.css"]; //return an array containing the string "/Static/main.css" and "/Static/postlist.css"
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
		echo "		<h3>Email:</h3>";
		echo "		<p>{$customer['email']}</p>";
		//echo "		<h3>User Rating: </h3>";
		//echo "		<p>draw info from db</p>";
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
			}
		}
		echo "";
		echo "	</div>";
		echo "</div>";
	}
}

?>