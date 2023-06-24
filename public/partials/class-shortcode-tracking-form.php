<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://indexart.cl
 * @since      1.0.0
 *
 * @package    Almedis_Forms
 * @subpackage Almedis_Forms/admin
 */

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
class Almedis_Forms_Public_Tracking_Form
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
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
     * Method almedis_add_custom_shortcode
     *
     * @return void
     */
    public function almedis_add_custom_shortcode()
    {
        add_shortcode('almedis-tracking', array($this, 'almedis_forms_callback' ));
    }
    
    /**
     * Method almedis_forms_callback
     *
     * @param $atts Array
     * @param $content String
     *
     * @return void
     */
    public function almedis_forms_callback($atts, $content = '')
    {
        ob_start(); ?>
<main class="almedis-tracking-form-container">
    <form enctype="multipart/form-data" id="almedisTrackingForm" class="almedis-tracking-container">
        <div class="form-group">
            <label for="payment_pedido"><?php _e('Ingrese el código del pedido a consultar', 'almedis'); ?></label>
            <input id="payment_pedido" name="payment_pedido" class="form-control almedis-form-control" type="text" />
            <small class="form-helper danger hidden"><?php _e('Error: Este campo no puede estar vacio', 'almedis'); ?></small>
        </div>

        <div class="form-group submit-group">
            <button id="trackingSubmit" class="btn btn-md btn-cotizar"><?php _e('Consultar Tracking de Pedido', 'almedis'); ?></button>
        </div>
    </form>
    <div id="trackingResult"></div>
</main>
<?php
        $shortcode = ob_get_clean();
        return $shortcode;
    }
}