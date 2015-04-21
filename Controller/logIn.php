<?php

require_once 'Controller/Controller.php'; //defines Controller class
require_once 'View/logIn.php';
require_once 'View/createAccount.php';

class LogInController extends Controller
{
	private $logIn_view;
	private $createAccount_view;
	
	//the constructor for this controller class
	function __construct()
	{
		parent::__construct(); //call our parent constructor -- this will create the database connection that we're going to use
		
		$this->logIn_view = new LogInView($this->db);
		$this->createAccount_view = new CreateUserAccountView($this->db);
	}
	
	/** Returns an array containing all of the views that this controller uses */
	protected function getViews()
	{
		return [ $this->logIn_view, $this->createAccount_view];
	}
	
	public function executeBefore()
	{
		//is this user trying to log in?
		if( isset($_POST['userEmail']) ) //yes
		{
			$email = $_POST['userEmail'];
			$pass  = $_POST['userPassword'];
			
			//are we already logged in?
			if( $this->db->isLoggedIn() )
				die("You are already logged in"); //TODO handle this more gracefully
			
			//attempt to log in
			if( $this->db->login($email, $pass) )
			{
				header("Location: /"); //redirect to the homepage
			}
			else
			{
				die("Login failed"); //TODO handle this more gracefully
			}
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
		$this->logIn_view->outputHTML();
		echo "<br><br><br>";
		$this->createAccount_view->outputHTML();
	}
}
?>