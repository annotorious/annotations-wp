<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://victortemprano.com
 * @since             1.0.0
 * @package           Annotations_Wp
 *
 * @wordpress-plugin
 * Plugin Name:       Annotations WP
 * Plugin URI:        https://example-recogito.com
 * Description:       This plugin integrates Recogito and Annotorious into Wordpress.
 * Version:           1.0.0
 * Author:            Victor Temprano
 * Author URI:        https://victortemprano.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       annotations-wp
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'ANNOTATIONS_WP_VERSION', '0.1.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-annotations-wp-activator.php
 */
function activate_annotations_wp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-annotations-wp-activator.php';
	Annotations_Wp_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-annotations-wp-deactivator.php
 */
function deactivate_annotations_wp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-annotations-wp-deactivator.php';
	Annotations_Wp_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_annotations_wp' );
register_deactivation_hook( __FILE__, 'deactivate_annotations_wp' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-annotations-wp.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_annotations_wp() {

	$plugin = new Annotations_Wp();
	$plugin->run();

}
run_annotations_wp();
