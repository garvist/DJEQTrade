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
		$maxUploadFileSize = 1024 * 1024 * 2;
		
		//is the user submitting an ad?
		if( isset($_POST['postTitle']) ) //yep
		{
			if( $_FILES['postImageData']['size'] < 0 && $_FILES['postImageData']['size'] > $maxUploadFileSize )
				die("The image you uploaded was too large");
			
			if( $_FILES['postImageData']['error'] > 0 )
			{
				switch( $_FILES['postImageData']['error'] )
				{
					case UPLOAD_ERR_INI_SIZE:
						die("File is too large");
					default:
						die("Error uploading image: error code = " .$_FILES['postImageData']['error']);
				}
			}
			
			if( $_FILES['postImageData']['size'] == 0 )
				die("You didn't upload an image");
			
			$post_title = $_POST['postTitle'];
			$post_tags = $_POST['postTags'];
			$post_image = $_POST['postImage'];
			$post_desc = $_POST['postDescription'];
			
			//parse the post tags into an array
			$post_tags_array = explode( ",", $post_tags );
			foreach( $post_tags_array as &$t )
				$t = trim($t);
			
			$result = $this->db->createPost($post_title, $_FILES['postImageData']['tmp_name'], $post_desc, $post_tags_array);
			
			if( $result['success'] )
			{
				header("Location: /?tmp_name=" .$_FILES['postImageData']['tmp_name']); //redirect the user back to the homepage
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
		echo "<div class=\"welcome\">"; //this can go in nav.php 
		echo "	<h1>Create an advertisement</h1>";
		//echo "	<p>Here you will find a bunch of things that I am too lazy to type out right now.</p>";
		echo "</div>";
		$this->nav_view->outputHTML();
		$this->createAd_view->outputHTML();
	}
}
?>