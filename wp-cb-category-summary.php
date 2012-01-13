<?php
/*
Plugin Name: WPCB Category Summary
Plugin URI: http://www.amiworks.org/
Description: WP plugin to show yearly category.
Version: 0.1
Author: Aman Kumar Jain
Author URI: http://amanjain.com
*/

function WPCBCategorySummaryLoad()
{
	require_once(dirname(__FILE__).DIRECTORY_SEPARATOR."WPCBCategorySummary.php");	
}

	
add_action('cfct-modules-loaded', 'WPCBCategorySummaryLoad');

