<?php
/**
 * Almedis Forms
 *
 * @package           AlmedisForms
 * @author            IndexArt
 * @copyright         2021 IndexArt
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Almedis Forms
 * Plugin URI:        https://indexart.cl
 * Description:       Forms
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            IndexArt
 * Author URI:        https://example.com
 * Text Domain:       almedis-forms
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Update URI:        https://example.com/my-plugin/
 */


if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Method almedis_activation_hook | almedis_deactivation_hook
 *
 * @return void
 */
require_once('inc/activation_hook.php');