<?php

require_once 'Controller/Controller.php'; //defines Controller class
require_once 'View/logIn.php';

class LogInController extends Controller
{
	private $logIn_view;
	
	//the constructor for this controller class
	function __construct()
	{
		$this->logIn_view = new LogInView();
	}
	
	/** Returns an array containing all of the views that this controller uses */
	protected function getViews()
	{
		return [ $this->logIn_view ];
	}
	
	/** Outputs all HTML that needs to go in the <head> of the page */
	public function outputHead()
	{
		parent::outputHead(); //call the outputHead() function of our superclass
		
		//output a <title> tag for the page
		echo "<title>DJEquipmentTrade</title>";
	}
	
	/** Outputs all HTML that needs to go in the <body> of the page */
	public function outputBody()
	{
		$this->logIn_view->outputHTML();
	}
}
?>