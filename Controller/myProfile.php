<?php

require_once 'Controller/Controller.php'; //defines Controller class
require_once 'View/navigation.php'; //defines NavigationView
require_once 'View/myAds.php';

class MyProfileController extends Controller
{
	private $nav_view;
	private $myAdsList_view;
	
	//the constructor for this controller class
	function __construct()
	{
		parent::__construct(); //call our parent constructor -- this will create the database connection that we're going to use
		
		$this->nav_view = new NavigationView($this->db);
		$this->myAdsList_view = new MyAdsListView($this->db);
	}
	
	/** Returns an array containing all of the views that this controller uses */
	protected function getViews()
	{
		return [ $this->nav_view, $this->myAdsList_view ];
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
		$this->myAdsList_view->outputHTML();
	}
}
?>