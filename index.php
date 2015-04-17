<?php
//determine the name of the Controller to use
$controller_name = ( isset($_GET["c"]) ? $_GET["c"] : "homepage" );

//create the Controller object
$controller = '';
switch( $controller_name )
{
	case "homepage":
		require_once 'Controller/homepage.php';
		$controller = new HomepageController();
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