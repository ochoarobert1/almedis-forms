<?php

/**
* Almedis Dashboard - Dashboard Creator
*
*
* @package    almedis-forms
* @subpackage metaboxes
*
*/

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class AlmedisMetaboxes extends AlmedisForm
{
    /**
     * Method __construct
     *
     * @return void
     */
    public function __construct()
    {
        add_action('load-post.php', array($this, 'almedis_remove_post_type_edit_screen'), 10);
        add_action('add_meta_boxes', array( $this, 'add_meta_box' ));
        add_action('save_post', array( $this, 'save'));
        add_filter('postbox_classes_pedidos_almedis_metabox', array($this, 'add_pedido_metabox_classes'));
        add_filter('postbox_classes_pedidos_almedis_type_metabox', array($this, 'add_cliente_metabox_classes'));
        add_filter('postbox_classes_pedidos_almedis_status_metabox', array($this, 'add_pedido_metabox_classes'));
        add_filter('postbox_classes_pedidos_almedis_admin_metabox', array($this, 'add_pedido_metabox_classes'));
        add_filter('postbox_classes_instituciones_almedis_instituciones_metabox', array($this, 'add_pedido_metabox_classes'));
    }
    
    /**
     * Method add_pedido_metabox_classes
     *
     * @param $classes $classes [explicite description]
     *
     * @return void
     */
    public function add_pedido_metabox_classes($classes)
    {
        array_push($classes, 'almedis-pedido-metabox');
        return $classes;
    }
    
    /**
     * Method add_cliente_metabox_classes
     *
     * @param $classes $classes [explicite description]
     *
     * @return void
     */
    public function add_cliente_metabox_classes($classes)
    {
        array_push($classes, 'almedis-cliente-metabox');
        return $classes;
    }

    /**
     * Method almedis_remove_post_type_edit_screen
     *
     * @return void
     */
    public function almedis_remove_post_type_edit_screen()
    {
        global $typenow;
    
        if ($typenow && $typenow === 'pedidos') {
            remove_post_type_support('pedidos', 'title');
        }
    }

    /**
     * Adds the meta box container.
     */
    public function add_meta_box($post_type)
    {
        // Limit meta box to certain post types.
        $post_types = array('pedidos' );
  
        if (in_array($post_type, $post_types)) {
            add_meta_box(
                'almedis_metabox',
                __('Información del Pedido', 'almedis'),
                array( $this, 'render_meta_box_content' ),
                $post_type,
                'advanced',
                'high'
            );

            add_meta_box(
                'almedis_type_metabox',
                __('Información del Cliente', 'almedis'),
                array( $this, 'render_type_meta_box_content' ),
                $post_type,
                'side',
                'high'
            );

            add_meta_box(
                'almedis_status_metabox',
                __('Estatus del Pedido', 'almedis'),
                array( $this, 'render_status_meta_box_content' ),
                $post_type,
                'side',
                'high'
            );

            add_meta_box(
                'almedis_admin_metabox',
                __('Administrador: Información Adicional', 'almedis'),
                array( $this, 'render_admin_meta_box_content' ),
                $post_type,
                'advanced',
                'high'
            );
        }

        if ($post_type == 'instituciones') {
            add_meta_box(
                'almedis_instituciones_metabox',
                __('Institución: Información Adicional', 'almedis'),
                array( $this, 'render_institucion_meta_box_content' ),
                $post_type,
                'advanced',
                'high'
            );
        }
    }
  
    /**
     * Save the meta when the post is saved.
     *
     * @param int $post_id The ID of the post being saved.
     */
    public function save($post_id)
    {
        /*
         * If this is an autosave, our form has not been submitted,
         * so we don't want to do anything.
         */
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
            $historial = new AlmedisHistorial;
            $historial->create_almedis_historial($text);
        }
        
        if (isset($_POST['almedis_pedido_status'])) {
            $mydata = sanitize_text_field($_POST['almedis_pedido_status']);
            update_post_meta($post_id, 'almedis_pedido_status', $mydata);
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

        if (isset($_POST['almedis_client_instituto'])) {
            $mydata = sanitize_text_field($_POST['almedis_client_instituto']);
            update_post_meta($post_id, 'almedis_client_instituto', $mydata);
        }

        if (isset($_POST['almedis_institucion_logo'])) {
            $mydata = sanitize_text_field($_POST['almedis_institucion_logo']);
            update_post_meta($post_id, 'almedis_institucion_logo', $mydata);
        }

        if (isset($_POST['almedis_institucion_name'])) {
            $mydata = sanitize_text_field($_POST['almedis_institucion_name']);
            update_post_meta($post_id, 'almedis_institucion_name', $mydata);
        }

        if (isset($_POST['almedis_institucion_rut'])) {
            $mydata = sanitize_text_field($_POST['almedis_institucion_rut']);
            update_post_meta($post_id, 'almedis_institucion_rut', $mydata);
        }

        if (isset($_POST['almedis_institucion_email'])) {
            $mydata = sanitize_text_field($_POST['almedis_institucion_email']);
            update_post_meta($post_id, 'almedis_institucion_email', $mydata);
        }

        if (isset($_POST['almedis_institucion_phone'])) {
            $mydata = sanitize_text_field($_POST['almedis_institucion_phone']);
            update_post_meta($post_id, 'almedis_institucion_phone', $mydata);
        }

        if (isset($_POST['almedis_institucion_encargado'])) {
            $mydata = sanitize_text_field($_POST['almedis_institucion_encargado']);
            update_post_meta($post_id, 'almedis_institucion_encargado', $mydata);
        }

        if (isset($_POST['almedis_institucion_user'])) {
            $mydata = sanitize_text_field($_POST['almedis_institucion_user']);
            update_post_meta($post_id, 'almedis_institucion_user', $mydata);
        }
    }

    /**
     * Render Meta Box content.
     *
     * @param WP_Post $post The post object.
     */
    public function render_institucion_meta_box_content($post)
    {
        ?>
<div class="almedis-custom-metabox-wrapper">
    <?php wp_nonce_field('almedis_forms', 'almedis_forms_nonce'); ?>

    <input type="hidden" name="current_user_id" value="<?php echo get_current_user_id(); ?>">

    <div class="almedis-custom-metabox-item">
        <label for="almedis_institucion_logo">
            <?php _e('Logo de la institución', 'almedis'); ?>
        </label>
        <?php $value = get_post_meta($post->ID, 'almedis_institucion_logo', true); ?>
        <fieldset>
            <div>
                <?php $image = ($value == '') ? 'http://placehold.it/100x100' : $value; ?>
                <img id="almedis_institucion_logo_img" src="<?php echo $image ?>" alt="Logo" class="avatar avatar-img" />
                <input type="hidden" class="large-text" name="almedis_institucion_logo" id="almedis_institucion_logo" value="<?php echo esc_attr($image); ?>"><br>
                <button type="button" class="button" id="events_video_upload_btn" data-media-uploader-target="#almedis_institucion_logo"><?php _e('Upload Media', 'myplugin')?></button>
            </div>
        </fieldset>
    </div>

    <div class="almedis-custom-metabox-item">
        <label for="almedis_institucion_name">
            <?php _e('Nombre de la institución', 'almedis'); ?>
        </label>
        <?php $value = get_post_meta($post->ID, 'almedis_institucion_name', true); ?>
        <input id="almedis_institucion_name" name="almedis_institucion_name" type="text" class="form-control" value="<?php echo $value; ?>" />
    </div>

    <div class="almedis-custom-metabox-item">
        <label for="almedis_institucion_rut">
            <?php _e('RUT', 'almedis'); ?>
        </label>
        <?php $value = get_post_meta($post->ID, 'almedis_institucion_rut', true); ?>
        <input id="almedis_institucion_rut" name="almedis_institucion_rut" type="text" class="form-control" value="<?php echo $value; ?>" />
    </div>

    <div class="almedis-custom-metabox-item">
        <label for="almedis_institucion_email">
            <?php _e('Correo Electrónico', 'almedis'); ?>
        </label>
        <?php $value = get_post_meta($post->ID, 'almedis_institucion_email', true); ?>
        <input id="almedis_institucion_email" name="almedis_institucion_email" type="text" class="form-control" value="<?php echo $value; ?>" />
    </div>

    <div class="almedis-custom-metabox-item">
        <label for="almedis_institucion_phone">
            <?php _e('Teléfono / WhatsApp', 'almedis'); ?>
        </label>
        <?php $value = get_post_meta($post->ID, 'almedis_institucion_phone', true); ?>
        <input id="almedis_institucion_phone" name="almedis_institucion_phone" type="text" class="form-control" value="<?php echo $value; ?>" />
    </div>

    <div class="almedis-custom-metabox-item">
        <label for="almedis_institucion_encargado">
            <?php _e('Nombre del encargado', 'almedis'); ?>
        </label>
        <?php $value = get_post_meta($post->ID, 'almedis_institucion_encargado', true); ?>
        <input id="almedis_institucion_encargado" name="almedis_institucion_encargado" type="text" class="form-control" value="<?php echo $value; ?>" />
    </div>

    <div class="almedis-custom-metabox-item">
        <label for="almedis_institucion_user">
            <?php _e('Usuario administrador de esta institucion', 'almedis'); ?>
        </label>
        <?php $value = get_post_meta($post->ID, 'almedis_institucion_user', true); ?>
        <div class="current-user">
            <span class="almedis-user-icon"></span>
            <?php $blogusers = get_users(array( 'role__in' => array( 'administrator', 'almedis_admin' ) )); ?>
            <select name="almedis_institucion_user" id="almedis_institucion_user">
                <option value=""><?php _e('Seleccione una opción'); ?></option>
                <?php foreach ($blogusers as $user) { ?>
                <option value="<?php echo esc_attr($user->ID); ?>" <?php selected($value, $user->ID); ?>><?php echo esc_html($user->display_name) . ' - ' . esc_html($user->user_email); ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
</div>
<?php
    }
  
  
    /**
     * Render Meta Box content.
     *
     * @param WP_Post $post The post object.
     */
    public function render_meta_box_content($post)
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

    <div class="almedis-custom-metabox-item">
        <label for="almedis_client_tipo">
            <?php _e('Tipo de Cliente', 'almedis'); ?>
        </label>
        <?php $value = get_post_meta($post->ID, 'almedis_client_tipo', true); ?>
        <select name="almedis_client_tipo" id="almedis_client_tipo" class="form-control">
            <option value="Paciente" <?php selected($value, 'Paciente'); ?>>Paciente</option>
            <option value="Familia o amigo de un paciente" <?php selected($value, 'Familia o amigo de un paciente'); ?>>Familia o amigo de un paciente</option>
            <option value="Doctor" <?php selected($value, 'Doctor'); ?>>Doctor</option>
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
            <h4><?php _e('Recipe del Documento', 'almedis'); ?></h4>
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
        </select>
    </div>
    <div class="almedis-custom-metabox-item">
        <label for="almedis_client_instituto">
            <?php _e('Institución:', 'almedis'); ?>
        </label>
        <?php $value = get_post_meta($post->ID, 'almedis_client_instituto', true); ?>
        <select name="almedis_client_instituto" id="almedis_client_instituto">
            <option value=""><?php _e('Seleccione una opción'); ?></option>
            <?php $arr_instituciones = get_posts(array('post_type' => 'instituciones', 'posts_per_page' => -1)); ?>
            <?php if ($arr_instituciones) : ?>
            <?php foreach ($arr_instituciones as $post) { ?>
            <option value="<?php echo $post->ID; ?>" <?php selected($value, $post->ID); ?>><?php echo $post->post_title; ?></option>
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
    <label for="almedis_pedido_status">
        <?php _e('Estatus:', 'almedis'); ?>
    </label>
    <?php $value = get_post_meta($post->ID, 'almedis_pedido_status', true); ?>
    <select name="almedis_pedido_status" id="almedis_pedido_status" class="form-control">
        <option value="Cotizacion Recibida" <?php selected($value, 'Cotizacion Recibida'); ?>>Cotizacion Recibida</option>
        <option value="Confirmación de Pedido" <?php selected($value, 'Confirmación de Pedido'); ?>>Confirmación de Pedido</option>
        <option value="Pendiente de Pago" <?php selected($value, 'Pendiente de Pago'); ?>>Pendiente de Pago</option>
        <option value="Pago Confirmado" <?php selected($value, 'Pago Confirmado'); ?>>Pago Confirmado</option>
        <option value="Generación de Número de Pedido" <?php selected($value, 'Generación de Número de Pedido'); ?>>Generación de Número de Pedido</option>
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
    <label for="almedis_pedido_payment_nro">
        <?php _e('Nro. de Confirmación de Pago - Transbank:', 'almedis'); ?>
    </label>
    <?php $value = get_post_meta($post->ID, 'almedis_pedido_payment_nro', true); ?>
    <input id="almedis_pedido_payment_nro" name="almedis_pedido_payment_nro" type="text" class="form-control" value="<?php echo $value; ?>" />
</div>
<div class="almedis-custom-metabox-item">
    <label for="almedis_pedido_payment_date">
        <?php _e('Fecha de confirmación del Pago:', 'almedis'); ?>
    </label>
    <?php $value = get_post_meta($post->ID, 'almedis_pedido_payment_date', true); ?>
    <input id="almedis_pedido_payment_date" name="almedis_pedido_payment_date" type="date" class="form-control" value="<?php echo $value; ?>" />
</div>
<div class="almedis-custom-metabox-item">
    <label for="almedis_pedido_observaciones">
        <?php _e('Observaciones:', 'almedis'); ?>
    </label>
    <?php $value = get_post_meta($post->ID, 'almedis_pedido_observaciones', true); ?>
    <textarea id="almedis_pedido_observaciones" name="almedis_pedido_observaciones" type="text" class="form-control" rows="5"><?php echo $value; ?></textarea>
</div>
<?php
    }
}

new AlmedisMetaboxes;
