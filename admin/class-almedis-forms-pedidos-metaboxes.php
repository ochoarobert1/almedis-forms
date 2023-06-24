<?php
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
class Almedis_Forms_Pedidos_Metaboxes
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
     * Method pedidos_add_meta_box
     * Adds the meta box container.
     *
     * @param   $post_type
     * @since   1.0.0
     * @return  void
     */
    public function pedidos_add_meta_box($post_type)
    {
        // Limit meta box to certain post types.
        $post_types = array('pedidos');
  
        if (in_array($post_type, $post_types)) {
            // Main Pedidos Info
            add_meta_box(
                'almedis_metabox',
                __('Información del Pedido', 'almedis'),
                array( $this, 'render_pedidos_meta_box_content' ),
                $post_type,
                'advanced',
                'high'
            );

            // Clientes Info
            add_meta_box(
                'almedis_type_metabox',
                __('Cliente del Pedido', 'almedis'),
                array( $this, 'render_type_meta_box_content' ),
                $post_type,
                'side',
                'high'
            );

            // Status Info
            add_meta_box(
                'almedis_status_metabox',
                __('Estatus del Pedido', 'almedis'),
                array( $this, 'render_status_meta_box_content' ),
                $post_type,
                'side',
                'high'
            );

            // Payment Info
            add_meta_box(
                'almedis_admin_metabox',
                __('Administración y Pagos del Pedido', 'almedis'),
                array( $this, 'render_admin_meta_box_content' ),
                $post_type,
                'advanced',
                'high'
            );
        }
    }

    /**
     * Method render_pedidos_meta_box_content
     * Render Meta Box content.
     *
     * @param   WP_Post $post The post object.
     * @since   1.0.0
     * @return  void
     */
    public function render_pedidos_meta_box_content($post)
    {
        ?>
<div class="almedis-custom-metabox-wrapper">
    <?php wp_nonce_field('almedis_forms', 'almedis_forms_nonce'); ?>
    <input type="hidden" name="current_user_id" value="<?php echo get_current_user_id(); ?>">

    <h2><?php echo get_the_title(); ?></h2>

    <div class="almedis-custom-metabox-item">
        <label for="almedis_client_tipo">
            <?php _e('Código Único', 'almedis'); ?>
        </label>
        <code><?php echo get_post_meta($post->ID, 'almedis_unique_id', true); ?></code>
    </div>

    <?php $value = get_post_meta($post->ID, 'almedis_pedido_confirmation', true); ?>
    <div class="almedis-custom-metabox-item">
        <label for="almedis_pedido_confirmation">
            <?php _e('Confirmación:', 'almedis'); ?>
        </label>
        <?php if ($value == true) {?>
        <code class="almedis-confirmed">&#10004;&#65039; <?php _e('Pedido Confirmado', 'almedis'); ?></code>
        <?php } else { ?>
        <code class="almedis-not-confirmed"> <?php _e('Pedido No Confirmado', 'almedis'); ?></code>
        <?php } ?>
    </div>

    <div class="almedis-custom-metabox-item">
        <label for="almedis_client_tipo">
            <?php _e('Tipo de Cliente', 'almedis'); ?>
        </label>
        <?php $value = get_post_meta($post->ID, 'almedis_client_tipo', true); ?>
        <select name="almedis_client_tipo" id="almedis_client_tipo" class="form-control">
            <option value="Paciente" <?php selected($value, 'Paciente'); ?>>Paciente</option>
            <option value="Familia o amigo de un paciente" <?php selected($value, 'Familia o amigo de un paciente'); ?>>Familia o amigo de un paciente</option>
            <option value="Profesional del área de la salud" <?php selected($value, 'Profesional del área de la salud'); ?>>Profesional del área de la salud</option>
            <option value="Fundación o Corporación" <?php selected($value, 'Fundación o Corporación'); ?>>Fundación o Corporación</option>
            <option value="Paciente" <?php selected($value, 'Paciente'); ?>>Paciente</option>
            <option value="Representante de un hospital / empresa" <?php selected($value, 'Representante de un hospital / empresa'); ?>>Representante de un hospital / empresa</option>
            <option value="Otros" <?php selected($value, 'Otros'); ?>>Otros</option>
        </select>
    </div>

    <div class="almedis-custom-metabox-item">
        <label for="almedis_client_name">
            <?php _e('Nombres y Apellidos', 'almedis'); ?>
        </label>
        <?php $value = get_post_meta($post->ID, 'almedis_client_name', true); ?>
        <input id="almedis_client_name" name="almedis_client_name" type="text" class="form-control" value="<?php echo $value; ?>" />
    </div>

    <div class="almedis-custom-metabox-item">
        <label for="almedis_client_rut">
            <?php _e('RUT', 'almedis'); ?>
        </label>
        <?php $value = get_post_meta($post->ID, 'almedis_client_rut', true); ?>
        <input id="almedis_client_rut" name="almedis_client_rut" type="text" class="form-control" value="<?php echo $value; ?>" />
    </div>

    <div class="almedis-custom-metabox-item">
        <label for="almedis_client_email">
            <?php _e('Correo Electrónico', 'almedis'); ?>
        </label>
        <?php $value = get_post_meta($post->ID, 'almedis_client_email', true); ?>
        <input id="almedis_client_email" name="almedis_client_email" type="text" class="form-control" value="<?php echo $value; ?>" />
    </div>

    <div class="almedis-custom-metabox-item">
        <label for="almedis_client_phone">
            <?php _e('Teléfono / WhatsApp', 'almedis'); ?>
        </label>
        <?php $value = get_post_meta($post->ID, 'almedis_client_phone', true); ?>
        <input id="almedis_client_phone" name="almedis_client_phone" type="text" class="form-control" value="<?php echo $value; ?>" />
    </div>

    <?php $value = get_post_meta($post->ID, 'almedis_client_user', true); ?>
    <?php if ($value != '') { ?>
    <div class="almedis-custom-metabox-item">
        <label for="almedis_client_dir">
            <?php _e('Dirección', 'almedis'); ?>
        </label>
        <?php $user = get_user_by('ID', $value); ?>
        <?php $dir = get_user_meta($user->ID, 'almedis_user_address', true); ?>
        <input id="almedis_client_dir" name="almedis_client_dir" type="text" class="form-control" value="<?php echo $dir; ?>" />
    </div>
    <?php } ?>


    <div class="almedis-custom-metabox-item">
        <label for="almedis_client_medicine">
            <?php _e('Nombre del Medicamento', 'almedis'); ?>
        </label>
        <?php $value = get_post_meta($post->ID, 'almedis_client_medicine', true); ?>
        <input id="almedis_client_medicine" name="almedis_client_medicine" type="text" class="form-control" value="<?php echo $value; ?>" />
    </div>

    <div class="almedis-custom-metabox-item">
        <label for="almedis_client_notification">
            <?php _e('Recepción de Cotización', 'almedis'); ?>
        </label>
        <?php $value = get_post_meta($post->ID, 'almedis_client_notification', true); ?>
        <input id="almedis_client_notification" name="almedis_client_notification" type="text" class="form-control" value="<?php echo $value; ?>" />
    </div>

    <div class="almedis-custom-metabox-item">
        <label for="almedis_client_user">
            <?php _e('Usuario del Pedido', 'almedis'); ?>
        </label>
        <?php $value = get_post_meta($post->ID, 'almedis_client_user', true); ?>
        <div class="current-user">
            <span class="almedis-user-icon"></span>
            <?php $blogusers = get_users(array( 'role__in' => array( 'administrator', 'almedis_client' ) )); ?>
            <select name="almedis_client_user" id="almedis_client_user">
                <option value=""><?php _e('Seleccione una opción'); ?></option>
                <?php foreach ($blogusers as $user) { ?>
                <option value="<?php echo esc_attr($user->ID); ?>" <?php selected($value, $user->ID); ?>><?php echo esc_html($user->display_name) . ' - ' . esc_html($user->user_email); ?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="almedis-custom-metabox-documents">
        <h3><?php _e('Documentos Requeridos', 'almedis'); ?></h3>

        <div class="almedis-custom-metabox-document-wrapper">
            <?php $value = get_post_meta($post->ID, 'almedis_client_recipe', true); ?>
            <button class="almedis-document-icon"></button>
            <h4><?php _e('Receta del Documento', 'almedis'); ?></h4>
            <?php if ($value == '') { ?>
            <?php _e('Este documento no ha sido cargado')?>
            <?php } else { ?>
            <a href="<?php echo $value; ?>" target="_blank"><?php _e('Ver documento', 'almedis'); ?></a>
            <?php } ?>
            <input id="almedis_client_recipe" name="almedis_client_recipe" type="hidden" class="form-control" value="<?php echo $value; ?>" />
        </div>
        <div class="almedis-custom-metabox-document-wrapper">
            <?php $value = get_post_meta($post->ID, 'almedis_client_cartapoder', true); ?>
            <button class="almedis-document-icon"></button>
            <h4><?php _e('Carta Poder', 'almedis'); ?></h4>
            <?php if ($value == '') { ?>
            <?php _e('Este documento no ha sido cargado')?>
            <?php } else { ?>
            <a href="<?php echo $value; ?>" target="_blank"><?php _e('Ver documento', 'almedis'); ?></a>
            <?php } ?>
            <input id="almedis_client_cartapoder" name="almedis_client_cartapoder" type="hidden" class="form-control" value="<?php echo $value; ?>" />
        </div>
        <div class="almedis-custom-metabox-document-wrapper">
            <?php $value = get_post_meta($post->ID, 'almedis_client_carnet', true); ?>
            <button class="almedis-document-icon"></button>
            <h4><?php _e('Carnet de Identificación', 'almedis'); ?></h4>
            <?php if ($value == '') { ?>
            <?php _e('Este documento no ha sido cargado')?>
            <?php } else { ?>
            <a href="<?php echo $value; ?>" target="_blank"><?php _e('Ver documento', 'almedis'); ?></a>
            <?php } ?>
            <input id="almedis_client_carnet" name="almedis_client_carnet" type="hidden" class="form-control" value="<?php echo $value; ?>" />
        </div>
    </div>
</div>
<?php
    }

    public function render_type_meta_box_content($post)
    {
        ?>
<div class="almedis-custom-metabox-wrapper">
    <div class="almedis-custom-metabox-item">
        <label for="almedis_client_type">
            <?php _e('Tipo de Cliente', 'almedis'); ?>
        </label>
        <?php $value = get_post_meta($post->ID, 'almedis_client_type', true); ?>
        <select name="almedis_client_type" id="almedis_client_type">
            <option value=""><?php _e('Seleccione una opción'); ?></option>
            <option value="natural" <?php selected($value, 'natural'); ?>><?php _e('Natural', 'almedis'); ?></option>
            <option value="convenio" <?php selected($value, 'convenio'); ?>><?php _e('Convenio', 'almedis'); ?></option>
            <option value="institucion" <?php selected($value, 'institucion'); ?>><?php _e('Institución', 'almedis'); ?></option>
        </select>
    </div>
    <div class="almedis-custom-metabox-item">
        <label for="almedis_client_instituto">
            <?php _e('Institución:', 'almedis'); ?>
        </label>
        <?php $value = get_post_meta($post->ID, 'almedis_client_institucion', true); ?>
        <select name="almedis_client_institucion" id="almedis_client_institucion">
            <option value=""><?php _e('Seleccione una opción'); ?></option>
            <?php $arr_instituciones = get_posts(array('post_type' => 'instituciones', 'posts_per_page' => -1)); ?>
            <?php if (!empty($arr_instituciones)) : ?>
            <?php foreach ($arr_instituciones as $item) : ?>
            <option value="<?php echo $item->ID; ?>" <?php selected($value, $item->ID); ?>><?php echo $item->post_title; ?></option>
            <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </div>
    <div class="almedis-custom-metabox-item">
        <label for="almedis_client_instituto">
            <?php _e('Convenio:', 'almedis'); ?>
        </label>
        <?php $value = get_post_meta($post->ID, 'almedis_client_convenio', true); ?>
        <select name="almedis_client_convenio" id="almedis_client_convenio">
            <option value=""><?php _e('Seleccione una opción'); ?></option>
            <?php $args = array('role' => 'convenios_admin', 'orderby' => 'user_nicename', 'order' => 'ASC'); ?>
            <?php $users = get_users($args); ?>
            <?php if ($users) : ?>
            <?php foreach ($users as $user) { ?>
            <option value="<?php echo $user->ID; ?>" <?php selected($value, $user->ID); ?>><?php echo $user->first_name . ' ' . $user->last_name; ?></option>
            <?php } ?>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </select>
    </div>
</div>
<?php
    }

    public function render_status_meta_box_content($post)
    {
        ?>
<div class="almedis-custom-metabox-item">
    <?php $value = get_post_meta($post->ID, 'almedis_pedido_status', true); ?>
    <select name="almedis_pedido_status" id="almedis_pedido_status" class="full-select">
        <option value="Cotizacion Recibida" <?php selected($value, 'Cotizacion Recibida'); ?>>Cotizacion Recibida</option>
        <option value="Pendiente de Pago" <?php selected($value, 'Pendiente de Pago'); ?>>Pendiente de Pago</option>
        <option value="Pago Confirmado" <?php selected($value, 'Pago Confirmado'); ?>>Pago Confirmado</option>
        <option value="En Tránsito" <?php selected($value, 'En Tránsito'); ?>>En Tránsito</option>
        <option value="Completada" <?php selected($value, 'Completada'); ?>>Completada</option>
        <option value="Cancelada" <?php selected($value, 'Cancelada'); ?>>Cancelada</option>
    </select>
</div>
<?php
    }

    public function render_admin_meta_box_content($post)
    {
        ?>
<div class="almedis-custom-metabox-item">
    <label for="almedis_pedido_payment_qty">
        <?php _e('Total a Pagar:', 'almedis'); ?>
    </label>
    <?php $value = get_post_meta($post->ID, 'almedis_pedido_payment_qty', true); ?>
    <input id="almedis_pedido_payment_qty" name="almedis_pedido_payment_qty" type="text" class="form-control" value="<?php echo $value; ?>" />
</div>
<div class="almedis-custom-metabox-item">
    <hr>
</div>
<div class="almedis-payment-methods-container">
    <div class="almedis-payment-method-item">
        <h3>Pago por Tarjeta</h3>
        <div class="almedis-custom-metabox-item">
            <label for="almedis_pedido_tarjeta_confirmacion">
                <?php _e('Nro. de Confirmación de Pago:', 'almedis'); ?>
            </label>
            <?php $value = get_post_meta($post->ID, 'almedis_pedido_tarjeta_confirmacion', true); ?>
            <input id="almedis_pedido_tarjeta_confirmacion" name="almedis_pedido_tarjeta_confirmacion" type="text" class="form-control" value="<?php echo $value; ?>" />
        </div>
        <div class="almedis-custom-metabox-item">
            <label for="almedis_pedido_tarjeta_amount">
                <?php _e('Monto del Pago recibido:', 'almedis'); ?>
            </label>
            <?php $value = get_post_meta($post->ID, 'almedis_pedido_tarjeta_amount', true); ?>
            <input id="almedis_pedido_tarjeta_amount" name="almedis_pedido_tarjeta_amount" type="text" class="form-control" value="<?php echo $value; ?>" />
        </div>
        <div class="almedis-custom-metabox-item">
            <label for="almedis_pedido_tarjeta_date">
                <?php _e('Fecha de confirmación del Pago:', 'almedis'); ?>
            </label>
            <?php $value = get_post_meta($post->ID, 'almedis_pedido_tarjeta_date', true); ?>
            <input id="almedis_pedido_tarjeta_date" name="almedis_pedido_tarjeta_date" type="date" class="form-control" value="<?php echo $value; ?>" />
        </div>
        <div class="almedis-custom-metabox-item">
            <label for="almedis_pedido_tarjeta_file">
                <?php _e('Archivo de comprobante:', 'almedis'); ?>
            </label>
            <?php $value = get_post_meta($post->ID, 'almedis_pedido_tarjeta_file', true); ?>
            <a href="<?php echo $value; ?>" class="almedis-document-icon"></a>
            <input id="almedis_pedido_tarjeta_file" name="almedis_pedido_tarjeta_file" type="hidden" class="form-control" value="<?php echo $value; ?>" />
        </div>
    </div>

    <div class="almedis-payment-method-item">
        <h3>Pago por Bono</h3>
        <div class="almedis-custom-metabox-item">
            <label for="almedis_pedido_bono_confirmacion">
                <?php _e('Nro. de Confirmación de Pago:', 'almedis'); ?>
            </label>
            <?php $value = get_post_meta($post->ID, 'almedis_pedido_bono_confirmacion', true); ?>
            <input id="almedis_pedido_bono_confirmacion" name="almedis_pedido_bono_confirmacion" type="text" class="form-control" value="<?php echo $value; ?>" />
        </div>
        <div class="almedis-custom-metabox-item">
            <label for="almedis_pedido_bono_amount">
                <?php _e('Monto del Pago recibido:', 'almedis'); ?>
            </label>
            <?php $value = get_post_meta($post->ID, 'almedis_pedido_bono_amount', true); ?>
            <input id="almedis_pedido_bono_amount" name="almedis_pedido_bono_amount" type="text" class="form-control" value="<?php echo $value; ?>" />
        </div>
        <div class="almedis-custom-metabox-item">
            <label for="almedis_pedido_bono_date">
                <?php _e('Fecha de confirmación del Pago:', 'almedis'); ?>
            </label>
            <?php $value = get_post_meta($post->ID, 'almedis_pedido_bono_date', true); ?>
            <input id="almedis_pedido_bono_date" name="almedis_pedido_bono_date" type="date" class="form-control" value="<?php echo $value; ?>" />
        </div>
        <div class="almedis-custom-metabox-item">
            <label for="almedis_pedido_bono_file">
                <?php _e('Archivo de comprobante:', 'almedis'); ?>
            </label>
            <?php $value = get_post_meta($post->ID, 'almedis_pedido_bono_file', true); ?>
            <a href="<?php echo $value; ?>" class="almedis-document-icon"></a>
            <input id="almedis_pedido_bono_file" name="almedis_pedido_bono_file" type="hidden" class="form-control" value="<?php echo $value; ?>" />
        </div>
    </div>

    <div class="almedis-payment-method-item">
        <h3>Pago por Transferencia Bancaria</h3>
        <div class="almedis-custom-metabox-item">
            <label for="almedis_pedido_transferencia_confirmacion">
                <?php _e('Nro. de Confirmación de Pago:', 'almedis'); ?>
            </label>
            <?php $value = get_post_meta($post->ID, 'almedis_pedido_transferencia_confirmacion', true); ?>
            <input id="almedis_pedido_transferencia_confirmacion" name="almedis_pedido_transferencia_confirmacion" type="text" class="form-control" value="<?php echo $value; ?>" />
        </div>
        <div class="almedis-custom-metabox-item">
            <label for="almedis_pedido_transferencia_amount">
                <?php _e('Monto del Pago recibido:', 'almedis'); ?>
            </label>
            <?php $value = get_post_meta($post->ID, 'almedis_pedido_transferencia_amount', true); ?>
            <input id="almedis_pedido_transferencia_amount" name="almedis_pedido_transferencia_amount" type="text" class="form-control" value="<?php echo $value; ?>" />
        </div>
        <div class="almedis-custom-metabox-item">
            <label for="almedis_pedido_transferencia_date">
                <?php _e('Fecha de confirmación del Pago:', 'almedis'); ?>
            </label>
            <?php $value = get_post_meta($post->ID, 'almedis_pedido_transferencia_date', true); ?>
            <input id="almedis_pedido_transferencia_date" name="almedis_pedido_transferencia_date" type="date" class="form-control" value="<?php echo $value; ?>" />
        </div>
        <div class="almedis-custom-metabox-item">
            <label for="almedis_pedido_transferencia_file">
                <?php _e('Archivo de comprobante:', 'almedis'); ?>
            </label>
            <?php $value = get_post_meta($post->ID, 'almedis_pedido_transferencia_file', true); ?>
            <a href="<?php echo $value; ?>" class="almedis-document-icon"></a>
            <input id="almedis_pedido_transferencia_file" name="almedis_pedido_transferencia_file" type="hidden" class="form-control" value="<?php echo $value; ?>" />
        </div>
    </div>
</div>
<?php
    }

    /**
     * Method pedidos_save_postmeta
     * Save the meta when the post is saved.
     *
     * @param   int $post_id The ID of the post being saved.
     * @since   1.0.0
     * @return  void
     */
    public function pedidos_save_postmeta($post_id, $post, $update)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }

        if (! isset($_POST['almedis_forms_nonce'])) {
            return $post_id;
        }

        $nonce = $_POST['almedis_forms_nonce'];
  
        // Check the user's permissions.
        if ('page' == $_POST['post_type']) {
            if (! current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } else {
            if (! current_user_can('edit_post', $post_id)) {
                return $post_id;
            }
        }

        // Verify that the nonce is valid.
        if (! wp_verify_nonce($nonce, 'almedis_forms')) {
            return $post_id;
        } else {
            $current_user_id = $_POST['current_user_id'];
            $user_info = get_userdata($current_user_id);
            $post = get_post($post_id);

            $text = 'Actualización: El usuario ' . $user_info->user_login . ' ha editado el ' . $post->post_title;
            $historial = new Almedis_Forms_Historial($this->plugin_name, $this->version);
            
            $historial->create_almedis_historial($text);
        }

        /* --------------------------------------------------------------
            Pedidos Main Info
        -------------------------------------------------------------- */

        $unique_id = get_post_meta($post_id, 'almedis_unique_id', true);
        if ($unique_id == '') {
            update_post_meta($post_id, 'almedis_unique_id', uniqid());
        }
          
        if (isset($_POST['almedis_client_name'])) {
            $mydata = sanitize_text_field($_POST['almedis_client_name']);
            update_post_meta($post_id, 'almedis_client_name', $mydata);
        }

        if (isset($_POST['almedis_client_rut'])) {
            $mydata = sanitize_text_field($_POST['almedis_client_rut']);
            update_post_meta($post_id, 'almedis_client_rut', $mydata);
        }

        if (isset($_POST['almedis_client_email'])) {
            $mydata = sanitize_text_field($_POST['almedis_client_email']);
            update_post_meta($post_id, 'almedis_client_email', $mydata);
        }

        if (isset($_POST['almedis_client_phone'])) {
            $mydata = sanitize_text_field($_POST['almedis_client_phone']);
            update_post_meta($post_id, 'almedis_client_phone', $mydata);
        }

        if (isset($_POST['almedis_client_medicine'])) {
            $mydata = sanitize_text_field($_POST['almedis_client_medicine']);
            update_post_meta($post_id, 'almedis_client_medicine', $mydata);
        }

        if (isset($_POST['almedis_client_notification'])) {
            $mydata = sanitize_text_field($_POST['almedis_client_notification']);
            update_post_meta($post_id, 'almedis_client_notification', $mydata);
        }

        if (isset($_POST['almedis_client_institucion'])) {
            $mydata = sanitize_text_field($_POST['almedis_client_institucion']);
            update_post_meta($post_id, 'almedis_client_institucion', $mydata);
        }

        if (isset($_POST['almedis_client_user'])) {
            $user_id = sanitize_text_field($_POST['almedis_client_user']);
            update_post_meta($post_id, 'almedis_client_user', $user_id);

            if (isset($_POST['almedis_client_dir'])) {
                $mydata = sanitize_text_field($_POST['almedis_client_dir']);
                update_user_meta($user_id, 'almedis_user_address', $mydata);
            }
        }

        /* --------------------------------------------------------------
            Status Info
        -------------------------------------------------------------- */
        if (isset($_POST['almedis_pedido_status'])) {
            $mydata = sanitize_text_field($_POST['almedis_pedido_status']);
            update_post_meta($post_id, 'almedis_pedido_status', $mydata);

            // Email Notification
            $dataNotificacion = array(
                'pedidoID' => $post_id,
                'estatus' => $_POST['almedis_pedido_status']
            );
            $notification = new Almedis_Forms_Notificactions($this->plugin_name, $this->version);
            $notification->almedis_change_status($dataNotificacion);
        }
        /* --------------------------------------------------------------
            Payment Info
        -------------------------------------------------------------- */
        if (isset($_POST['almedis_pedido_payment_qty'])) {
            $mydata = sanitize_text_field($_POST['almedis_pedido_payment_qty']);
            update_post_meta($post_id, 'almedis_pedido_payment_qty', $mydata);
        }

        // Pago con Tarjeta
        if (isset($_POST['almedis_pedido_tarjeta_confirmacion'])) {
            $mydata = sanitize_text_field($_POST['almedis_pedido_tarjeta_confirmacion']);
            update_post_meta($post_id, 'almedis_pedido_tarjeta_confirmacion', $mydata);
        }
        if (isset($_POST['almedis_pedido_tarjeta_amount'])) {
            $mydata = sanitize_text_field($_POST['almedis_pedido_tarjeta_amount']);
            update_post_meta($post_id, 'almedis_pedido_tarjeta_amount', $mydata);
        }
        if (isset($_POST['almedis_pedido_tarjeta_date'])) {
            $mydata = sanitize_text_field($_POST['almedis_pedido_tarjeta_date']);
            update_post_meta($post_id, 'almedis_pedido_tarjeta_date', $mydata);
        }
        if (isset($_POST['almedis_pedido_tarjeta_file'])) {
            $mydata = sanitize_text_field($_POST['almedis_pedido_tarjeta_file']);
            update_post_meta($post_id, 'almedis_pedido_tarjeta_file', $mydata);
        }

        // Pago con Bono
        if (isset($_POST['almedis_pedido_bono_confirmacion'])) {
            $mydata = sanitize_text_field($_POST['almedis_pedido_bono_confirmacion']);
            update_post_meta($post_id, 'almedis_pedido_bono_confirmacion', $mydata);
        }
        if (isset($_POST['almedis_pedido_bono_amount'])) {
            $mydata = sanitize_text_field($_POST['almedis_pedido_bono_amount']);
            update_post_meta($post_id, 'almedis_pedido_bono_amount', $mydata);
        }
        if (isset($_POST['almedis_pedido_bono_date'])) {
            $mydata = sanitize_text_field($_POST['almedis_pedido_bono_date']);
            update_post_meta($post_id, 'almedis_pedido_bono_date', $mydata);
        }
        if (isset($_POST['almedis_pedido_bono_file'])) {
            $mydata = sanitize_text_field($_POST['almedis_pedido_bono_file']);
            update_post_meta($post_id, 'almedis_pedido_bono_file', $mydata);
        }

        // Pago con Transferencia
        if (isset($_POST['almedis_pedido_transferencia_confirmacion'])) {
            $mydata = sanitize_text_field($_POST['almedis_pedido_transferencia_confirmacion']);
            update_post_meta($post_id, 'almedis_pedido_transferencia_confirmacion', $mydata);
        }
        if (isset($_POST['almedis_pedido_transferencia_amount'])) {
            $mydata = sanitize_text_field($_POST['almedis_pedido_transferencia_amount']);
            update_post_meta($post_id, 'almedis_pedido_transferencia_amount', $mydata);
        }
        if (isset($_POST['almedis_pedido_transferencia_date'])) {
            $mydata = sanitize_text_field($_POST['almedis_pedido_transferencia_date']);
            update_post_meta($post_id, 'almedis_pedido_transferencia_date', $mydata);
        }
        if (isset($_POST['almedis_pedido_transferencia_file'])) {
            $mydata = sanitize_text_field($_POST['almedis_pedido_transferencia_file']);
            update_post_meta($post_id, 'almedis_pedido_transferencia_file', $mydata);
        }
    }
}