<?php

require_once 'Controller/Controller.php'; //defines Controller class

class CreateFriendsController extends Controller
{
	
	//the constructor for this controller class
	function __construct()
	{
		parent::__construct(); //call our parent constructor -- this will create the database connection that we're going to use
	}
	
	/** Returns an array containing all of the views that this controller uses */
	protected function getViews()
	{
		return [  ];//, return an empty array;
	}

	public function executeBefore()
	{
		//are they trying to add a friend?
		if( isset($_POST['friend_id']) )
		{
			//is the user logged in?
			if( !$this->db->getLoggedInId() )
				die("Users that aren't logged in can't add friends"); //TODO handle this more gracefully
		
			$addFriend = $_POST['friend_id'];
		
			$this->db->createFriend($this->db->getLoggedInId(), $addFriend);
		
			//redirect to the user's friend page
			header("Location: /?c=friends");
		}
	}
	
	/** Outputs all HTML that needs to go in the <head> of the page */
	public function outputHead()
	{
		parent::outputHead(); //call the outputHead() function of our superclass
	}
	
	/** Outputs all HTML that needs to go in the <body> of the page */
	public function outputBody()
	{
		
	}
}
?>