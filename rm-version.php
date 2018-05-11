<?php
/*
 * Plugin Name: Remove Wordpress Version
 * Version: 0.2
 * Plugin URI: https://github.com/kmiidev
 * Description: A plugin to hide your wordpress sites version number.
 * Author: Kenny
 * Author URI: meadowsii.com
 * Requires at least: 4.3
 * Tested up to: 4.5
 *
 * Text Domain: rm-version
 * Domain Path: /lang/
 *
 * @package WordPress
 * @author Kenny Meadows
 * @since 0.2
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Load plugin class files
require_once( 'includes/class-rm-version.php' );
require_once( 'includes/class-rm-version-settings.php' );

// Load plugin libraries
require_once( 'includes/lib/class-rm-version-admin-api.php' );
require_once( 'includes/lib/class-rm-version-post-type.php' );
require_once( 'includes/lib/class-rm-version-taxonomy.php' );

/**
 * Returns the main instance of RM_Version to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object RM_Version
 */
function RM_Version () {
	$instance = RM_Version::instance( __FILE__, '1.0.0' );

	if ( is_null( $instance->settings ) ) {
		$instance->settings = RM_Version_Settings::instance( $instance );
	}

	return $instance;
}

RM_Version();

// remove version from head
remove_action('wp_head', 'wp_generator');

// remove version from rss
add_filter('the_generator', '__return_empty_string');

// remove version from scripts and styles
function shapeSpace_remove_version_scripts_styles($src) {
	if (strpos($src, 'ver=')) {
		$src = remove_query_arg('ver', $src);
	}
	return $src;
}
add_filter('style_loader_src', 'shapeSpace_remove_version_scripts_styles', 9999);
add_filter('script_loader_src', 'shapeSpace_remove_version_scripts_styles', 9999);