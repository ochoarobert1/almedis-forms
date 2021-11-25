<?php

/**
* Almedis Dashboard - Submission Form Shortcode
*
*
* @package    almedis-forms
* @subpackage shortcodes
*
*/

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class AlmedisSubmissionForm extends AlmedisForm
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
        wp_enqueue_script('almedis-forms');
        
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
    <ul class="almedis-tabs-buttons">
        <li><a href="" data-tab="naturalForm" class="almedis-tab almedis-tab-active"><?php echo $values['titulo_natural']; ?></a></li>
        <li><a href="" data-tab="conveniosForm" class="almedis-tab"><?php echo $values['titulo_convenios']; ?></a></li>
    </ul>
    <div class="almedis-tabs-container">
        <aside id="naturalForm" class="almedis-content-tab almedis-natural-tab">
            <form enctype="multipart/form-data" id="almedisNaturalForm" class="almedis-form-container almedis-natural-form-container">
                <div class="form-group">
                    <label for="natural_type"><?php _e('¿Es usted un...', 'almedis'); ?></label>
                    <select name="natural_type" id="natural_type" class="form-control almedis-form-control">
                        <option value="" selected disabled><?php _e('Por favor, seleccione una opción', 'almedis'); ?></option>
                        <option value="<?php _e('Paciente', 'almedis'); ?>"><?php _e('Paciente', 'almedis'); ?></option>
                        <option value="<?php _e('Familia o amigo de un paciente', 'almedis'); ?>"><?php _e('Familia o amigo de un paciente', 'almedis'); ?></option>
                        <option value="<?php _e('Doctor', 'almedis'); ?>"><?php _e('Doctor', 'almedis'); ?></option>
                        <option value="<?php _e('Fundación o Corporación', 'almedis'); ?>"><?php _e('Fundación o Corporación', 'almedis'); ?></option>
                        <option value="<?php _e('Representante de un hospital / empresa', 'almedis'); ?>"><?php _e('Representante de un hospital / empresa', 'almedis'); ?></option>
                        <option value="<?php _e('Otros', 'almedis'); ?>"><?php _e('Otros', 'almedis'); ?></option>
                    </select>
                    <small class="form-helper danger hidden"><?php _e('Error: Debe seleccionar una opción', 'almedis'); ?></small>
                </div>
                <div class="form-group">
                    <label for="natural_nombre"><?php _e('Nombres y Apellidos', 'almedis'); ?></label>
                    <input id="natural_nombre" name="natural_nombre" class="form-control almedis-form-control" type="text" autocomplete="name" />
                    <small class="form-helper danger hidden"><?php _e('Error: El nombre debe ser válido', 'almedis'); ?></small>
                </div>
                <div class="form-group">
                    <label for="natural_rut"><?php _e('RUT', 'almedis'); ?></label>
                    <input id="natural_rut" name="natural_rut" class="form-control almedis-form-control" type="text" autocomplete="rut" />
                    <small class="form-helper danger hidden"><?php _e('Error: El RUT debe ser válido', 'almedis'); ?></small>
                </div>
                <div class="form-group">
                    <label for="natural_email"><?php _e('Email', 'almedis'); ?></label>
                    <input id="natural_email" name="natural_email" class="form-control almedis-form-control" type="text" autocomplete="email" />
                    <small class="form-helper danger hidden"><?php _e('Error: El correo electrónico debe ser válido', 'almedis'); ?></small>
                </div>
                <div class="form-group">
                    <label for="natural_phone"><?php _e('Teléfono / WhatsApp', 'almedis'); ?></label>
                    <input id="natural_phone" name="natural_phone" class="form-control almedis-form-control" type="text" autocomplete="tel" />
                    <small class="form-helper danger hidden"><?php _e('Error: El teléfono debe ser válido', 'almedis'); ?></small>
                </div>
                <div class="form-group form-group-button">
                    <label for="natural_medicine"><?php _e('Nombre del Medicamento', 'almedis'); ?></label>
                    <input id="natural_medicine" name="natural_medicine" class="form-control almedis-form-control" type="text" />
                    <small class="form-helper danger hidden"><?php _e('Error: El nombre del medicamento debe ser válido', 'almedis'); ?></small>
                </div>
                <div class="form-group">
                    <label for="natural_notification"><?php _e('Elija la forma en que desea recibir su cotización', 'almedis'); ?></label>
                    <div class="almedis-radio-wrapper">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input almedis-form-control" type="radio" name="natural_notification" value="<?php _e('Teléfono', 'almedis'); ?>"> <?php _e('Teléfono', 'almedis'); ?>
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input almedis-form-control" type="radio" name="natural_notification" value="<?php _e('WhatsApp', 'almedis'); ?>"> <?php _e('WhatsApp', 'almedis'); ?>
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input almedis-form-control" type="radio" name="natural_notification" value="<?php _e('Correo Electrónico', 'almedis'); ?>"> <?php _e('Correo Electrónico', 'almedis'); ?>
                            </label>
                        </div>
                    </div>
                    <small class="form-helper danger hidden"><?php _e('Error: Debe seleccionar una de las opciones', 'almedis'); ?></small>
                </div>
                <div class="form-group submit-group">
                    <button id="naturalSubmit" class="btn btn-md btn-cotizar"><?php _e('Cotizar', 'almedis'); ?></button>
                    <div id="naturalResult"></div>
                </div>
            </form>
        </aside>

        <aside id="conveniosForm" class="almedis-content-tab almedis-convenios-tab hidden">
            <form enctype="multipart/form-data" id="almedisConveniosForm" class="almedis-form-container almedis-company-form-container">
                <div class="form-group">
                    <label for="convenio_type"><?php _e('¿Es usted un...', 'almedis'); ?></label>
                    <select name="convenio_type" id="convenio_type" class="form-control almedis-form-control">
                        <option value="" selected disabled><?php _e('Por favor, seleccione una opción', 'almedis'); ?></option>
                        <option value="<?php _e('Paciente', 'almedis'); ?>"><?php _e('Paciente', 'almedis'); ?></option>
                        <option value="<?php _e('Familia o amigo de un paciente', 'almedis'); ?>"><?php _e('Familia o amigo de un paciente', 'almedis'); ?></option>
                        <option value="<?php _e('Doctor', 'almedis'); ?>"><?php _e('Doctor', 'almedis'); ?></option>
                        <option value="<?php _e('Fundación o Corporación', 'almedis'); ?>"><?php _e('Fundación o Corporación', 'almedis'); ?></option>
                        <option value="<?php _e('Representante de un hospital / empresa', 'almedis'); ?>"><?php _e('Representante de un hospital / empresa', 'almedis'); ?></option>
                        <option value="<?php _e('Otros', 'almedis'); ?>"><?php _e('Otros', 'almedis'); ?></option>
                    </select>
                    <small class="form-helper danger hidden"><?php _e('Error: Debe seleccionar una opción', 'almedis'); ?></small>
                </div>
                <?php if (!empty($arr_instituciones)) : ?>
                <div class="form-group">
                    <label for="convenio_institucion"><?php _e('Institución', 'almedis'); ?></label>
                    <select name="convenio_institucion" id="convenio_institucion" class="form-control almedis-form-control">
                        <option value="" selected disabled><?php _e('Seleccione Institución', 'almedis'); ?></option>
                        <?php foreach ($arr_instituciones as $key => $value) { ?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    </select>
                    <small class="form-helper danger hidden"><?php _e('Error: Debe seleccionar una institución', 'almedis'); ?></small>
                </div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="convenio_nombre"><?php _e('Nombres y Apellidos', 'almedis'); ?></label>
                    <input id="convenio_nombre" name="convenio_nombre" class="form-control almedis-form-control" type="text" autocomplete="name" />
                    <small class="form-helper danger hidden"><?php _e('Error: El nombre debe ser válido', 'almedis'); ?></small>
                </div>
                <div class="form-group">
                    <label for="convenio_rut"><?php _e('RUT', 'almedis'); ?></label>
                    <input id="convenio_rut" name="convenio_rut" class="form-control almedis-form-control" type="text" autocomplete="rut" />
                    <small class="form-helper danger hidden"><?php _e('Error: El RUT debe ser válido', 'almedis'); ?></small>
                </div>
                <div class="form-group">
                    <label for="convenio_email"><?php _e('Email', 'almedis'); ?></label>
                    <input id="convenio_email" name="convenio_email" class="form-control almedis-form-control" type="text" autocomplete="email" />
                    <small class="form-helper danger hidden"><?php _e('Error: El correo electrónico debe ser válido', 'almedis'); ?></small>
                </div>
                <div class="form-group">
                    <label for="convenio_phone"><?php _e('Teléfono / WhatsApp', 'almedis'); ?></label>
                    <input id="convenio_phone" name="convenio_phone" class="form-control almedis-form-control" type="text" autocomplete="tel" />
                    <small class="form-helper danger hidden"><?php _e('Error: El teléfono debe ser válido', 'almedis'); ?></small>
                </div>
                <div class="form-group form-group-button">
                    <label for="convenio_medicine"><?php _e('Nombre del Medicamento', 'almedis'); ?></label>
                    <input id="convenio_medicine" name="convenio_medicine" class="form-control almedis-form-control" type="text" />
                    <small class="form-helper danger hidden"><?php _e('Error: El nombre del medicamento debe ser válido', 'almedis'); ?></small>
                </div>
                <div class="form-group">
                    <label for="convenio_notification"><?php _e('Elija la forma en que desea recibir su cotización', 'almedis'); ?></label>
                    <div class="almedis-radio-wrapper">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input almedis-form-control" type="radio" name="convenio_notification" value="<?php _e('Teléfono', 'almedis'); ?>"> <?php _e('Teléfono', 'almedis'); ?>
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input almedis-form-control" type="radio" name="convenio_notification" value="<?php _e('WhatsApp', 'almedis'); ?>"> <?php _e('WhatsApp', 'almedis'); ?>
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input almedis-form-control" type="radio" name="convenio_notification" value="<?php _e('Correo Electrónico', 'almedis'); ?>"> <?php _e('Correo Electrónico', 'almedis'); ?>
                            </label>
                        </div>
                    </div>
                    <small class="form-helper danger hidden"><?php _e('Error: Debe seleccionar una de las opciones', 'almedis'); ?></small>
                </div>
                <div class="form-group submit-group">
                    <button id="convenioSubmit" class="btn btn-md btn-cotizar"><?php _e('Cotizar', 'almedis'); ?></button>
                    <div id="convenioResult"></div>
                </div>
            </form>
        </aside>
    </div>
</main>
<?php
        $shortcode = ob_get_clean();
        return $shortcode;
    }
}

new AlmedisSubmissionForm;
