<?php

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Almedis_Forms
 * @subpackage Almedis_Forms/includes
 * @author     IndexArt <indexart@gmail.com>
 */
class Almedis_Forms_Activator
{
    /**
     * Method activate
     *
     * @return void
     */
    public static function activate()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . "almedis_historial";
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
                ID mediumint(9) NOT NULL AUTO_INCREMENT,
                `desc` text NOT NULL,
                `date` timestamp NOT NULL,
                PRIMARY KEY  (ID)
            ) $charset_collate;";
    
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

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

        add_role(
            'convenios_admin',
            __('Admin Convenios', 'almedis'),
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

        flush_rewrite_rules();
    }
}
