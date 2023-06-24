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
class Almedis_Forms_Public_Pedido_Confirmation
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
        add_shortcode('almedis-confirmation', array($this, 'almedis_forms_callback' ));
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
        ob_start(); 
        if (is_user_logged_in()) {
        ?>
<main class="almedis-confirmation-form-container">
    <form enctype="multipart/form-data" id="almedisConfirmationForm" class="almedis-form-container">
        <div class="form-group">
            <label for="payment_pedido"><?php _e('Ingrese el código del pedido a confirmar', 'almedis'); ?></label>
            <input id="payment_pedido" name="payment_pedido" class="form-control almedis-form-control" type="text" />
            <small class="form-helper danger hidden"><?php _e('Error: Este campo no puede estar vacio', 'almedis'); ?></small>
        </div>
        <div class="form-group">
            <label for="payment_cartapoder"><?php _e('¿Ya cargó su carta poder al sistema?', 'almedis'); ?></label>
            <div class="almedis-radio-wrapper">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input almedis-form-control" type="radio" name="payment_cartapoder" value="<?php _e('si', 'almedis'); ?>"> <?php _e('Si', 'almedis'); ?>
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input almedis-form-control" type="radio" name="payment_cartapoder" value="<?php _e('no', 'almedis'); ?>"> <?php _e('No', 'almedis'); ?>
                    </label>
                </div>
            </div>
            <small class="form-helper danger hidden"><?php _e('Error: Debe seleccionar una de las opciones', 'almedis'); ?></small>
        </div>
        <div id="cartaPoderFileWrapper" class="form-group hidden">
            <label for="payment_cartapoder_file" class="custom-file-upload">
                <input id="payment_cartapoder_file" type="file" />
                Cargar Carta Poder
            </label>
            <small class="form-helper danger hidden"><?php _e('Error: Debe seleccionar una de las opciones', 'almedis'); ?></small>
            <div class="file-helper hidden"><span class="almedis-file-icon"></span> <span id="fileSelected"></span></div>
        </div>
        <div class="form-group">
            <small class="form-helper"><?php _e('Para poder procesar tu solicitud, debes enviar una carta poder que autorice el pedido, si no la tienes, puedes descargarla en la sección de recursos.')?></small>
        </div>
        <div class="form-group">
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input class="form-check-input almedis-form-control" type="checkbox" name="payment_consent" value="<?php _e('si', 'almedis'); ?>"> <?php _e('Acepto los términos y condiciones del procesamiento de datos y gestión de envío', 'almedis'); ?>
                </label>
            </div>
            <small class="form-helper danger hidden"><?php _e('Error: Debe confirmar este consentimiento', 'almedis'); ?></small>
        </div>

        <div class="form-group submit-group">
            <button id="confirmationSubmit" class="btn btn-md btn-cotizar"><?php _e('Confirmar Pedido', 'almedis'); ?></button>
            <div id="confirmationResult"></div>
        </div>
    </form>
</main>
<?php
        } else {
            ?>
<main class="not-logged-container">
    <div class="not-logged-content">
        <h2><?php _e('Debes haber iniciado sesión para ingresar en esta zona', 'almedis'); ?></h2>
        <div class="not-logged-buttons">
            <a href="<?php echo home_url('/mi-cuenta'); ?>" class="btn btn-login"><?php _e('Iniciar Sesión', 'almedis')?></a>
        </div>
    </div>
</main>
            <?php
        }
        $shortcode = ob_get_clean();
        return $shortcode;
    }
}