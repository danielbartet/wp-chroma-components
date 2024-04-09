<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
/*
Plugin Name: Chroma Components
Author: Parker Westfall
Description: A collection of code components which extend, override or otherwise introduce custom functionality to my custom wordpress multi-site architecture.
Version: 1.0
NOT LICENSED
*/
add_action( 'admin_footer','wp_print_media_templates' );
/* Components Manifest (Requires) */
// runs through the components folder and requires each file as $component
foreach(glob(plugin_dir_path( __FILE__ ) . "components/*/*.php") as $component) {
	require $component;
}
