<?php

require_once 'Controller/Controller.php'; //defines Controller class
require_once 'View/navigation.php'; //defines NavigationView
require_once 'View/createAd.php';

class CreateAdController extends Controller
{
	private $nav_view;
	private $createAd_view;
	
	//the constructor for this controller class
	function __construct()
	{
		parent::__construct(); //call our parent constructor -- this will create the database connection that we're going to use
		
		$this->nav_view = new NavigationView($this->db);
		$this->createAd_view = new CreateAdView($this->db);
	}
	
	/** Returns an array containing all of the views that this controller uses */
	protected function getViews()
	{
		return [ $this->nav_view, $this->createAd_view ];
	}
	
	public function executeBefore()
	{
		//is the user submitting an ad?
		if( isset($_POST['postTitle']) ) //yep
		{
			$post_title = $_POST['postTitle'];
			$post_tags = $_POST['postTags'];
			$post_image = $_POST['postImage'];
			$post_desc = $_POST['postDescription'];
			
			//parse the post tags into an array
			$post_tags_array = explode( ",", $post_tags );
			foreach( $post_tags_array as &$t )
				$t = trim($t);
			
			$result = $this->db->createPost($post_title, $post_image, $post_desc, $post_tags_array);
			
			if( $result['success'] )
			{
				header("Location: /"); //redirect the user back to the homepage
			}
			else
			{
				die("Couldn't add post"); //TODO idk what to do here
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
		$this->nav_view->outputHTML();
		$this->createAd_view->outputHTML();
	}
}
?>