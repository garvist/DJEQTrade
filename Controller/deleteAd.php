<?php

require_once 'Controller/Controller.php'; //defines Controller class

class DeleteAdController extends Controller
{
	//the constructor for this controller class
	function __construct()
	{
		parent::__construct(); //call our parent constructor -- this will create the database connection that we're going to use
	}
	
	/** Returns an array containing all of the views that this controller uses */
	protected function getViews()
	{
		return [];
	}
	
	public function executeBefore()
	{
		//is the user deleting an ad?
		if( isset($_POST['postId']) ) //yep
		{
			$post_id = $_POST['postId'];
			
			//make sure the user is logged in
			if( !$this->db->isLoggedIn() )
				die("You can only delete posts if you are logged in");
			
			//make sure that the user is an administrator or owns the post
			$customer = $this->db->getCustomerById( $this->db->getLoggedInId() );
			$post = $this->db->getPostById($post_id);
			if( !$customer['administrator'] && $post['customer_id'] != $customer['customer_id'] )
				die("You can only delete posts that you own");
			
			//delete the post
			$result = $this->db->deletePost($post_id);
			
			if( $result['success'] )
			{
				header("Location: /"); //redirect the user back to the homepage
			}
			else
			{
				die("Couldn't delete post"); //TODO idk what to do here
			}
		}
	}
}
?>