<?php

//Functions as the superclass for all controllers
abstract class Controller
{
	/** Returns an array containing all of the views that this controller uses */
	abstract protected function getViews();
	
	/** Outputs all HTML that needs to go in the <head> of the page */
	public function outputHead()
	{
		//output a <title>
		echo "<title>DJ Equipment Trade</title>";
		
		//get a list of all CSS files that our views need
		$cssList = []; //create an empty array
		foreach( $this->getViews() as $view ) //iterate through all of our views
			$cssList = array_merge( $cssList, $view->requiredCSS() ); //add the list of required CSS files for this view
		
		//remove duplicates from the list
		$cssList = array_unique( $cssList );
		
		//output <link> tags for every css file that we need
		foreach( $cssList as $cssFile )
			echo "<link href='" .$cssFile. "' rel='stylesheet' type='text/css' />";
	}
	
	/** Outputs all HTML that needs to go in the <body> of the page */
	public function outputBody()
	{
		//Do nothing.
		//This can be overridden by subclasses
	}
}
?>