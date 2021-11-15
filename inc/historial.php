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
}
