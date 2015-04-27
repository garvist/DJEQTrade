<?php

//website TODO list

//aboutFriend - view if user is a friend or not
//aboutFriend - add user as friend
//rate user functionality

//user reviews
//post comments



//determine the name of the Controller to use
$controller_name = '';
if( isset($_GET["c"]) )
	$controller_name = $_GET["c"];
else if( isset($_POST["c"]) )
	$controller_name = $_POST["c"];
else
	$controller_name = "homepage";

//create the Controller object
$controller = '';
switch( $controller_name )
{
	case "log in":
		require_once 'Controller/logIn.php';
		$controller = new LogInController();
		break;
	case "log out":
		require_once 'Controller/logOut.php';
		$controller = new LogOutController();
		break;
	case "create account":
		require_once 'Controller/createAccount.php';
		$controller = new CreateAccountController();
		break;
	case "homepage":
		require_once 'Controller/homepage.php';
		$controller = new HomepageController();
		break;
	case "search":
		require_once 'Controller/search.php';
		$controller = new SearchController();
		break;
	case "friends":
		require_once 'Controller/friends.php';
		$controller = new FriendsController();
		break;
	case "my ads":
		require_once 'Controller/myAds.php';
		$controller = new MyAdsController();
		break;
	case "create ad":
		require_once 'Controller/createAd.php';
		$controller = new CreateAdController();
		break;
	case "remove ad":
		require_once 'Controller/deleteAd.php';
		$controller = new DeleteAdController();
		break;
	case "profile":
		require_once 'Controller/profile.php';
		$controller = new ProfileController();
		break;
	case "messages":
		require_once 'Controller/messages.php';
		$controller = new MessagesController();
		break;
	case "send message":
		require_once 'Controller/sendMessage.php';
		$controller = new SendMessageController();
		break;
	
	default: //by default, use the homepage controller
		require_once 'Controller/homepage.php';
		$controller = new HomepageController();
		break;
}

$controller->executeBefore();
?>
<!DOCTYPE html>
<html>
	<head>
		<?php
			$controller->outputHead();
		?>
	</head>
	
	<body>
		<?php
			$controller->outputBody();
		?>
	</body>
</html>