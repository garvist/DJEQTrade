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
		
		//get the search results
		$results = $this->db->search( $searchterm );
		
		//display results
		if( count($results) == 0 )
		{
			echo "<div class=\"page\">";
			echo "	<div class=\"ad\">";
			echo "		<h1 class=\"ad-title\">No search results found for '" .$searchterm. "'</h1>";
			echo "  </div>";
			echo "</div>";
		}
		else
		{
			echo "<div class=\"page\">";
			echo "	<div class=\"ad\">";
			echo "		<h1 class=\"ad-title\">search results for '" .$searchterm. "':</h1>";
			echo "	<ul>";
			
			foreach( $results as $res )
				echo "	<li>" .http_build_query($res). "</li>"; //TODO this is just temporary
			
			echo "	</ul>";
			echo "  </div>";
			echo "</div>";
		}
	}
}

?>