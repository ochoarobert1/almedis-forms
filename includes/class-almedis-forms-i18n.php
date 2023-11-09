<?php
/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Almedis_Forms
 * @subpackage Almedis_Forms/includes
 * @author     IndexArt <indexart@gmail.com>
 */
class Almedis_Forms_i18n
{
    /**
     * Method load_plugin_textdomain
     *
     * @return void
     */
    public function load_plugin_textdomain()
    {

        load_plugin_textdomain(
            'almedis-forms',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );

    }
}
