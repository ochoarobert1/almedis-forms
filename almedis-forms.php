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
class almedisActivation
{
    /**
     * Method almedis_historial_db
     *
     * @return void
     */
    public function almedis_historial_db()
    {
        global $wpdb;
        $database_version = get_option('almedis_db_version');
        if ($database_version != '1.0.0') {
            $table_name = $wpdb->prefix . "almedis_historial";
            $almedis_db_version = '1.0.0';
            $charset_collate = $wpdb->get_charset_collate();
    
            if ($wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name) {
                $sql = "CREATE TABLE $table_name (
                ID mediumint(9) NOT NULL AUTO_INCREMENT,
                `desc` text NOT NULL,
                `date` timestamp NOT NULL,
                PRIMARY KEY  (ID)
            ) $charset_collate;";
    
                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                dbDelta($sql);
                add_option('almedis_db_version', $almedis_db_version);
            }
        }

        if (get_option('almedis_client_roles') < 1) {
            add_role(
                'almedis_client',
                __('Cliente', 'almedis'),
                array(
                    'read'  => false,
                    'delete_posts'  => false,
                    'delete_published_posts' => false,
                    'edit_posts'   => false,
                    'publish_posts' => false,
                    'upload_files'  => false,
                    'edit_pages'  => false,
                    'edit_published_pages'  =>  false,
                    'publish_pages'  => false,
                    'delete_published_pages' => false
                )
            );
            add_role(
                'almedis_admin',
                __('Admin Institución', 'almedis'),
                array(
                    'read'  => false,
                    'delete_posts'  => false,
                    'delete_published_posts' => false,
                    'edit_posts'   => false,
                    'publish_posts' => false,
                    'upload_files'  => false,
                    'edit_pages'  => false,
                    'edit_published_pages'  =>  false,
                    'publish_pages'  => false,
                    'delete_published_pages' => false
                )
            );
            update_option('almedis_client_roles', 1);
        }

        flush_rewrite_rules();
    }
}

/**
 * Method almedis_activate
 *
 * @return void
 */

register_activation_hook(__FILE__, array( 'almedisActivation', 'almedis_historial_db' ));
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
        global $typenow;
        wp_enqueue_style(
            'almedis-admin',
            plugins_url('css/admin-almedis.css', __FILE__),
            [],
            self::VERSION,
            'all'
        );

        wp_enqueue_script(
            'almedis-admin',
            plugins_url('js/admin-almedis.js', __FILE__),
            ['jquery'],
            self::VERSION,
            true
        );
        
        if ($typenow == 'instituciones') {
            wp_enqueue_media();
            wp_localize_script(
                'almedis-admin',
                'meta_image',
                array(
                    'title' => __('Choose or Upload Media', 'events'),
                    'button' => __('Use this media', 'events'),
                )
            );
        }
    }
    
    /**
     * Method almedis_public_scripts
     *
     * @return void
     */
    public function almedis_public_scripts()
    {
        wp_enqueue_style(
            'almedis-public',
            plugins_url('css/public-almedis.css', __FILE__),
            [],
            self::VERSION,
            'all'
        );

        wp_enqueue_script(
            'almedis-public',
            plugins_url('js/public-almedis.min.js', __FILE__),
            [],
            self::VERSION,
            true
        );

        wp_register_script(
            'almedis-forms',
            plugins_url('js/public-almedis-forms.min.js', __FILE__),
            ['almedis-public'],
            self::VERSION,
            true
        );

        wp_register_script(
            'almedis-login',
            plugins_url('js/public-almedis-login.js', __FILE__),
            ['almedis-public'],
            self::VERSION,
            true
        );

        wp_localize_script(
            'almedis-public',
            'custom_admin_url',
            array(
                'ajax_url' => admin_url('admin-ajax.php')
            )
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
require_once('inc/post_types.php');
require_once('inc/dashboard.php');
require_once('inc/metaboxes.php');
require_once('inc/historial.php');
require_once('inc/shortcodes/submission-form.php');
require_once('inc/shortcodes/account-dashboard.php');
require_once('inc/notifications.php');
require_once('inc/ajax_functions.php');


new AlmedisForm;
