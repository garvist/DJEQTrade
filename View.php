<?php

abstract class View
{
	/** Returns an array of CSS files that this view needs */
	public function requiredCSS()
	{
		//Return an empty array.
		//This can (and probably should) be overridden by subclasses.
		return [];
	}
	
	/** Returns an array of JavaScript files that this view needs */
	public function requiredJS()
	{
		//Return an empty array.
		//This can (and probably should) be overridden by subclasses.
		return [];
	}
	
	/** Outputs this view's HTML */
	public function outputHTML()
	{
		//Do nothing.
		//This can (and probably should) be overridden by subclasses.
	}
}

?>