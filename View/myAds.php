<?php

require_once 'View/View.php'; //defines the View class

class MyAdsListView extends View
{
	/** Returns an array of CSS files that this view needs */
	public function requiredCSS()
	{
		return ["/Static/main.css", "/Static/postlist.css"]; //return an array containing the string "/Static/main.css" and "/Static/postlist.css"
	}
	
	/** Outputs this view's HTML */
	public function outputHTML()
	{
		echo "<div class=\"myAds\">";
		echo "	<h1>My Ads</h1>";
		echo " 	<p>Here you will find a list of your ads generated from the sql database.</p>";
		echo "</div>";
		echo "<div class=\"page\">";
		echo "	<div class=\"ad\">";
		echo "		<h1 class=\"ad-title\">My Amazing Speakers</h1>";
		echo "		<div class=\"ad-meta\">";
		echo "			<span>Categories: speakers</span>";
		echo "			<span>Tags: tags-r-fun, high-range</span>";
		echo "		</div>";
		echo "		";
		echo "		<p class=\"ad-description\">";
		echo "			I'm selling my old speakers. Message me with offers. This is such a funny little post. -Karl approves.";
		echo "		</p>";
		echo "		";
		echo "		<img class=\"ad-image\" src=\"/blownspeakers.jpg\" />";
		echo "		";
		echo "		<span class=\"ad-byline\">Posted by DJ Jimbo on Apr 2 @ 4:30pm</span>";
		echo "	</div>";
		echo "	";
		echo "	<div class=\"ad\">";
		echo "		<h1 class=\"ad-title\">My's Amazing, Wonderful, loud, big, noisy, adjectives Subwoofers</h1>";
		echo "		<div class=\"ad-meta\">";
		echo "			<span class=\"ad-author\">Posted by DJ Jimbo</span>";
		echo "			<span>Categories: speakers</span>";
		echo "			<span>Tags: tags-r-fun, high-range</span>";
		echo "		</div>";
		echo "		";
		echo "		<p class=\"ad-description\">";
		echo "			Check out my awesome subwoofers! Message me with offers.";
		echo "		</p>";
		echo "		";
		echo "		<img class=\"ad-image\" src=\"/blownspeakers.jpg\" />";
		echo "		";
		echo "		<span class=\"ad-byline\">Posted by DJ Jimbo on Apr 2 @ 4:37pm</span>";
		echo "	</div>";
		echo "</div>";
	}
}

?>






<?php

require_once 'Controller/Controller.php'; //defines Controller class
require_once 'View/navigation.php'; //defines NavigationView
//require_once 'View/postlist.php';

class MyAdsController extends Controller
{
	private $nav_view;
	//private $postlist_view;
	
	//the constructor for this controller class
	function __construct()
	{
		$this->nav_view = new NavigationView();
		//$this->postlist_view = new PostListView();
	}
	
	/** Returns an array containing all of the views that this controller uses */
	protected function getViews()
	{
		return [ $this->nav_view];
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
		echo "<div class=\"myAds\">";
		echo "	<h1>My Ads</h1>";
		echo " 	<p>Here you will find a list of your ads generated from the sql database.</p>";
		echo "</div>";
	}
}
?>