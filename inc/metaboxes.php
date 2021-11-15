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
        add_action('admin_head-edit.php', array($this, 'almedis_quick_edit_remover' ));
        add_action('add_meta_boxes', array( $this, 'add_meta_box' ));
        add_action('save_post', array( $this, 'save'));
        add_filter('postbox_classes_pedidos_almedis_metabox', array($this, 'add_pedido_metabox_classes'));
        add_filter('postbox_classes_pedidos_almedis_type_metabox', array($this, 'add_cliente_metabox_classes'));
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
     * Method almedis_quick_edit_remover
     *
     * @return void
     */
    public function almedis_quick_edit_remover()
    {
        global $current_screen;
        if ('edit-pedidos' != $current_screen->id) {
            return;
        } ?>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('span:contains("Title")').each(function(i) {
            $(this).parent().remove();
        });
        $('span:contains("Slug")').each(function(i) {
            $(this).parent().remove();
        });
    });
</script>
<?php
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
  
        $mydata = sanitize_text_field($_POST['almedis_client_name']);
        update_post_meta($post_id, 'almedis_client_name', $mydata);

        $mydata = sanitize_text_field($_POST['almedis_client_rut']);
        update_post_meta($post_id, 'almedis_client_rut', $mydata);

        $mydata = sanitize_text_field($_POST['almedis_client_email']);
        update_post_meta($post_id, 'almedis_client_email', $mydata);

        $mydata = sanitize_text_field($_POST['almedis_client_phone']);
        update_post_meta($post_id, 'almedis_client_phone', $mydata);

        $mydata = sanitize_text_field($_POST['almedis_client_medicine']);
        update_post_meta($post_id, 'almedis_client_medicine', $mydata);

        $mydata = sanitize_text_field($_POST['almedis_client_notification']);
        update_post_meta($post_id, 'almedis_client_notification', $mydata);

        $mydata = sanitize_text_field($_POST['almedis_client_instituto']);
        update_post_meta($post_id, 'almedis_client_instituto', $mydata);
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
            <?php $blogusers = get_users(array( 'role__in' => array( 'administrator', 'almedis-client' ) )); ?>
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
}

new AlmedisMetaboxes;
