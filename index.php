<?php
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
<<<<<<< HEAD
	case "browse ads":
		require_once 'Controller/browseAds.php';
		$controller = new BrowseAdsController();
=======
	case "messages":
		require_once 'Controller/messages.php';
		$controller = new MessagesController();
>>>>>>> 639f70f02ffe5315e5c4b257f115bb9d620f5294
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