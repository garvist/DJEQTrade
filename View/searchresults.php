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
		return ["/Static/main.css", "/Static/searchresultslist.css"];
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
			{
				echo "	<li class='result'>";
				switch( $res['type'] )
				{
					case "customer":
						$profileUrl = "/?c=profile&id=" .$res['customer_id'];
						echo "<span class='result-title'>User: <a href='{$profileUrl}'>{$res['first_name']} {$res['last_name']}</a></span>";
						break;
					case "post":
						$profileUrl = "/?c=profile&id=" .$res['from_customer_id'];
						echo "<span class='result-title'>Post: <a href='{$profileUrl}'>{$res['title']}</a></span>";
						echo "<p class='result-description'>{$res['message']}</p>";
						echo "<span class='result-byline'>Posted by {$res['first_name_from']} {$res['last_name_from']}</span>";
						break;
					default:
						echo http_build_query($res);
						break;
				}
				echo "</li>";
			}
			
			echo "	</ul>";
			echo "  </div>";
			echo "</div>";
		}
	}
}

?>