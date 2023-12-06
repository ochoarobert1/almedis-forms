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
class Almedis_Forms_Public_Testimonial_Form
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
        add_shortcode('almedis-testimonial-forms', array($this, 'almedis_forms_callback' ));
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
<main class="almedis-testimonial-form-container">
    <form id="almedisTestForm" class="almedis-form-container almedis-test-form-container">
        <div class="form-group">
            <label for="test_nombre"><?php _e('Nombres y Apellidos', 'almedis'); ?></label>
            <input id="test_nombre" name="test_nombre" class="form-control almedis-form-control" type="text" autocomplete="name" />
            <small class="form-helper danger hidden"><?php _e('Error: El nombre debe ser válido', 'almedis'); ?></small>
        </div>
        <div class="form-group">
            <label for="test_institucion"><?php _e('Institución', 'almedis'); ?></label>
            <input id="test_institucion" name="test_institucion" class="form-control almedis-form-control" type="text" autocomplete="business" />
            <small class="form-helper danger hidden"><?php _e('Error: La institución debe ser válida', 'almedis'); ?></small>
        </div>
        <div class="form-group">
            <label for="test_message"><?php _e('Testimonio', 'almedis'); ?></label>
            <textarea id="test_message" name="test_message" class="form-control almedis-form-control"></textarea>
            <small class="form-helper danger hidden"><?php _e('Error: El testimonio no puede estar vacio', 'almedis'); ?></small>
        </div>
        <div class="form-group submit-group">
            <button id="testSubmit" class="btn btn-md btn-cotizar"><?php _e('Enviar testimonio', 'almedis'); ?></button>
            <div id="testResult"></div>
        </div>
    </form>
</main>
<?php
        $shortcode = ob_get_clean();
        return $shortcode;
    }
}