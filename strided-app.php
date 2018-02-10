<?php

/**
 * The plugin bootstrap file
 *
 * @link              https://raquelmsmith.com
 * @since             1.0.0
 * @package           Strided_App
 *
 * @wordpress-plugin
 * Plugin Name:       Strided App
 * Plugin URI:        http://stridedsolutions.com/
 * Description:       The custom functionality for the Strided website. Registers custom post types for horses, arenas, and runs and creates public views for this data using shortcodes.
 * Version:           1.0.0
 * Author:            raquelmsmith
 * Author URI:        https://raquelmsmith.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       strided-app
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
define( 'STEIDED_APP_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-strided-app-activator.php
 */
function activate_strided_app() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-strided-app-activator.php';
	Strided_App_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-strided-app-deactivator.php
 */
function deactivate_strided_app() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-strided-app-deactivator.php';
	Strided_App_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_strided_app' );
register_deactivation_hook( __FILE__, 'deactivate_strided_app' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-strided-app.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_strided_app() {

	$plugin = new Strided_App();
	$plugin->run();

}
run_strided_app();
