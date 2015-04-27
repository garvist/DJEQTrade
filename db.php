<?php

//for connecting to Warren's db
define("DB_HOST", "localhost");
define("DB_USER", "djex_test");
define("DB_PASS", "123456");
define("DB_NAME", "djex");


/*
//for connecting to Karl's db
define("DB_HOST", "student.seas.gwu.edu");
define("DB_USER", "karlpreisner");
define("DB_PASS", "PRv0Q}fF");
define("DB_NAME", "karlpreisner");
*/

class DJEXDB
{
	private $con; //the database connection
	private $con2; //the second connection. don't retrieve this directly -- use getSecondConnection()
	
	private $loggedIn; //are we logged in?
	private $loggedInId; //the ID of the customer that is logged
		
	public function __construct()
	{
		//create a connection to the database
		$this->con = mysqli_connect( DB_HOST, DB_USER, DB_PASS, DB_NAME );
		if( $this->con->connect_errno )
			die("Failed to connect to server"); //stop the script with this error message
		
		//create the schema if needed
		$schema = [
			"customers" => "CREATE TABLE customers (first_name TEXT, last_name TEXT, customer_id INT primary key auto_increment, email TEXT, administrator BOOLEAN);",
			"passwords" => "CREATE TABLE passwords (customer_id INT, FOREIGN KEY (customer_id) REFERENCES customers(customer_id), hash_pass TEXT);",
			"Posts" => "CREATE TABLE Posts (post_id INT PRIMARY KEY auto_increment, title TEXT, image_url TEXT, message TEXT, from_customer_id INT, FOREIGN KEY (from_customer_id) REFERENCES customers(customer_id));",
			"Equipment_Tags" => "CREATE TABLE Equipment_Tags (post_id INT, FOREIGN KEY (post_id) REFERENCES Posts(post_id), tag TEXT);",
			"Comments" => "CREATE TABLE Comments (post_id INT, customer_id INT, FOREIGN KEY (post_id) REFERENCES Posts(post_id), FOREIGN KEY (customer_id) REFERENCES customer(customer_id), date_written DATETIME, comment_text TEXT);",
			"Messages" => "CREATE TABLE Messages (message TEXT, ID_to INT, ID_from INT, FOREIGN KEY (ID_to) REFERENCES customers(customer_id), FOREIGN KEY (ID_from) REFERENCES customers(customer_id), date_sent DATETIME, date_opened DATETIME );",
			"Friends" => "CREATE TABLE Friends (customer_id INT, friend_id INT, FOREIGN KEY (customer_id) REFERENCES customers(customer_id), FOREIGN KEY (friend_id) REFERENCES customers(customer_id) );",
			"Log_in_State" => "CREATE TABLE Log_in_State (customer_id INT, FOREIGN KEY (customer_id) REFERENCES customers(customer_id), date_issued DATETIME, cookie TEXT, last_interaction DATETIME);",
			"Reviews" => "CREATE TABLE Reviews (author_customer_id INT, target_customer_id INT, FOREIGN KEY (author_customer_id) REFERENCES customers(customer_id), FOREIGN KEY (target_customer_id) REFERENCES customers(customer_id), review_text TEXT);"
		];
	
		$view = [
			"CREATE VIEW administrators AS
			(SELECT * FROM customers WHERE administrator = 1)",
		
			"CREATE VIEW unread_messages AS
			(SELECT * FROM Messages, customers AS sender
			WHERE sender.customer_id = ID_from
			GROUP BY ID_from
			HAVING date_opened < NOW()
			ORDER BY date_sent DESC)"	
		];
	
		//create the schema
		foreach( $schema as $tablename => $query )
		{
			if( !$this->db_table_exists($tablename) )
			{
				if( !mysqli_query($this->con, $query) )
				{
					die("Could not create table '" .$tablename. "'");
				}
			}
		}
		
		//create the views
		foreach( $view as $v )
			mysqli_query($this->con, $v);
		
		//check login state
		$this->checkLoginState();
	}
	
	private function db_table_exists($tablename)
	{
		//http://stackoverflow.com/questions/9008299/check-if-mysql-table-exists-or-not/9008326#9008326
		return mysqli_num_rows( mysqli_query($this->con, "SHOW TABLES LIKE '" .$tablename. "'") ) == 1;
	}
	
	public function __destruct()
	{
		mysqli_close( $this->con );
		
		if( isset($this->con2) )
			mysqli_close( $this->con2 );
	}
	
	private function error($error_msg)
	{
		die("DB Error: " .$error_msg);
	}
	
	/** Returns the second database connection */
	private function getSecondConnection()
	{
		if( !isset($this->con2) )
		{
			$this->con2 = mysqli_connect( DB_HOST, DB_USER, DB_PASS, DB_NAME );
			if( $this->con2->connect_errno )
				die("Failed to connect to server"); //stop the script with this error message
		}
		
		return $this->con2;
	}
	
	//login
	private function checkLoginState()
	{
		//check for a login cookie
		if( isset($_COOKIE["login"]) )
		{
			$loginCookie = $_COOKIE["login"];
			
			$stmt = $this->con->prepare("SELECT customer_id FROM Log_in_State WHERE cookie = ?");
			$stmt->bind_param("s", $loginCookie);
			$stmt->execute();
			$stmt->bind_result($customer_id);
			
			if( $stmt->fetch() )
			{
				$this->loggedIn = true;
				$this->loggedInId = $customer_id;
			}
			else
			{
				$this->loggedIn = false;
			}
		}
		else
		{
			$this->loggedIn = false;
		}
	}
	
	private function generateLoginCookie($customer_id)
	{
		$use_crypto_strong = true;
		return $customer_id . bin2hex(openssl_random_pseudo_bytes( 128, $use_crypto_strong ));
	}
	
	/* Attempts to log the user in.
		Returns true if the user was successfully logged in, false otherwise;
	*/
	public function login($email, $password)
	{
		//get the customer id
		$stmt = $this->con->prepare("SELECT customer_id FROM customers WHERE email = ?");
		if( $stmt == false )
			$this->error("Could not create prepare statement");
		
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$stmt->bind_result($customer_id);
		
		if( $stmt->fetch() )
		{
			$stmt->close();
			
			//get the customer's password
			$stmt = $this->con->prepare("SELECT hash_pass FROM passwords WHERE customer_id = ?");
			$stmt->bind_param("s", $customer_id);
			$stmt->execute();
			$stmt->bind_result($hash_pass);
			$stmt->fetch();
			
			//compare the customer's actual password to what they inputted
			if( $hash_pass == $password )
			{
				$stmt->close();
				
				//generate a cookie for this user
				$cookie = $this->generateLoginCookie($customer_id);
				
				//insert the cookie into the log_in_state table
				$stmt = $this->con->prepare("INSERT INTO Log_in_State (customer_id, date_issued, last_interaction, cookie) VALUES (?, NOW(), NOW(), ?)");
				$stmt->bind_param("is", $customer_id, $cookie);
				$stmt->execute();
				$stmt->close();
				
				//set the cookie on the user's browser
				if( !setcookie("login", $cookie, time() + (60*60*24), "/") ) //set the cookie for 24 hours
					$this->error("Couldn't create cookie");
				
				//set local login variables
				$this->loggedIn = true;
				$this->loggedInId = $customer_id;
				
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			$stmt->close();
			return false;
		}
	}
	
	/** Attempts to log the user out */
	public function logout()
	{
		//does the user have a cookie?
		if( !isset($_COOKIE['login']) )
			return;
		
		//get the user's cookie
		$cookie = $_COOKIE['login'];
		
		//delete the cookie from the database table
		$stmt = $this->con->prepare("DELETE FROM Log_in_State WHERE cookie = ?");
		$stmt->bind_param("s", $cookie);
		$stmt->execute();
		
		//remove the cookie from the user's browser
		//this won't work unless this method is called in a controller's executeBefore()
		setcookie("login", "", time() - 1); //set the cookie's expiration date to a past time so that the cookie expires
	}
	
	/* Returns true if this user is logged in */
	public function isLoggedIn()
	{
		return $this->loggedIn;
	}
	
	/* Returns the customer ID of the logged in user */
	public function getLoggedInId()
	{
		return $this->loggedInId;
	}
	
	//query helper methods
	/** Creates a customer
	 *	On failure, returns this associative array: ["success" => false]
	 *  On success, returns this associative array: ["success" => true, "customer_id" => customer_id ]
	 */
	public function createCustomer($first_name, $last_name, $email, $password, $administrator)
	{
		//make sure that a user with this email doesn't exist yet
		$stmt = $this->con->prepare("SELECT * FROM customers WHERE email = ?");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		
		if( $stmt->num_rows > 0 ) //a customer with this ID already exists
		{
			$stmt->close();
			return ["success" => false];
		}
		
		$stmt->close();
		
		//insert the customer into the customers table
		$stmt = $this->con->prepare("INSERT INTO customers (first_name, last_name, email, administrator) VALUES (?, ?, ?, ?)"); //returns false on error
		if( $stmt == false )
			return [ "success" => false ];
		
		$stmt->bind_param("sssi", $first_name, $last_name, $email, $administrator);
		if( !$stmt->execute() ) //returns true on success, false on failure
			return [ "success" => false ];
		
		$stmt->close();
		
		$customer_id = $this->con->insert_id;
		
		//hash the customers password
		$hashedpass = $password; //TODO later we'll actually hash and salt and stretch this
		
		//insert the password into the passwords table
		$stmt = $this->con->prepare("INSERT INTO passwords (customer_id, hash_pass) VALUES (?, ?)");
		if( $stmt == false )
			return [ "success" => false ];
		
		$stmt->bind_param("is", $customer_id, $hashedpass);
		
		if( !$stmt->execute() )
			return [ "success" => false ];
		
		return ["success" => true, "customer_id" => $customer_id];
	}
	
	/** Returns an array of all posts */
	public function getAllPosts()
	{
		$stmt = $this->con->prepare("SELECT post_id,title,image_url,message,customers.first_name,customers.last_name, customers.customer_id From Posts, customers WHERE Posts.from_customer_id = customers.customer_id ORDER BY post_id DESC");
		$stmt->execute();
		$stmt->bind_result($post_id, $title, $image_url, $message, $customer_fname, $customer_lname, $customer_id);
		
		$posts = [];
		
		while( $stmt->fetch() )
		{
			//create an associative array for this post
			$post = [ "post_id" => $post_id, "title" => $title, "image_url" => $image_url, "message" => $message, "first_name" => $customer_fname, "last_name" => $customer_lname, "customer_id" => $customer_id ];
			
			//add this post onto the end of our array
			$posts[] = $post;
		}
		
		$stmt->close();
		
		//retrieve tags for each post
		foreach( $posts as &$post )
		{
			$tags = [];
			
			$stmt = $this->con->prepare("SELECT tag FROM Equipment_Tags WHERE post_id = ?");
			$stmt->bind_param("i", $post['post_id']);
			$stmt->execute();
			$stmt->bind_result($tag);
			
			while( $stmt->fetch() ) //loop through all tags for this post
				$tags[] = $tag; //push this tag onto the array
			
			$post['tags'] = $tags;
			
			$stmt->close();
		}
		
		return $posts;
	}
	
	/** Returns an array of all posts written by the given user */
	public function getAllPostsForUser($customer_id)
	{
		$stmt = $this->con->prepare("SELECT post_id,title,image_url,message,customers.first_name,customers.last_name From Posts, customers WHERE Posts.from_customer_id = customers.customer_id AND customers.customer_id = ? ORDER BY post_id DESC");
		$stmt->bind_param("i", $customer_id);
		$stmt->execute();
		$stmt->bind_result($post_id, $title, $image_url, $message, $customer_fname, $customer_lname);
		
		$posts = [];
		
		while( $stmt->fetch() )
		{
			//create an associative array for this post
			$post = [ "post_id" => $post_id, "title" => $title, "image_url" => $image_url, "message" => $message, "first_name" => $customer_fname, "last_name" => $customer_lname ];
			
			//add this post onto the end of our array
			$posts[] = $post;
		}
		
		$stmt->close();
		
		//retrieve tags for each post
		foreach( $posts as &$post )
			$post['tags'] = $this->getAllTagsForPost($post['post_id']);
		
		return $posts;
	}
	
	/** Returns an array of all tags for the given post */
	public function getAllTagsForPost($post_id)
	{
		$tags = [];
		
		$stmt = $this->getSecondConnection()->prepare("SELECT tag FROM Equipment_Tags WHERE post_id = ?");
		$stmt->bind_param("i", $post_id);
		$stmt->execute();
		$stmt->bind_result($tag);
		
		while( $stmt->fetch() ) //loop through all tags for this post
			$tags[] = $tag; //push this tag onto the array
		
		$stmt->close();
		
		return $tags;
	}
	
	/** Returns an array containing all of the user's friends */
	public function getFriendsForUser($customer_id)
	{
		$stmt = $this->con->prepare("SELECT customer_id, first_name, last_name FROM customers WHERE customer_id IN (SELECT friend_id FROM Friends WHERE Friends.customer_id = ?)");
		$stmt->bind_param("i", $customer_id);
		$stmt->execute();
		$stmt->bind_result($friend_id, $first_name, $last_name);
		
		$friends = [];
		
		while( $stmt->fetch() )
		{
			//create an associative array for this friend
			$friend = [ "customer_id" => $friend_id, "first_name" => $first_name, "last_name" => $last_name ];
			
			//add this friend onto the end of our array
			$friends[] = $friend;
		}
		
		$stmt->close();
		
		return $friends;
	}


	
	/** Returns an associative array containing the name and email of the customer with the given id */
	public function getCustomerById($customer_id)
	{
		$stmt = $this->con->prepare("SELECT first_name, last_name, email, administrator FROM customers WHERE customer_id = ?");
		$stmt->bind_param("i", $customer_id);
		$stmt->execute();
		$stmt->bind_result($first_name, $last_name, $email, $administrator);
		$stmt->fetch();
		
		return [ "first_name" => $first_name, "last_name" => $last_name, "email" => $email, "customer_id" => $customer_id, "administrator" => $administrator ];
	}
	
	/** Returns an array of all messages sent to or from the given user */
	public function getMessagesForUser($customer_id)
	{
		$stmt = $this->con->prepare("SELECT message, date_sent, date_opened, ID_from, ID_to, F.first_name AS first_name_from, F.last_name AS last_name_from, T.first_name AS first_name_to, T.last_name AS last_name_to
		FROM Messages, customers AS F, customers AS T
		WHERE (ID_to = ? OR ID_from = ?) AND (F.customer_id = ID_from) AND (T.customer_id = ID_to)
		ORDER BY date_sent DESC
		");
		$stmt->bind_param("ii", $customer_id, $customer_id);
		$stmt->execute();
		$stmt->bind_result($message, $date_sent, $date_opened, $ID_from, $ID_to, $first_name_from, $last_name_from, $first_name_to, $last_name_to);
		
		$messages = [];
		
		while( $stmt->fetch() )
		{
			$msg = [ "message" => $message, "date_sent" => $date_sent, "date_opened" => $date_opened,
				"id_from" => $ID_from, "id_to" => $ID_to,
				"first_name_from" => $first_name_from, "last_name_from" => $last_name_from,
				"first_name_to" => $first_name_to, "last_name_to" => $last_name_to ];
			
			if( $customer_id == $ID_from )
				$msg['type'] = "sent";
			else
				$msg['type'] = "recv";
			
			$messages[] = $msg;
		}
		
		return $messages;
	}
	
	/** Creates a post.
	 *	On failure, returns this associative array: ["success" => false]
	 *  On success, returns this associative array: ["success" => true, "post_id" => post_id ]
	 */
	public function createPost($title, $image_url, $message, $tags)
	{
		//return false if we aren't logged in
		if( !$this->isLoggedIn() )
			return ["success" => false];
		
		//create the post
		$stmt = $this->con->prepare("INSERT INTO Posts (title, image_url, message, from_customer_id) VALUES (?, ?, ?, ?)");
		$stmt->bind_param("sssi", $title, $image_url, $message, $this->getLoggedInId());
		$stmt->execute();
		
		$post_id = $this->con->insert_id;
		
		$stmt->close();
		
		//add the tags to the post
		foreach( $tags as $t )
		{
			$stmt = $this->con->prepare("INSERT INTO Equipment_Tags (post_id, tag) VALUES (?, ?)");
			$stmt->bind_param("is", $post_id, $t);
			$stmt->execute();
			$stmt->close();
		}
		
		return ["success" => true, "post_id" => $post_id];
	}



	/**delete a Post from the Database
	 *
	 */
	public function deletePost($post_id)
	{

		//return false if we aren't logged in
		if( !$this->isLoggedIn() )
			return ["success" => false];

		//if post.from_customer_id matches loggedInID - you can remove the post
		//-------IMPLEMENT-------

		//if loggedInID is an administrator - you can remove the psot
		//-------IMPLEMENT-------


		//remove the comments from the post
		$stmt = $this->con->prepare("DELETE FROM Comments WHERE post_id = ?");
		$stmt->bind_param("i", $post_id);
		$stmt->execute();
		$stmt->close();

		$stmt->close();

		//remove the post
		$stmt = $this->con->prepare("DELETE FROM Posts WHERE post_id = ?");
		$stmt->bind_param("i", $post_id);
		$stmt->execute();
		$stmt->close();

		$stmt->close();
	}
	
	public function sendMessage($from_id, $to_id, $message)
	{
		$stmt = $this->con->prepare("INSERT INTO Messages (message, ID_to, ID_from, date_sent, date_opened) VALUES (?, ?, ?, NOW(), '1995-03-04')");
		$stmt->bind_param("sii", $message, $to_id, $from_id);
		$stmt->execute();
		$stmt->close();
	}
	
	//search functions
	public function search($searchterms)
	{
		//split the search terms by " "
		$searchterms_array = explode(" ", $searchterms);
		
		//search the tables and merge results into one table
		$results = array_merge( [], $this->search_customers($searchterms_array), $this->search_posts($searchterms_array) );
		
		//sort results by rank
		uksort($results, [$this, "compareResults"]); //the second parameter is kind of like a function pointer for $this->compareResults()
		
		//reverse the results array so that the results are ordered from highest rank to lowest
		$results = array_reverse($results);
		
		//return results
		return $results;
	}
	
	/** Searches the 'customers' database table.
	 * $searchterms -> an array of terms to search for
	 */
	private function search_customers($searchterms)
	{
		$results_set = new SubSearchResultsSet();
		
		foreach( $searchterms as $term )
		{
			//search the customers table
			$stmt = $this->con->prepare("SELECT first_name, last_name, customer_id, email FROM customers WHERE (first_name LIKE ?) OR (last_name LIKE ?) OR (email LIKE ?)");
		
			$search_terms_fuzzy_search = "%" .$term. "%";
		
			$stmt->bind_param("sss", $search_terms_fuzzy_search, $search_terms_fuzzy_search, $search_terms_fuzzy_search);
			$stmt->execute();
			$stmt->bind_result($first_name, $last_name, $customer_id, $email);
		
			while( $stmt->fetch() )
			{
				$result = [ "type" => "customer", "customer_id" => $customer_id, "first_name" => $first_name, "last_name" => $last_name, "email" => $email ];
				$result['rank'] = $this->calculateRank($term, [$first_name, $last_name, $email]);
			
				//add this result to our result set.
				//If a result with the given customer_id already exists in the set, only the result with the higher rank will be kept
				$results_set->addResult( $customer_id, $result );
			}
		
			$stmt->close();
		}
		
		//return all array values
		return $results_set->getResults();
	}
	
	/** Searches the 'Posts' database table.
	 * $searchterms -> an array of terms to search for
	 */
	private function search_posts($searchterms)
	{
		$results_set = new SubSearchResultsSet();
		
		foreach( $searchterms as $term )
		{
			//search the posts table
			$stmt = $this->con->prepare("SELECT post_id, title, message, from_customer_id, customers.first_name, customers.last_name
			FROM Posts, customers
			WHERE (Posts.from_customer_id = customers.customer_id) AND ( (title LIKE ?) OR (message LIKE ?) OR (first_name LIKE ?) OR (last_name LIKE ?) )
			");
		
			$search_terms_fuzzy_search = "%" .$term. "%";
		
			$stmt->bind_param("ssss", $search_terms_fuzzy_search, $search_terms_fuzzy_search, $search_terms_fuzzy_search, $search_terms_fuzzy_search);
			$stmt->execute();
			$stmt->bind_result($post_id, $title, $message, $from_customer_id, $from_first_name, $from_last_name);

			while( $stmt->fetch() )
			{
				//get all of this post's tags
				$tags = $this->getAllTagsForPost($post_id);
				
				$result = [ "type" => "post",
					"post_id" => $post_id, "tags" => $tags,
					"title" => $title, "message" => $message,
					"from_customer_id" => $from_customer_id, "first_name_from" => $from_first_name, "last_name_from" => $from_last_name ];
				$result['rank'] = $this->calculateRank($term, array_merge([$title, $message, $from_first_name, $from_last_name], $tags));
			
				//add this result to our result set.
				//If a result with the given post_id already exists in the set, only the result with the higher rank will be kept
				$results_set->addResult( $post_id, $result );
			}

			$stmt->close();
		}
		
		//return all array values
		return $results_set->getResults();
	}


	
	/** Calculates a rank.
	 * $searchterms -> the search terms to look for
	 * $array       -> an array of strings to search
	 */
	private function calculateRank($searchterms, $array)
	{
		$dist = [];
		
		foreach( $array as $text )
			$dist[] = levenshtein($searchterms, $text);
		
		return max($dist);
	}
	
	/* Returns -1, 0, or 1 if the first argument is less than, equal to, or greater than the second */
	private function compareResults($res1, $res2)
	{
		return $res1['rank'] - $res2['rank'];
	}
}

/** Is used by DJEXDB to keep track of the best search results in a table. If you are trying to create instances of this object from outside this file, you're probably doing it wrong.
 */
class SubSearchResultsSet
{
	private $results_map;
	
	public function __construct()
	{
		$this->results_map = [];
	}
	
	/** Adds a result to the set.
	 * If a result with the given key already exists in the set, then the result with the highest rank will be kept.
	 */
	public function addResult($key, $result)
	{
		//does the results_map already have a result with this key?
		if( array_key_exists($key, $this->results_map) ) //yes
		{
			//get the old result
			$old_result = $this->results_map[$key];
			
			//insert the result with the highest rank back into the results
			if( $result['rank'] > $old_result['rank'] )
				$this->results_map[$key] = $result;
		}
		else
		{
			$this->results_map[$key] = $result;
		}
	}
	
	/** Returns all results in this set */
	public function getResults()
	{
		return array_values($this->results_map);
	}
}

?>