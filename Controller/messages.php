<?php

require_once 'Controller/Controller.php'; //defines Controller class
require_once 'View/navigation.php'; //defines NavigationView
require_once 'View/messages.php';

class MessagesController extends Controller
{
	private $nav_view;
	private $messages_view;
	
	//the constructor for this controller class
	function __construct()
	{
		parent::__construct(); //call our parent constructor -- this will create the database connection that we're going to use
		
		$this->nav_view = new NavigationView($this->db);
		$this->messages_view = new MessagesView($this->db);
	}
	
	/** Returns an array containing all of the views that this controller uses */
	protected function getViews()
	{
		return [ $this->nav_view, $this->messages_view ];
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
		echo "<div class=\"welcome\">"; //this can go in nav.php 
		echo "	<h1>My Messages</h1>";
		//echo "	<p>Here you will find a bunch of things that I am too lazy to type out right now.</p>";
		echo "</div>";
		$this->nav_view->outputHTML();
		$this->messages_view->outputHTML();
	}
}
?>