"use strict";

/**
 *
 *	This little snipped forces links to work by changing the location 
 *	instead of like normal links. It allows the web app to behave more
 *	like an application in iOS.
 *
 * 
 */

$('a:not(.dropdown-toggle):not([href="#"]').click(function() {
	window.location=$(this).attr('href');
	return false;
});
