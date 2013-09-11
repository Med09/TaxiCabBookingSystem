<?php
/*
Plugin Name: TaxiCab Booking System
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: A brief description of the Plugin.
Version: The Plugin's Version Number, e.g.: 1.0
Author: Name Of The Plugin Author
Author URI: http://URI_Of_The_Plugin_Author
License: A "Slug" license name e.g. GPL2
*/
define('BOOKINGSYSTEM_ROOT',plugin_dir_url( __FILE__));
define('TAXIROOT', plugins_url(null, __FILE__));
define('ROOTPATH', plugin_dir_path( __FILE__));

include('main.php');
?>