<?php

require_once 'Controller/Controller.php'; //defines Controller class
require_once 'View/navigation.php'; //defines NavigationView
require_once 'View/FriendsList.php';

class FriendsController extends Controller
{
	private $nav_view;
	private $friendslist_view;
	
	//the constructor for this controller class
	function __construct()
	{
		$this->nav_view = new NavigationView();
		$this->friendslist_view = new FriendsListView();
	}
	
	/** Returns an array containing all of the views that this controller uses */
	protected function getViews()
	{
		return [ $this->nav_view, $this->friendslist_view ];
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
		$this->nav_view->outputHTML();
		$this->friendslist_view->outputHTML();
	}
}
?>