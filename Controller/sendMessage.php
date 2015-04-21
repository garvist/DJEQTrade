<?php

require_once 'Controller/Controller.php'; //defines Controller class
require_once 'View/navigation.php';
require_once 'View/sendMessage.php';

class SendMessageController extends Controller
{
	private $nav_view;
	private $sendMessage_view;
	
	//the constructor for this controller class
	function __construct()
	{
		parent::__construct(); //call our parent constructor -- this will create the database connection that we're going to use
		
		$this->nav_view = new NavigationView($this->db);
		$this->sendMessage_view = new SendMessageView($this->db);
	}
	
	/** Returns an array containing all of the views that this controller uses */
	protected function getViews()
	{
		return [ $this->nav_view, $this->sendMessage_view ];
	}
	
	public function executeBefore()
	{
		//is the user trying to send a message?
		if( isset($_POST['message']) )
		{
			//is the user logged in?
			if( $this->db->getLoggedInId() )
				die("Users that aren't logged in can't send messages"); //TODO handle this more gracefully
		
			$to_id = $_POST['to_id'];
			$message = $_POST['message'];
		
			$this->db->sendMessage($this->db->getLoggedInId(), $to_id, $message);
		
			//redirect to the user's profile
			header("Location: /?c=profile");
		}
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
		echo "	<h1>Send a message</h1>";
		//echo "	<p>Here you will find a bunch of things that I am too lazy to type out right now.</p>";
		echo "</div>";
		$this->nav_view->outputHTML();
		$this->sendMessage_view->outputHTML();
	}
}
?>