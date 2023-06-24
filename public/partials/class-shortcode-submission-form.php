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
class Almedis_Forms_Public_Submission_Form
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

        $args = array(
            'role'    => 'convenios_admin',
            'orderby' => 'user_nicename',
            'order'   => 'ASC'
        );
        $users = get_users($args);
        foreach ($users as $user) {
            $arr_instituciones[$user->ID] = $user->display_name;
        }

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
                        <option value="<?php _e('Profesional del área de la salud', 'almedis'); ?>"><?php _e('Profesional del área de la salud', 'almedis'); ?></option>
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
                    <label for="natural_recipe_file" class="custom-file-upload">
                        <input id="natural_recipe_file" name="natural_recipe" class="form-control" type="file" />
                        Cargar Receta
                    </label>
                    <small class="form-helper danger hidden"><?php _e('Error: Debe seleccionar una de las opciones', 'almedis'); ?></small>
                    <div class="file-helper natural-file-helper hidden"><span class="almedis-file-icon"></span> <span id="naturalRecetaSelected"></span></div>
                </div>
                <div class="form-group">
                    <small class="form-helper"><?php _e('Para poder procesar tu solicitud, el ISP nos exige una copia de su Carnet de identidad por el lado de la foto y Poder Simple (No notarial) que puede descargarla en la sección Recursos')?></small>
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
                        <option value="<?php _e('Otros', 'almedis'); ?>"><?php _e('Otros', 'almedis'); ?></option>
                    </select>
                    <small class="form-helper danger hidden"><?php _e('Error: Debe seleccionar una opción', 'almedis'); ?></small>
                </div>
                <?php if (!empty($arr_instituciones)) : ?>
                <div class="form-group">
                    <label for="convenio_usuario"><?php _e('Convenio', 'almedis'); ?></label>
                    <select name="convenio_usuario" id="convenio_usuario" class="form-control almedis-form-control">
                        <option value="" selected disabled><?php _e('Seleccione Convenio', 'almedis'); ?></option>
                        <?php foreach ($arr_instituciones as $key => $value) { ?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    </select>
                    <small class="form-helper danger hidden"><?php _e('Error: Debe seleccionar un convenio', 'almedis'); ?></small>
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
                    <label for="convenio_recipe_file" class="custom-file-upload">
                        <input id="convenio_recipe_file" name="convenio_recipe" class="form-control" type="file" />
                        Cargar Receta
                    </label>
                    <small class="form-helper danger hidden"><?php _e('Error: Debe seleccionar una de las opciones', 'almedis'); ?></small>
                    <div class="file-helper convenio-file-helper hidden"><span class="almedis-file-icon"></span> <span id="convenioRecetaSelected"></span></div>
                </div>
                <div class="form-group">
                    <small class="form-helper"><?php _e('Para poder procesar tu solicitud, el ISP nos exige una copia de su Carnet de identidad por el lado de la foto y Poder Simple (No notarial) que puede descargarla en la sección Recursos')?></small>
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