<?php

/**
* Almedis Forms - Historial
*
*
* @package    almedis-forms
* @subpackage activation_hook
*
*/

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class AlmedisHistorial
{
    /**
     * Method create_almedis_historial
     *
     * @param $data $data [explicite description]
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
