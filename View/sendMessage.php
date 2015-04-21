<?php

require_once 'View/View.php'; //defines the View class

class SendMessageView extends View
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
		return ["/Static/main.css"];
	}
	
	/** Outputs this view's HTML */
	public function outputHTML()
	{
		//$searchterm = ( isset($_GET['s']) ? $_GET['s'] : '' );
		
		//what user are we trying to send a message to?
		if( isset($_GET['id']) )
		{
			$customer = $this->db->getCustomerById( $_GET['id'] );
		
			echo "<div class=\"page\">";
			echo "<form action='/' method='post' id='send_message'>";
			echo "<input type='text' name='c' value='send message' style='display: none' />";
			echo "<input type='text' name='to_id' value=\"{$customer['customer_id']}\" style='display: none' />";
			echo "To: <input type='text' value=\"{$customer['first_name']} {$customer['last_name']}\" />";
			echo "Message: <textarea name='message' form='send_message'></textarea>";
			echo "<input type='submit' value='Send Message' />";
			echo "</form>";
			echo "</div>";
		}
		else
		{
			echo "Invalid parameters";
		}
	}
}

?>