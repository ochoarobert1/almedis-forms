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
class Almedis_Forms_Admin
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

    /* --------------------------------------------------------------
        CUSTOM FUNCTIONS AND HANDLERS
    -------------------------------------------------------------- */

    /**
     * Method enqueue_styles
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     * @return void
     */
    public function enqueue_styles()
    {
        // Additional Styles
        wp_enqueue_style('datatables', 'https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css', array(), $this->version, 'all');
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/almedis-forms-admin.css', array(), $this->version, 'all');
    }

    /**
     * Method enqueue_scripts
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     * @return void
     */
    public function enqueue_scripts()
    {
        global $typenow;
        // Additional JS
        wp_enqueue_script('datatables', 'https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js', array( 'jquery' ), $this->version, true);
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/almedis-forms-admin.js', array( 'jquery', 'datatables' ), $this->version, false);
        
        if ($typenow == 'instituciones') {
            wp_enqueue_media();
            wp_localize_script(
                'almedis-forms-admin',
                'meta_image',
                array(
                    'title' => __('Choose or Upload Media', 'events'),
                    'button' => __('Use this media', 'events'),
                )
            );
        }
    }

    /* --------------------------------------------------------------
        PEDIDOS FUNCTIONS AND HANDLERS
    -------------------------------------------------------------- */

    /**
     * Method almedis_cpt_pedidos
     * Register Pedidos Custom Post Type
     *
     * @since    1.0.0
     * @return void
     */
    public function almedis_cpt_pedidos()
    {
        $labels = array(
            'name'                  => _x('Pedidos', 'Post Type General Name', 'almedis'),
            'singular_name'         => _x('Pedido', 'Post Type Singular Name', 'almedis'),
            'menu_name'             => __('Pedidos', 'almedis'),
            'name_admin_bar'        => __('Pedido', 'almedis'),
            'archives'              => __('Archivo de Pedidos', 'almedis'),
            'attributes'            => __('Atributos de Pedidos', 'almedis'),
            'parent_item_colon'     => __('Pedido Padre:', 'almedis'),
            'all_items'             => __('Todos los Pedidos', 'almedis'),
            'add_new_item'          => __('Agregar nuevo Pedido', 'almedis'),
            'add_new'               => __('Agregar nuevo', 'almedis'),
            'new_item'              => __('Nuevo Pedido', 'almedis'),
            'edit_item'             => __('Editar Pedido', 'almedis'),
            'update_item'           => __('Actualizar Pedido', 'almedis'),
            'view_item'             => __('Ver Pedido', 'almedis'),
            'view_items'            => __('Ver Pedidos', 'almedis'),
            'search_items'          => __('Buscar Pedido', 'almedis'),
            'not_found'             => __('No hay resultados', 'almedis'),
            'not_found_in_trash'    => __('No hay resultados en Papelera', 'almedis'),
            'featured_image'        => __('Imagen Destacada', 'almedis'),
            'set_featured_image'    => __('Colocar Imagen Destacada', 'almedis'),
            'remove_featured_image' => __('Remover Imagen Destacada', 'almedis'),
            'use_featured_image'    => __('Usar como Imagen Destacada', 'almedis'),
            'insert_into_item'      => __('Insertar en Pedido', 'almedis'),
            'uploaded_to_this_item' => __('Cargado a este pedido', 'almedis'),
            'items_list'            => __('Listado de Pedidos', 'almedis'),
            'items_list_navigation' => __('Navegación del Listado de Pedidos', 'almedis'),
            'filter_items_list'     => __('Filtro del Listado de Pedidos', 'almedis'),
        );
        $args = array(
            'label'                 => __('Pedido', 'almedis'),
            'description'           => __('Pedidos dentro del sitio', 'almedis'),
            'labels'                => $labels,
            'supports'              => array( 'title' ),
            'taxonomies'            => array( 'status' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => false,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-money-alt',
            'show_in_admin_bar'     => false,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => true,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
            'show_in_rest'          => true,
        );
        register_post_type('pedidos', $args);
    }



    /**
     * Method custom_pedidos_template_file
     *
     * @param $single $single [explicite description]
     *
     * @return void
     */
    public function custom_pedidos_template_file( $template ) {
        global $post;
    
        if ( 'pedidos' === $post->post_type && locate_template( array( 'single-pedidos.php' ) ) !== $template ) {
            return ALMEDIS_PLUGIN_BASE .'/public/templates/single-pedidos.php';
        }
    
        return $template;
    }
    
    /**
     * Method almedis_filter_pedidos_columns
     * Add Filter to custom post columns
     *
     * @since   1.0.0
     * @param   $columns
     * @return  $columns
     */
    public function almedis_filter_pedidos_columns($columns)
    {
        unset($columns['date']);
        $columns['almedis_unique_id'] = __('Código Único', 'almedis');
        $columns['almedis_client_name'] = __('Nombre y Apellido', 'almedis');
        $columns['almedis_client_email'] = __('Correo Electrónico', 'almedis');
        $columns['almedis_client_type'] = __('Tipo de Cliente', 'almedis');
        $columns['almedis_pedido_status'] = __('Status', 'almedis');
        $columns['date'] = __('Date', 'wordpress');
        return $columns;
    }

    /**
     * Method almedis_populate_columns
     * Add content to custom post columns
     *
     * @since   1.0.0
     * @param   $columns, $post_id
     * @return  void
     */
    public function almedis_populate_columns($column, $post_id)
    {
        // Image column
        if ('almedis_unique_id' === $column) {
            echo '<code>' . get_post_meta($post_id, 'almedis_unique_id', true) . '</code>';
        }

        if ('almedis_client_name' === $column) {
            echo get_post_meta($post_id, 'almedis_client_name', true);
        }

        if ('almedis_client_email' === $column) {
            echo get_post_meta($post_id, 'almedis_client_email', true);
        }

        if ('almedis_client_type' === $column) {
            $type = get_post_meta($post_id, 'almedis_client_type', true);
            switch ($type) {
                case 'natural':
                    $class = 'client-type-natural';
                    break;

                case 'convenio':
                    $class = 'client-type-convenio';
                    break;

                case 'institucion':
                    $class = 'client-type-institucion';
                    break;
                
                default:
                    $class = '';
                    break;
            }
            echo '<span class="client-type ' . $class . '">' . $type . '</span>';
        }

        if ('almedis_pedido_status' === $column) {
            echo get_post_meta($post_id, 'almedis_pedido_status', true);
        }
    }

    /* --------------------------------------------------------------
        INSTITUCIONES FUNCTIONS AND HANDLERS
    -------------------------------------------------------------- */

    /**
     * Method almedis_cpt_instituciones
     * Register Instituciones Custom Post Type
     *
     * @since    1.0.0
     * @return void
     */
    public function almedis_cpt_instituciones()
    {
        $labels = array(
            'name'                  => _x('Instituciones', 'Post Type General Name', 'almedis'),
            'singular_name'         => _x('Institución', 'Post Type Singular Name', 'almedis'),
            'menu_name'             => __('Instituciones', 'almedis'),
            'name_admin_bar'        => __('Instituciones', 'almedis'),
            'archives'              => __('Archivo de Instituciones', 'almedis'),
            'attributes'            => __('Atributos de Institución', 'almedis'),
            'parent_item_colon'     => __('Institución Padre:', 'almedis'),
            'all_items'             => __('Todas las Instituciones', 'almedis'),
            'add_new_item'          => __('Agregar Nueva Institución', 'almedis'),
            'add_new'               => __('Agregar Nueva', 'almedis'),
            'new_item'              => __('Nueva Institución', 'almedis'),
            'edit_item'             => __('Editar Institución', 'almedis'),
            'update_item'           => __('Actualizar Institución', 'almedis'),
            'view_item'             => __('Ver Institución', 'almedis'),
            'view_items'            => __('Ver Instituciones', 'almedis'),
            'search_items'          => __('Buscar Institución', 'almedis'),
            'not_found'             => __('No hay resultados', 'almedis'),
            'not_found_in_trash'    => __('No hay resultados en Papelera', 'almedis'),
            'featured_image'        => __('Imagen Destacada', 'almedis'),
            'set_featured_image'    => __('Colocar Imagen Destacada', 'almedis'),
            'remove_featured_image' => __('Remover Imagen Destacada', 'almedis'),
            'use_featured_image'    => __('Usar como Imagen Destacada', 'almedis'),
            'insert_into_item'      => __('Insertar en Institución', 'almedis'),
            'uploaded_to_this_item' => __('Cargado a esta Institución', 'almedis'),
            'items_list'            => __('Listado de Instituciones', 'almedis'),
            'items_list_navigation' => __('Navegación del Listado de Instituciones', 'almedis'),
            'filter_items_list'     => __('Filtro del Listado de Instituciones', 'almedis'),
        );
        $args = array(
            'label'                 => __('Institución', 'almedis'),
            'description'           => __('Instituciones dentro de la Empresa', 'almedis'),
            'labels'                => $labels,
            'supports'              => array( 'title' ),
            'taxonomies'            => array( 'status' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => false,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-building',
            'show_in_admin_bar'     => false,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => true,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
            'show_in_rest'          => true,
        );
        register_post_type('instituciones', $args);
    }

    /**
     * Method almedis_filter_instituciones_columns
     * Add Filter to custom post columns
     *
     * @since   1.0.0
     * @param   $columns
     * @return  $columns
     */
    public function almedis_filter_instituciones_columns($columns)
    {
        unset($columns['date']);
        $columns['almedis_institucion_logo'] = __('Logo', 'almedis');
        $columns['almedis_institucion_rut'] = __('RUT', 'almedis');
        $columns['almedis_institucion_email'] = __('Correo Electrónico', 'almedis');
        $columns['almedis_institucion_phone'] = __('Teléfono', 'almedis');
        $columns['almedis_institucion_encargado'] = __('Encargado', 'almedis');
        $columns['date'] = __('Date', 'wordpress');
        return $columns;
    }


    /**
     * Method almedis_instituciones_populate_columns
     * Add content to custom post columns
     *
     * @since   1.0.0
     * @param   $column, $post_id
     * @return  void
     */

    public function almedis_instituciones_populate_columns($column, $post_id)
    {
        if ('almedis_institucion_logo' === $column) {
            $value = get_post_meta($post_id, 'almedis_institucion_logo', true);
            $image = ($value == '') ? plugins_url('/img/logo.png', __FILE__) : $value;
            echo '<img id="almedis_institucion_logo_img" src="' . $image . '" alt="Logo" class="avatar avatar-img" />';
        }

        if ('almedis_institucion_rut' === $column) {
            echo get_post_meta($post_id, 'almedis_institucion_rut', true);
        }

        if ('almedis_institucion_email' === $column) {
            echo get_post_meta($post_id, 'almedis_institucion_email', true);
        }

        if ('almedis_institucion_phone' === $column) {
            echo get_post_meta($post_id, 'almedis_institucion_phone', true);
        }

        if ('almedis_institucion_encargado' === $column) {
            echo get_post_meta($post_id, 'almedis_institucion_encargado', true);
        }
    }

    /* --------------------------------------------------------------
        GENERAL ADMIN METABOXES
    -------------------------------------------------------------- */
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
     * Method almedis_additional_profile_fields
     *
     * @param $user $user [explicite description]
     *
     * @return void
     */
    public function almedis_additional_profile_fields($user)
    {
        ?>
<div class="almedis-custom-metabox-item">
    <label for="almedis_client_instituto">
        <?php _e('Institución:', 'almedis'); ?>
    </label>
    <?php $value = get_user_meta($user->ID, 'almedis_client_instituto', true); ?>
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
<?php
    }

    /**
     * Save additional profile fields.
     *
     * @param  int $user_id Current user ID.
     */
    public function almedis_save_profile_fields($user_id)
    {
        if (! current_user_can('edit_user', $user_id)) {
            return false;
        }

        if (empty($_POST['almedis_client_instituto'])) {
            return false;
        }

        update_usermeta($user_id, 'almedis_client_instituto', $_POST['almedis_client_instituto']);
    }
}
