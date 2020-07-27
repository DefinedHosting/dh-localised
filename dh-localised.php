<?php
/*
Plugin Name: Defined Hosting Localised & Personalised ShortCodes
Plugin URI: http://www.definedhosting.co.uk/plugins
Description: Plugin for displaying localised and personalised content based on landing page entry
Author: R. Cush
Version: 5.3.1
Author URI: https://www.definedhosting.co.uk
*/
include_once('core.php');
$updater = new Smashing_Updater( __FILE__ ); // instantiate our class
$updater->set_username( 'DefinedHosting' ); // set username
$updater->set_repository( 'dh-localised' ); // set repo
$updater->initialize(); // initialize the updater
