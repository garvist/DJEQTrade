<?php

require_once 'Controller/Controller.php'; //defines Controller class

class DeleteFriendsController extends Controller
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