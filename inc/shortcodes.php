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

class AlmedisShortcodes extends AlmedisForm
{
    /**
     * Method __construct
     *
     * @return void
     */
    public function __construct()
    {
        add_action('init', array($this, 'almedis_add_custom_shortcode'));
    }
    
    /**
     * Method almedis_add_custom_shortcode
     *
     * @return void
     */
    public function almedis_add_custom_shortcode()
    {
        add_shortcode('almedis-forms', array($this, 'almedis_forms_callback' ));
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
        $values = shortcode_atts( array(
            'titulo_natural' => __('Personal Natural', 'almedis'),
            'titulo_convenios' => __('Convenios', 'almedis')
        ), $atts );

        ob_start(); ?>
<main class="almedis-main-form-container">
    <form action="" class="almedis-form-container almedis-natural-form-container">
        <h2><?php echo $values['titulo_natural']; ?></h2>
        <div class="form-group">
            <label for="natural_nombre"><?php _e('Nombres y Apellidos', 'almedis'); ?></label>
            <input id="natural_nombre" name="natural_nombre" class="form-control almedis-form-control" type="text" placeholder="" />
        </div>
        <div class="form-group">
            <label for="natural_rut"><?php _e('RUT', 'almedis'); ?></label>
            <input id="natural_rut" name="natural_rut" class="form-control almedis-form-control" type="text" placeholder="" />
        </div>
        <div class="form-group">
            <label for="natural_email"><?php _e('Email', 'almedis'); ?></label>
            <input id="natural_email" name="natural_email" class="form-control almedis-form-control" type="text" placeholder="" />
        </div>
        <div class="form-group">
            <label for="natural_phone"><?php _e('Fono / WhatsApp', 'almedis'); ?></label>
            <input id="natural_phone" name="natural_phone" class="form-control almedis-form-control" type="text" placeholder="" />
        </div>
        <div class="form-group">
            <label for="natural_medicine"><?php _e('Nombre del Medicamento', 'almedis'); ?></label>
            <input id="natural_medicine" name="natural_medicine" class="form-control almedis-form-control" type="text" placeholder="" />
            <button><?php _e('Adjuntar Récipe', 'almedis'); ?></button>
        </div>
        <div class="form-group">
            <label for="natural_medicine"><?php _e('Carta Poder', 'almedis'); ?></label>
            <p>Para poder procesar tu solicitud, debes enviar una carta poder que autorice, si no la tienes, puedes descargarla aqui.</p>
            <button><?php _e('Adjuntar Récipe', 'almedis'); ?></button>
        </div>
        <div class="form-group">
            <label for="natural_password"><?php _e('Crear Contraseña', 'almedis'); ?></label>
            <div class="password-wrapper">
                <input id="natural_password" name="natural_password" class="form-control almedis-form-control" type="passsword" placeholder="" />
                <span></span>
            </div>
        </div>
        <div class="form-group">
            <label for="natural_medicine"><?php _e('Elija la forma en que desea recibir su cotización', 'almedis'); ?></label>
            <label for="natural_medicine"><input id="natural_medicine" name="natural_medicine" class="form-control almedis-form-control" type="checkbox" placeholder="" /><?php _e('Whastapp', 'almedis'); ?></label>
            <label for="natural_medicine"><input id="natural_medicine" name="natural_medicine" class="form-control almedis-form-control" type="checkbox" placeholder="" /><?php _e('Correo Electrónico', 'almedis'); ?></label>


        </div>
        <div class="form-group submit-group">
            <button><?php _e('Cotizar', 'almedis'); ?></button>
        </div>
    </form>
    <form action="" class="almedis-form-container almedis-company-form-container">
        <h2><?php echo $values['titulo_convenios']; ?></h2>
        <div class="form-group">
            <label for="natural_nombre"><?php _e('Nombres y Apellidos', 'almedis'); ?></label>
            <select name="" id=""></select>
        </div>
        <div class="form-group">
            <label for="natural_nombre"><?php _e('Nombres y Apellidos', 'almedis'); ?></label>
            <input id="natural_nombre" name="natural_nombre" class="form-control almedis-form-control" type="text" placeholder="" />
        </div>
        <div class="form-group">
            <label for="natural_rut"><?php _e('RUT', 'almedis'); ?></label>
            <input id="natural_rut" name="natural_rut" class="form-control almedis-form-control" type="text" placeholder="" />
        </div>
        <div class="form-group">
            <label for="natural_email"><?php _e('Email', 'almedis'); ?></label>
            <input id="natural_email" name="natural_email" class="form-control almedis-form-control" type="text" placeholder="" />
        </div>
        <div class="form-group">
            <label for="natural_phone"><?php _e('Fono / WhatsApp', 'almedis'); ?></label>
            <input id="natural_phone" name="natural_phone" class="form-control almedis-form-control" type="text" placeholder="" />
        </div>
        <div class="form-group">
            <label for="natural_medicine"><?php _e('Nombre del Medicamento', 'almedis'); ?></label>
            <input id="natural_medicine" name="natural_medicine" class="form-control almedis-form-control" type="text" placeholder="" />
            <button><?php _e('Adjuntar Récipe', 'almedis'); ?></button>
        </div>
        <div class="form-group">
            <label for="natural_medicine"><?php _e('Carta Poder', 'almedis'); ?></label>
            <p>Para poder procesar tu solicitud, debes enviar una carta poder que autorice, si no la tienes, puedes descargarla aqui.</p>
            <button><?php _e('Adjuntar Récipe', 'almedis'); ?></button>
        </div>
        <div class="form-group">
            <label for="natural_password"><?php _e('Crear Contraseña', 'almedis'); ?></label>
            <div class="password-wrapper">
                <input id="natural_password" name="natural_password" class="form-control almedis-form-control" type="passsword" placeholder="" />
                <span></span>
            </div>
        </div>
        <div class="form-group">
            <label for="natural_medicine"><?php _e('Elija la forma en que desea recibir su cotización', 'almedis'); ?></label>
            <label for="natural_medicine"><input id="natural_medicine" name="natural_medicine" class="form-control almedis-form-control" type="checkbox" placeholder="" /><?php _e('Whastapp', 'almedis'); ?></label>
            <label for="natural_medicine"><input id="natural_medicine" name="natural_medicine" class="form-control almedis-form-control" type="checkbox" placeholder="" /><?php _e('Correo Electrónico', 'almedis'); ?></label>


        </div>
        <div class="form-group submit-group">
            <button><?php _e('Cotizar', 'almedis'); ?></button>
        </div>
    </form>
</main>
<?php
        $shortcode = ob_get_clean();
        return $shortcode;
    }
}

new AlmedisShortcodes;