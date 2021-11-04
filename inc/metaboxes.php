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
         * We need to verify this came from the our screen and with proper authorization,
         * because save_post can be triggered at other times.
         */
  
        // Check if our nonce is set.
        if (! isset($_POST['myplugin_inner_custom_box_nonce'])) {
            return $post_id;
        }
  
        $nonce = $_POST['myplugin_inner_custom_box_nonce'];
  
        // Verify that the nonce is valid.
        if (! wp_verify_nonce($nonce, 'myplugin_inner_custom_box')) {
            return $post_id;
        }
  
        /*
         * If this is an autosave, our form has not been submitted,
         * so we don't want to do anything.
         */
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }
  
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
  
        /* OK, it's safe for us to save the data now. */
  
        // Sanitize the user input.
        $mydata = sanitize_text_field($_POST['myplugin_new_field']);
  
        // Update the meta field.
        update_post_meta($post_id, '_my_meta_value_key', $mydata);
    }
  
  
    /**
     * Render Meta Box content.
     *
     * @param WP_Post $post The post object.
     */
    public function render_meta_box_content($post)
    {
  
        // Add an nonce field so we can check for it later.
        wp_nonce_field('myplugin_inner_custom_box', 'myplugin_inner_custom_box_nonce'); ?>
<div class="almedis-custom-metabox-wrapper">
    <h2><?php echo get_the_title(); ?></h2>

    <label for="almedis_client_name">
        <?php _e('Nombres y Apellidos', 'almedis'); ?>
    </label>
    <?php $value = get_post_meta($post->ID, '_my_meta_value_key', true); ?>
    <input id="almedis_client_name" name="almedis_client_name" type="text" class="form-control" value="<?php echo $value; ?>" />

    <label for="almedis_client_rut">
        <?php _e('RUT', 'almedis'); ?>
    </label>
    <?php $value = get_post_meta($post->ID, '_my_meta_value_key', true); ?>
    <input id="almedis_client_rut" name="almedis_client_rut" type="text" class="form-control" value="<?php echo $value; ?>" />

    <label for="almedis_client_email">
        <?php _e('Correo Electrónico', 'almedis'); ?>
    </label>
    <?php $value = get_post_meta($post->ID, '_my_meta_value_key', true); ?>
    <input id="almedis_client_email" name="almedis_client_email" type="text" class="form-control" value="<?php echo $value; ?>" />

    <label for="almedis_client_phone">
        <?php _e('Teléfono / WhatsApp', 'almedis'); ?>
    </label>
    <?php $value = get_post_meta($post->ID, '_my_meta_value_key', true); ?>
    <input id="almedis_client_phone" name="almedis_client_phone" type="text" class="form-control" value="<?php echo $value; ?>" />

    <label for="almedis_client_medicine">
        <?php _e('Nombre del Medicamento', 'almedis'); ?>
    </label>
    <?php $value = get_post_meta($post->ID, '_my_meta_value_key', true); ?>
    <input id="almedis_client_medicine" name="almedis_client_medicine" type="text" class="form-control" value="<?php echo $value; ?>" />

    <label for="almedis_client_notification">
        <?php _e('Recepción de Cotización', 'almedis'); ?>
    </label>
    <?php $value = get_post_meta($post->ID, '_my_meta_value_key', true); ?>
    <input id="almedis_client_notification" name="almedis_client_notification" type="text" class="form-control" value="<?php echo $value; ?>" />

    <label for="almedis_client_user">
        <?php _e('Usuario del Pedido', 'almedis'); ?>
    </label>
    <?php $value = get_post_meta($post->ID, '_my_meta_value_key', true); ?>
    <input id="almedis_client_user" name="almedis_client_user" type="text" class="form-control" value="<?php echo $value; ?>" />

    <label for="almedis_client_documents">
        <?php _e('Documentos Adjuntos', 'almedis'); ?>
    </label>
    <?php $value = get_post_meta($post->ID, '_my_meta_value_key', true); ?>
    <input id="almedis_client_documents" name="almedis_client_documents" type="text" class="form-control" value="<?php echo $value; ?>" />

</div>
<?php
    }
}

new AlmedisMetaboxes;
