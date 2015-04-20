<?php

//Functions as the superclass for all controllers
abstract class Controller
{
	/** Returns an array containing all of the views that this controller uses */
	abstract protected function getViews();
	
	/** This is executed before HTML is outputted */
	public function executeBefore()
	{
		//Do nothing.
		//This can be overridden by subclasses
	}
	
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
		
		//get a list of all JS files that our views need
		$jsList = []; //create an empty array
		foreach( $this->getViews() as $view ) //iterate through all of our views
			$jsList = array_merge( $jsList, $view->requiredJS() ); //add the list of required JS files for this view
		
		//remove duplicates from the list
		$jsList = array_unique( $jsList );
		
		//output <script> tags for every JS file that we need
		foreach( $jsList as $jsFile )
			echo "<script src='" .$jsFile. "'></script>";
	}
	
	/** Outputs all HTML that needs to go in the <body> of the page */
	public function outputBody()
	{
		//Do nothing.
		//This can be overridden by subclasses
	}
}
?>