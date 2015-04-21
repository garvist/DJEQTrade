<?php
define("DB_HOST", "localhost");
define("DB_USER", "djex_test");
define("DB_PASS", "123456");
define("DB_NAME", "djex");

class DJEXDB
{
	private $con; //the database connection
	
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
	}
	
	private function error($error_msg)
	{
		die("DB Error: " .$error_msg);
	}
	
	/** Returns the database connection */
	public function getConnection()
	{
		return $con;
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
		$stmt = $this->con->prepare("SELECT post_id,title,image_url,message,customers.first_name,customers.last_name From Posts, customers WHERE Posts.from_customer_id = customers.customer_id ORDER BY post_id DESC");
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
}

?>