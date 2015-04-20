<?php

require_once 'Controller/Controller.php'; //defines Controller class
require_once 'View/navigation.php'; //defines NavigationView
require_once 'View/postlist.php'; //defines PostListView

class HomepageController extends Controller
{
	private $nav_view;
	private $postlist_view;
	
	//the constructor for this controller class
	function __construct()
	{
		$this->nav_view = new NavigationView();
		$this->postlist_view = new PostListView();
	}
	
	/** Returns an array containing all of the views that this controller uses */
	protected function getViews()
	{
		return [ $this->nav_view, $this->postlist_view ];
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
		//$this->postlist_view->outputHTML();
		echo "<div class=\"welcome\">";
		echo "	<h1>Welcome to DJ Equipment Trade!</h1>";
		echo "	<p>Here you will find a bunch of things that I am too lazy to type out right now.</p>"
		echo "</div>"
	}
}
?>