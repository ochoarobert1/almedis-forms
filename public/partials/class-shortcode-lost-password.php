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
class Almedis_Forms_Public_Lost_Password
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
        add_shortcode('almedis-lost-password', array($this, 'almedis_forms_callback' ));
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
<?php if (!isset($_GET['pass_nonce'])) : ?>
<form id="almedisLostForm" class="almedis-login-form">
    <div class="almedis-login-form-wrapper">
        <div class="almedis-login-title-wrapper">
            <img src="<?php echo WP_PLUGIN_URL . '/almedis-forms/public/img/logo.png'; ?>" alt="Almedis" class="img-fluid logo" />
            <div class="almedis-login-form-title">
                <h2><?php _e('¿Ha olvidado su contraseña?', 'almedis'); ?></h2>
            </div>
        </div>
        <div class="almedis-login-form-content">
            <div class="almedis-login-form-input-item">
                <label for="username"><?php _e('Ingrese su correo electrónico:', 'almedis'); ?></label>
                <input id="username" class="almedis-form-control" type="email" name="username" autocomplete="username" />
                <small class="form-helper danger hidden"><?php _e('Error: El correo debe ser válido', 'almedis'); ?></small>
            </div>
            <div class="almedis-login-form-input-item">
                <button id="almedisLostSubmit" class="btn btn-md btn-login"><?php _e('Recuperar contraseña', 'almedis'); ?></button>
            </div>
            <div class="almedis-login-form-response-item">
                <div id="loginResult"></div>
            </div>
        </div>
    </div>
</form>
<?php else : ?>
<?php $user = get_user_by('email', $_GET['username']); ?>
<?php if ($user) { ?>
<?php $reset_pass = get_user_meta($user->ID, 'reset_pass', true); ?>
<?php if ($reset_pass == $_GET['pass_nonce']) { ?>
<form id="almedisNewPass" class="almedis-login-form">
    <div class="almedis-login-form-wrapper">
        <div class="almedis-login-title-wrapper">
            <img src="<?php echo WP_PLUGIN_URL . '/almedis-forms/public/img/logo.png'; ?>" alt="Almedis" class="img-fluid logo" />
            <div class="almedis-login-form-title">
                <h2><?php _e('Reestablezca su contraseña', 'almedis'); ?></h2>
            </div>
        </div>
        <div class="almedis-login-form-content">
            <div class="almedis-login-form-input-item">
                <label for="password"><?php _e('Contraseña:', 'almedis'); ?></label>
                <input id="password" class="almedis-form-control" type="password" name="password" autocomplete="current-password" />
                <small class="form-helper danger hidden"><?php _e('Error: La contraseña debe ser válida', 'almedis'); ?></small>
            </div>
            <div class="almedis-login-form-input-item">
                <label for="password-repeat"><?php _e('Repetir Contraseña:', 'almedis'); ?></label>
                <input id="password-repeat" class="almedis-form-control" type="password" name="password-repeat" autocomplete="current-password" />
                <small class="form-helper danger hidden"><?php _e('Error: La contraseña debe ser igual a la anterior', 'almedis'); ?></small>
            </div>
            <div class="almedis-login-form-input-item">
                <input type="hidden" name="username" id="username" value="<?php echo $user->ID; ?>">
                <button id="almedisNewPassSubmit" class="btn btn-md btn-login"><?php _e('Reestablecer contraseña', 'almedis'); ?></button>
            </div>
            <div class="almedis-login-form-response-item">
                <div id="loginResult"></div>
            </div>
        </div>
    </div>
</form>
<?php } else { ?>
<form class="almedis-login-form">
    <div class="almedis-login-title-wrapper">
        <img src="<?php echo WP_PLUGIN_URL . '/almedis-forms/public/img/logo.png'; ?>" alt="Almedis" class="img-fluid logo" />
        <div class="almedis-login-form-title">
            <h2><?php _e('Reestablezca su contraseña', 'almedis'); ?></h2>
        </div>
        <div class="almedis-login-form-content">
            <div class="almedis-login-form-input-item">
                <p>Este link ha expirado, por favor reintente con otro link</p>
            </div>
        </div>
    </div>
</form>
<?php } ?>
<?php } else { ?>
<form class="almedis-login-form">
    <div class="almedis-login-title-wrapper">
        <img src="<?php echo WP_PLUGIN_URL . '/almedis-forms/public/img/logo.png'; ?>" alt="Almedis" class="img-fluid logo" />
        <div class="almedis-login-form-title">
            <h2><?php _e('Reestablezca su contraseña', 'almedis'); ?></h2>
        </div>
        <div class="almedis-login-form-content">
            <div class="almedis-login-form-input-item">
                <p>Este link ha expirado, por favor reintente con otro link</p>
            </div>
        </div>
    </div>
</form>
<?php } ?>

<?php endif; ?>
<?php
        $shortcode = ob_get_clean();
        return $shortcode;
    }
}