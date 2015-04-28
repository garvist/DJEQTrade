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
		if( isset($_POST['message']) ) //yep
		{
			if( !$this->db->isLoggedIn() )
				die("Only logged in users can comment");
			
			$rating = $_POST['rating'];
			$message = intval( $_POST['message'] );
			$target_id = $_POST['target_id'];
			
			if( $rating < 0 || $rating > 5 )
				$rating = 3;
			
			$this->db->createReview($this->db->getLoggedInId(), $target_id, $rating, $message);
			
			header("Location: /"); //redirect the user back to the homepage
		}
	}
}
?>