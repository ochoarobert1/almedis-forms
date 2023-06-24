<?php

require_once('vendor/autoload.php');

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://indexart.cl
 * @since             1.0.0
 * @package           Almedis_Forms
 *
 * @wordpress-plugin
 * Plugin Name:       Almedis Forms
 * Plugin URI:        https://indexart.cl
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            IndexArt
 * Author URI:        https://indexart.cl
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       almedis-forms
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}



/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('ALMEDIS_FORMS_VERSION', '1.0.0');
if (! defined('ALMEDIS_PLUGIN_BASE')) {
    // in main plugin file
    define('ALMEDIS_PLUGIN_BASE', plugin_dir_path(__FILE__));
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-almedis-forms-activator.php
 */
function activate_almedis_forms()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-almedis-forms-activator.php';
    Almedis_Forms_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-almedis-forms-deactivator.php
 */
function deactivate_almedis_forms()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-almedis-forms-deactivator.php';
    Almedis_Forms_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_almedis_forms');
register_deactivation_hook(__FILE__, 'deactivate_almedis_forms');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-almedis-forms.php';

/**
 * Plugin class core file for AJAX Responses on Admin
 * admin-specific hooks only.
 */
require plugin_dir_path(__FILE__) . 'includes/class-almedis-forms-ajax-admin.php';

/**
 * Plugin class core file for AJAX Responses on Public
 * public-specific hooks only.
 */
require plugin_dir_path(__FILE__) . 'includes/class-almedis-forms-ajax-public.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_almedis_forms()
{
    $plugin = new Almedis_Forms();
    $plugin->run();
}
run_almedis_forms();
