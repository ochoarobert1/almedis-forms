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
class Almedis_Forms_Public_Login_Button
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
        add_shortcode('almedis-login-button', array($this, 'almedis_forms_callback' ));
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
<?php if (is_user_logged_in()) : ?>
<div class="btn-custom-login">
    <a href="#" class="btn-custom-opener btn-custom-opener-logged"><i class="fa fa-user-o"></i> <span><?php _e('Mi Cuenta', 'almedis'); ?></span> <i class="fa fa-chevron-down"></i></a>
    <ul class="dropdown-menu">
        <li><a href="<?php echo home_url('/mi-cuenta'); ?>"><?php _e('Mi Cuenta', 'almedis'); ?></a></li>
        <li><a href="<?php echo home_url('/registrar-pago'); ?>"><?php _e('Registrar Pago', 'almedis'); ?></a></li>
        <li><a href="<?php echo wp_logout_url(home_url('/mi-cuenta')); ?>"><?php _e('Cerrar Sesión', 'almedis'); ?></a></li>
    </ul>
    <p class="welcome-text">Bienvenido, <?php echo do_shortcode('[almedis_user]'); ?></p>
</div>
<?php else : ?>
<div class="btn-custom-login">
    <a href="<?php echo home_url('/mi-cuenta'); ?>" class="btn-custom-opener"><i class="fa fa-user-o"></i> <span><?php _e('Iniciar Sesión', 'almedis'); ?></span></a>
</div>
<?php endif; ?>
<?php
        $shortcode = ob_get_clean();
        return $shortcode;
    }
}