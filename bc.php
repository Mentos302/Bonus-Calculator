<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package          Bonus_Calculator
 *
 * @wordpress-plugin
 * Plugin Name:       Bonus Calculator
 * Description:       The Bonus Calculator plugin provides a customizable solution for betting websites, allowing administrators to create and manage various bonuses via the WordPress admin panel, with dynamic shortcode embedding for user-friendly access.
 * Version:           1.0.0
 * Author:            Ihor M.
 * Author URI:        http://ihor.co
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       plugin-name
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
define( 'BC_PLUGIN_VERSION', '1.0.0' );


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-bc-activator.php
 */
function activate_bc() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bc-activator.php';
	BC_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-bc-deactivator.php
 */
function deactivate_bc() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bc-deactivator.php';
	BC_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_bc' );
register_deactivation_hook( __FILE__, 'deactivate_bc' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-bc.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_bc() {
	$plugin = new BC();

	$plugin->run();
}
run_bc();


