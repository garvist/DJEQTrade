<?php
//determine the name of the Controller to use
$controller_name = ( isset($_GET["c"]) ? $_GET["c"] : "homepage" );

//create the Controller object
$controller = '';
switch( $controller_name )
{
	case "log in":
		require_once 'Controller/logIn.php';
		$controller = new LogInController();
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
	case "post an ad":
		require_once 'Controller/createAd.php';
		$controller = new CreateAdController();
		break;
	case "messages":
		require_once 'Controller/messages.php';
		$controller = new MessagesController();
		break;
	default: //by default, use the homepage controller
		require_once 'Controller/homepage.php';
		$controller = new HomepageController();
		break;
}
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