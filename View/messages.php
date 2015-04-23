<?php

require_once 'View/View.php'; //defines the View class

class MessagesView extends View
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
		//update css
		return ["/Static/main.css", "/Static/messages.css"];
	}
	
	/** Outputs this view's HTML */
	public function outputHTML()
	{
		//$searchterm = ( isset($_GET['s']) ? $_GET['s'] : '' );
		
		echo "<div class=\"page\">";
		echo "<div class =\"page-title\">";
		echo "	<h1>Your Messages</h1>";
		echo "</div>";
		echo "<div class =\"message-list\"";
		foreach( $this->db->getMessagesForUser( $this->db->getLoggedInId() ) as $msg )
		{
			echo "	<div class=\"messages\">";
			echo "	<h1 class=\"messages-title\">";
			
			switch( $msg['type'] )
			{
				case "sent":
					$profileUrl = '/?c=profile&id=' .$msg['id_from'];
					echo "To: <a href='{$profileUrl}'>{$msg['first_name_to']} {$msg['last_name_to']}</a>";
					break;
				case "recv":
					$profileUrl = '/?c=profile&id=' .$msg['id_from'];
					echo "From: <a href='{$profileUrl}'>{$msg['first_name_from']} {$msg['last_name_from']}</a>";
					break;
			}
			
			echo "	</h1>";
			echo "	<div class=\"messages-meta\">";
			echo "		<span>Message sent: {$msg['date_sent']}</span>";
			echo "	</div>";
			echo "	";
			echo "	<p class=\"messages-description\">";
			echo "	{$msg['message']}";
			echo "	</p>";
			echo "	</div>";
		}
		//echo "</div>";
		echo "</div>";
	}
}

?>