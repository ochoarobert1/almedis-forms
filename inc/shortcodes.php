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
        $values = shortcode_atts(array(
            'titulo_natural' => __('Personal Natural', 'almedis'),
            'titulo_convenios' => __('Convenios', 'almedis')
        ), $atts);

        $arr_instituciones = array();

        $query_instituciones = new WP_Query(array(
            'post_type' => 'instituciones',
            'posts_per_page' => -1,
            'order' => 'DESC',
            'orderby' => 'date'
        ));

        if ($query_instituciones->have_posts()) :
            while ($query_instituciones->have_posts()) : $query_instituciones->the_post();
        $arr_instituciones[get_the_ID()] = get_the_title();
        endwhile;
        endif;
        wp_reset_query();

        ob_start(); ?>
<main class="almedis-main-form-container">
    <form action="" class="almedis-form-container almedis-natural-form-container">
        <h2><?php echo $values['titulo_natural']; ?></h2>
        <div class="form-group form-group-empty"></div>
        <div class="form-group">
            <label for="natural_nombre"><?php _e('Nombres y Apellidos', 'almedis'); ?></label>
            <input id="natural_nombre" name="natural_nombre" class="form-control almedis-form-control" type="text" />
        </div>
        <div class="form-group">
            <label for="natural_rut"><?php _e('RUT', 'almedis'); ?></label>
            <input id="natural_rut" name="natural_rut" class="form-control almedis-form-control" type="text" />
        </div>
        <div class="form-group">
            <label for="natural_email"><?php _e('Email', 'almedis'); ?></label>
            <input id="natural_email" name="natural_email" class="form-control almedis-form-control" type="text" />
        </div>
        <div class="form-group">
            <label for="natural_phone"><?php _e('Teléfono / WhatsApp', 'almedis'); ?></label>
            <input id="natural_phone" name="natural_phone" class="form-control almedis-form-control" type="text" />
        </div>
        <div class="form-group form-group-button">
            <label for="natural_medicine"><?php _e('Nombre del Medicamento', 'almedis'); ?></label>
            <input id="natural_medicine" name="natural_medicine" class="form-control almedis-form-control" type="text" />
            <button class="almedis-form-button select_natural_medicine"><?php _e('Adjuntar Récipe', 'almedis'); ?></button>
        </div>
        <div class="form-group">
            <label for="natural_cartapoder"><?php _e('Carta Poder', 'almedis'); ?></label>
            <button class="almedis-form-button select_cartapoder_natural"><?php _e('Adjuntar Carta Poder', 'almedis'); ?></button>
            <p><?php echo sprintf(__('Para poder procesar tu solicitud, debes enviar una carta poder que autorice, si no la tienes, puedes <a href="%s">descargarla aqui.</a>', 'almedis'), '#'); ?></p>
        </div>
        <div class="form-group">
            <label for="natural_password"><?php _e('Crear Contraseña', 'almedis'); ?></label>
            <div class="password-wrapper">
                <input id="natural_password" name="natural_password" class="form-control almedis-form-control" type="password" />
                <span class="almedis-show-password"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="natural_notification"><?php _e('Elija la forma en que desea recibir su cotización', 'almedis'); ?></label>
            <div class="almedis-radio-wrapper">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="natural_notification" id="natural_notification" value="<?php _e('WhatsApp', 'almedis'); ?>"> <?php _e('WhatsApp', 'almedis'); ?>
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="natural_notification" id="natural_notification" value="<?php _e('Correo Electrónico', 'almedis'); ?>"> <?php _e('Correo Electrónico', 'almedis'); ?>
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group submit-group">
            <button id="naturalSubmit" class="btn btn-md btn-cotizar"><?php _e('Cotizar', 'almedis'); ?></button>
        </div>
    </form>
    <form action="" class="almedis-form-container almedis-company-form-container">
        <h2><?php echo $values['titulo_convenios']; ?></h2>
        <?php if (!empty($arr_instituciones)) : ?>
        <div class="form-group">
            <label for="natural_nombre"><?php _e('Institución', 'almedis'); ?></label>
            <select name="convenio_institucion" id="convenio_institucion" class="form-control almedis-form-control">
                <option value="" selected disabled><?php _e('Seleccione Institución', 'almedis'); ?></option>
                <?php foreach ($arr_instituciones as $key => $value) { ?>
                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                <?php } ?>
            </select>
        </div>
        <?php endif; ?>
        <div class="form-group">
            <label for="convenio_nombre"><?php _e('Nombres y Apellidos', 'almedis'); ?></label>
            <input id="convenio_nombre" name="convenio_nombre" class="form-control almedis-form-control" type="text" />
        </div>
        <div class="form-group">
            <label for="convenio_rut"><?php _e('RUT', 'almedis'); ?></label>
            <input id="convenio_rut" name="convenio_rut" class="form-control almedis-form-control" type="text" />
        </div>
        <div class="form-group">
            <label for="convenio_email"><?php _e('Email', 'almedis'); ?></label>
            <input id="convenio_email" name="convenio_email" class="form-control almedis-form-control" type="text" />
        </div>
        <div class="form-group">
            <label for="convenio_phone"><?php _e('Teléfono / WhatsApp', 'almedis'); ?></label>
            <input id="convenio_phone" name="convenio_phone" class="form-control almedis-form-control" type="text" />
        </div>
        <div class="form-group form-group-button">
            <label for="convenio_medicine"><?php _e('Nombre del Medicamento', 'almedis'); ?></label>
            <input id="convenio_medicine" name="convenio_medicine" class="form-control almedis-form-control" type="text" />
            <button class="almedis-form-button select_convenio_medicine"><?php _e('Adjuntar Récipe', 'almedis'); ?></button>
        </div>
        <div class="form-group">
            <label for="convenio_cartapoder"><?php _e('Carta Poder', 'almedis'); ?></label>
            <button class="almedis-form-button select_cartapoder_convenios"><?php _e('Adjuntar Carta Poder', 'almedis'); ?></button>
            <p><?php echo sprintf(__('Para poder procesar tu solicitud, debes enviar una carta poder que autorice, si no la tienes, puedes <a href="%s">descargarla aqui.</a>', 'almedis'), '#'); ?></p>
        </div>
        <div class="form-group">
            <label for="convenio_password"><?php _e('Crear Contraseña', 'almedis'); ?></label>
            <div class="password-wrapper">
                <input id="convenio_password" name="convenio_password" class="form-control almedis-form-control" type="password" />
                <span class="almedis-show-password"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="convenio_notification"><?php _e('Elija la forma en que desea recibir su cotización', 'almedis'); ?></label>
            <div class="almedis-radio-wrapper">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="convenio_notification" id="convenio_notification" value="<?php _e('WhatsApp', 'almedis'); ?>"> <?php _e('WhatsApp', 'almedis'); ?>
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="convenio_notification" id="convenio_notification" value="<?php _e('Correo Electrónico', 'almedis'); ?>"> <?php _e('Correo Electrónico', 'almedis'); ?>
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group submit-group">
            <button id="conveniosSubmit" class="btn btn-md btn-cotizar"><?php _e('Cotizar', 'almedis'); ?></button>
        </div>
    </form>
</main>
<?php
        $shortcode = ob_get_clean();
        return $shortcode;
    }
}

new AlmedisShortcodes;