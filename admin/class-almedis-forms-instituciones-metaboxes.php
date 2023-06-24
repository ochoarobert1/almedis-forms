<?php

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

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
class Almedis_Forms_Instituciones_Metaboxes
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
     * Method instituciones_add_meta_box
     * Adds the meta box container.
     *
     * @param   $post_type $post_type [explicite description]
     * @since   1.0.0
     * @return  void
     */
    public function instituciones_add_meta_box($post_type)
    {
        // Limit meta box to certain post types.
        $post_types = array('instituciones');
  
        if (in_array($post_type, $post_types)) {
            add_meta_box(
                'almedis_instituciones_metabox',
                __('Información Básica del Instituto', 'almedis'),
                array( $this, 'render_institucion_meta_box_content' ),
                $post_type,
                'advanced',
                'high'
            );
            add_meta_box(
                'almedis_instituciones_qr_metabox',
                __('Código QR', 'almedis'),
                array( $this, 'render_institucion_qr_meta_box_content' ),
                $post_type,
                'side',
                'high'
            );
        }
    }
  
    /**
     * Method instituciones_save_postmeta
     * Save the meta when the post is saved.
     *
     * @param   int $post_id The ID of the post being saved.
     * @since   1.0.0
     * @return  void
     */
    public function instituciones_save_postmeta($post_id)
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
            $user_id = sanitize_text_field($_POST['almedis_institucion_user']);
            update_post_meta($post_id, 'almedis_institucion_user', $user_id);
            // Update user with instituto.
            update_user_meta($user_id, 'almedis_client_instituto', $post_id);
        }
    }

    /**
     * Method render_institucion_meta_box_content
     * Render Meta Box content.
     *
     * @param   WP_Post $post The post object.
     * @since   1.0.0
     * @return  void
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
                <button type="button" class="button" id="logo_upload_btn" data-media-uploader-target="#almedis_institucion_logo"><?php _e('Upload Media', 'myplugin')?></button>
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
     * Method render_institucion_qr_meta_box_content
     * Render Meta Box content.
     *
     * @param   WP_Post $post The post object.
     * @since   1.0.0
     * @return  void
     */
    public function render_institucion_qr_meta_box_content($post)
    {
        ?>
<div class="almedis-custom-metabox-item">
    <?php
        $options = new QROptions(
            [
                'eccLevel' => QRCode::ECC_L,
                'outputType' => QRCode::OUTPUT_MARKUP_SVG,
                'version' => 5,
            ]
        );
        $linkurl = get_permalink($post->ID);
        if ($linkurl != '') {
            $qrcode = (new QRCode($options))->render($linkurl); ?>
    <img src='<?php echo $qrcode; ?>' alt='QR Code' width='250' height='250'>
    <?php
        } ?>
</div>
<?php
    }
}