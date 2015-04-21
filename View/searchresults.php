<?php

require_once 'View/View.php'; //defines the View class

class SearchResultsView extends View
{
	/** Parent constructor for all views.
	 * Parameters:
	 * 	$db -> the connection to the database
	 */
	public function __construct($db)
	{
		parent::__construct($db);
	}
	
	/** Returns an array of CSS files that this view needs */
	public function requiredCSS()
	{
		return ["/Static/main.css", "/Static/postlist.css"];
	}
	
	/** Outputs this view's HTML */
	public function outputHTML()
	{
		$searchterm = ( isset($_GET['s']) ? $_GET['s'] : '' );
		
		echo "<div class=\"page\">";
		echo "	<div class=\"ad\">";
		echo "		<h1 class=\"ad-title\">No search results found for '" .$searchterm. "' Try again later.. you obviously failed.</h1>";
		echo "  </div>";
		echo "</div>";
	}
}

?>