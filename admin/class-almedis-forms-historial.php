<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Almedis_Forms
 * @subpackage Almedis_Forms/admin
 * @author     IndexArt <indexart@gmail.com>
 */
class Almedis_Forms_Historial
{
    private $plugin_name;
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
    * Method create_almedis_historial
    *
    * @param $data $data [string]
    *
    * @return void
    */
    public function create_almedis_historial($data)
    {
        global $wpdb;
        $wpdb->insert(
            $wpdb->prefix . 'almedis_historial',
            array(
                'desc' => $data,
                'date' => null,
            ),
            array(
                '%s',
                '%d',
            )
        );
    }

    /**
     * Method select_almedis_historial
     *
     * @return void
     */
    public function select_almedis_historial()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'almedis_historial';
        $historial = $wpdb->get_results(
            "
                SELECT * 
                FROM $table_name
                ORDER BY ID DESC
            "
        );

        return $historial;
    }

    /**
     * Method get_almedis_historial_type
     *
     * @param $text $text String
     *
     * @return void
     */
    public function get_almedis_historial_type($text)
    {
        $text_array = array();

        $text_array = explode(':', $text);

        return $text_array;
    }
}
