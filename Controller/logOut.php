<?php

require_once 'Controller/Controller.php'; //defines Controller class
require_once 'View/logIn.php';
require_once 'View/createAccount.php';

class LogOutController extends Controller
{	
	//the constructor for this controller class
	function __construct()
	{
		parent::__construct(); //call our parent constructor -- this will create the database connection that we're going to use
	}
	
	/** Returns an array containing all of the views that this controller uses */
	protected function getViews()
	{
		return []; //this controller has no views
	}
	
	public function executeBefore()
	{
		$this->db->logout(); //log the user out
		
		header("Location: /"); //redirect to the home page
	}
	
	/** Outputs all HTML that needs to go in the <head> of the page */
	public function outputHead()
	{
		parent::outputHead(); //call the outputHead() function of our superclass
		
		//output a <title> tag for the page
		echo "<title>DJEquipmentTrade</title>";
	}
}
?>