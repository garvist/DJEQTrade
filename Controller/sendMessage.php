<?php

require_once 'Controller/Controller.php'; //defines Controller class
require_once 'View/createAccount.php';

class SendMessageController extends Controller
{
	private $createAccount_view;
	
	//the constructor for this controller class
	function __construct()
	{
		parent::__construct(); //call our parent constructor -- this will create the database connection that we're going to use
		
		$this->createAccount_view = new CreateAccountView($this->db);
	}
	
	/** Returns an array containing all of the views that this controller uses */
	protected function getViews()
	{
		return [ $this->createAccount_view ];
	}
	
	public function executeBefore()
	{
		//is the user logged in?
		if( $this->db->getLoggedInId() )
			die("Users that aren't logged in can't send messages"); //TODO handle this more gracefully
		
		//get the message information
		if( !isset($_POST['message']) )
			die("Invalid form data"); //TODO handle this more gracefully
		
		$to_id = $_POST['to_id'];
		$message = $_POST['message'];
		
		$this->db->sendMessage($this->db->getLoggedInId(), $to_id, $message);
		
		//redirect to the user's profile
		header("Location: /?c=profile");
	}
}
?>