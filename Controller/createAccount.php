<?php

require_once 'Controller/Controller.php'; //defines Controller class
require_once 'View/createAccount.php';

class CreateAccountController extends Controller
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
		//is the user trying to create an account?
		if( isset($_POST['firstName']) )
		{
			$first_name = $_POST['firstName'];
			$last_name = $_POST['lastName'];
			$email = $_POST['userEmail'];
			$pass = $_POST['userPassword'];
			
			$result = $this->db->createCustomer($first_name, $last_name, $email, $pass, false);
			if( $result['success'] )
			{
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
			else
			{
				die("Failed to create the account"); //TODO handle this more gracefully
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
		$this->createAccount_view->outputHTML();
	}
}
?>