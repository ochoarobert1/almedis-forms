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
class Almedis_Forms_Public_Register_Form
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
        add_shortcode('almedis-registro', array($this, 'almedis_forms_callback' ));
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
        if (isset($_GET['id'])) {
            global $wpdb;
            $results = $wpdb->get_results("select post_id from $wpdb->postmeta where meta_value = '{$_GET['id']}' LIMIT 1", ARRAY_A);
            foreach ($results as $item) {
                $name = get_post_meta($item['post_id'], 'almedis_client_name', true);
                $rut = get_post_meta($item['post_id'], 'almedis_client_rut', true);
                $email = get_post_meta($item['post_id'], 'almedis_client_email', true);
                $phone = get_post_meta($item['post_id'], 'almedis_client_phone', true);
            }
        } else {
            $name = '';
            $rut = '';
            $email = '';
            $phone = '';
        }

        ob_start(); ?>
<main class="almedis-register-form-container">
    <form id="almedisRegistroForm" class="almedis-form-container almedis-registro-form-container">
        <div class="form-group">
            <label for="client_nombre"><?php _e('Nombres y Apellidos', 'almedis'); ?></label>
            <input id="client_nombre" name="client_nombre" class="form-control almedis-form-control" type="text" autocomplete="name" value="<?php echo $name; ?>" />
            <small class="form-helper danger hidden"><?php _e('Error: El nombre debe ser válido', 'almedis'); ?></small>
        </div>
        <div class="form-group">
            <label for="client_rut"><?php _e('RUT', 'almedis'); ?></label>
            <input id="client_rut" name="client_rut" class="form-control almedis-form-control" type="text" autocomplete="rut" value="<?php echo $rut; ?>" />
            <small class="form-helper danger hidden"><?php _e('Error: El RUT debe ser válido', 'almedis'); ?></small>
        </div>
        <div class="form-group">
            <label for="client_email"><?php _e('Email', 'almedis'); ?></label>
            <input id="client_email" name="client_email" class="form-control almedis-form-control" type="text" autocomplete="email" value="<?php echo $email; ?>" />
            <small class="form-helper danger hidden"><?php _e('Error: El correo electrónico debe ser válido', 'almedis'); ?></small>
        </div>
        <div class="form-group">
            <label for="client_phone"><?php _e('Teléfono / WhatsApp', 'almedis'); ?></label>
            <input id="client_phone" name="client_phone" class="form-control almedis-form-control" type="text" autocomplete="tel" value="<?php echo $phone; ?>" />
            <small class="form-helper danger hidden"><?php _e('Error: El teléfono debe ser válido', 'almedis'); ?></small>
        </div>
        <div class="form-group">
            <label for="client_password"><?php _e('Contraseña', 'almedis'); ?></label>
            <input id="client_password" name="client_password" class="form-control almedis-form-control" type="password" autocomplete="password" />
            <small class="form-helper danger hidden"><?php _e('Error: La contraseña debe ser válida', 'almedis'); ?></small>
        </div>
        <div class="form-group">
            <label for="client_confirm_password"><?php _e('Confirmar Contraseña', 'almedis'); ?></label>
            <input id="client_confirm_password" name="client_confirm_password" class="form-control almedis-form-control" type="password" autocomplete="password" />
            <small class="form-helper danger hidden"><?php _e('Error: Las contraseñas no coinciden', 'almedis'); ?></small>
        </div>
        <div class="form-group">
            <label for="client_address"><?php _e('Dirección', 'almedis'); ?></label>
            <textarea id="client_address" name="client_address" class="form-control almedis-form-control" autocomplete="address"></textarea>
            <small class="form-helper danger hidden"><?php _e('Error: La dirección debe ser válida', 'almedis'); ?></small>
        </div>
        <div class="form-group submit-group">
            <button id="registroSubmit" class="btn btn-md btn-cotizar"><?php _e('Registrarme', 'almedis'); ?></button>
            <div id="registroResult"></div>
        </div>
    </form>
    </div>
</main>
<?php
        $shortcode = ob_get_clean();
        return $shortcode;
    }
}
