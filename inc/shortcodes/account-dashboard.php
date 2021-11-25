<?php

/**
* Almedis Dashboard - Shortcodes Creator
*
*
* @package    almedis-forms
* @subpackage shortcodes
*
*/

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class AlmedisAccountDashboard extends AlmedisForm
{
    /**
     * Method __construct
     *
     * @return void
     */
    public function __construct()
    {
        add_action('init', array($this, 'almedis_account_custom_shortcode'));
    }
    
    
    /**
     * Method almedis_add_custom_shortcode
     *
     * @return void
     */
    public function almedis_account_custom_shortcode()
    {
        add_shortcode('almedis-myaccount', array($this, 'almedis_myaccount_callback' ));
    }
    
    /**
     * Method almedis_myaccount_callback
     *
     * @param $atts Array
     * @param $content String
     *
     * @return void
     */
    public function almedis_myaccount_callback($atts, $content = '')
    {
        ob_start(); ?>
<form id="almedisLoginForm" class="almedis-login-form">
    <div class="almedis-login-form-wrapper">
        <div class="almedis-login-form-title">
            <h2><?php _e('Ingrese en su cuenta', 'almedis'); ?></h2>
        </div>
        <div class="almedis-login-form-content">
            <div class="almedis-login-form-input-item">
                <label for="username"><?php _e('Nombre de Usuario / Correo Electrónico:', 'almedis'); ?></label>
                <input id="username" class="almedis-form-control" type="text" name="username" autocomplete="username" />
                <small class="form-helper danger hidden"><?php _e('Error: El nombre debe ser válido', 'almedis'); ?></small>
            </div>
            <div class="almedis-login-form-input-item">
                <label for="password"><?php _e('Contraseña:', 'almedis'); ?></label>
                <input id="password" class="almedis-form-control" type="password" name="password" autocomplete="current-password" />
                <small class="form-helper danger hidden"><?php _e('Error: La contraseña debe ser válida', 'almedis'); ?></small>
            </div>

            <div class="almedis-login-form-input-item">
                <button id="almedisLoginSubmit" class="btn btn-md btn-login"><?php _e('Login', 'almedis'); ?></button>
            </div>

            <div class="almedis-login-form-input-item">
                <div id="loginResult"></div>
            </div>
        </div>
    </div>
</form>
<?php
        $content = ob_get_clean();
        return $content;
    }
}

new AlmedisAccountDashboard;