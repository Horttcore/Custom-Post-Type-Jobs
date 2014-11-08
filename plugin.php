<?php
/*
Plugin Name: Custom Post Type Jobs
Plugin URI: http://horttcore.de
Description: A custom post type for managing job offers
Version: 1.0
Author: Ralf Hortt
Author URI: http://horttcore.de
License: GPL2
*/

require( 'classes/custom-post-type-jobs.php' );
require( 'classes/custom-post-type-jobs.widget.php' );
require( 'inc/template-tags.php' );

if ( is_admin() )
	require( 'classes/custom-post-type-jobs.admin.php' );
