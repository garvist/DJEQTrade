<?php

require_once 'Controller/Controller.php'; //defines Controller class
require_once 'View/navigation.php'; //defines NavigationView
require_once 'View/createAd.php';

class CreateCommentController extends Controller
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
		//is the user submitting an ad?
		if( isset($_POST['post_id']) ) //yep
		{
			if( !$this->db->isLoggedIn() )
				die("Only logged in users can comment");
			
			$post_id = $_POST['post_id'];
			$message = $_POST['message'];
			
			$this->db->createComment($this->db->getLoggedInId(), $post_id, $message);
			
			header("Location: /?x_post_id=" .$post_id. "&x_msg=" .$message); //redirect the user back to the homepage
		}
	}
}
?>