<?php
/*
Plugin Name: Defined Hosting Localised & Personalised ShortCodes
Plugin URI: http://www.definedhosting.co.uk/plugins
Description: Plugin for displaying localised and personalised content based on landing page entry
Author: R. Cush
Version: 5.1.8.2
Author URI: https://www.definedhosting.co.uk
*/
include_once('core.php');
//if ( is_admin() ) {
    new DHGitHubUpdater(__FILE__, 'DefinedHosting', "dh-localised" );
//}
