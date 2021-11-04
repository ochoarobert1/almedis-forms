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


/**
 * AlmedisForm Class Controller
 */
class AlmedisForm
{
    const VERSION = '1.0.0';

    /**
     * Method __construct
     *
     * @return void
     */
    public function __construct()
    {
        add_filter('admin_footer_text', array($this, 'almedis_remove_admin_footer_text' ), 11);
        add_filter('update_footer', array($this, 'almedis_remove_admin_footer_text' ), 11);
        add_action('admin_enqueue_scripts', array($this, 'almedis_admin_scripts'), 99);
        add_action('wp_enqueue_scripts', array($this, 'almedis_public_scripts'), 99);
        add_filter('admin_body_class', array($this, 'almedis_admin_body_class' ));
    }
    
    /**
     * Method almedis_remove_admin_footer_text
     *
     * @return false
     */
    public function almedis_remove_admin_footer_text()
    {
        $screen = get_current_screen();
        if (strpos($screen->id, 'almedis') !== false) {
            return null;
        }
    }
    
    /**
     * Method almedis_admin_scripts
     *
     * @return void
     */
    public function almedis_admin_scripts()
    {
        wp_enqueue_style(
            'almedis-admin',
            plugins_url('css/admin-almedis.css', __FILE__),
            [],
            self::VERSION,
            'all'
        );
    }
    
    /**
     * Method almedis_public_scripts
     *
     * @return void
     */
    public function almedis_public_scripts() {
        wp_enqueue_style(
            'almedis-public',
            plugins_url('css/public-almedis.css', __FILE__),
            [],
            self::VERSION,
            'all'
        );
    }

    
    /**
     * Method almedis_admin_body_class
     *
     * @param $classes $classes [explicite description]
     *
     * @return void
     */
    public function almedis_admin_body_class($classes)
    {
        $screen = get_current_screen();
        if (strpos($screen->id, 'almedis') !== false) {
            $classes .= ' almedis-forms';
        }
        return $classes;
    }
}

/**
 * Add dashboard container
 */
require_once('inc/dashboard.php');
require_once('inc/metaboxes.php');
require_once('inc/shortcodes.php');

new AlmedisForm;
