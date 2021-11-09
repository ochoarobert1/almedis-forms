<?php

/**
* Almedis Forms - Actvation Hooks
*
*
* @package    almedis-forms
* @subpackage activation_hook
*
*/

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Method almedis_cpt_pedidos
 *
 * @return void
 */

function almedis_cpt_pedidos()
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
add_action('init', 'almedis_cpt_pedidos', 0);

/**
 * Method almedis_cpt_instituciones
 *
 * @return void
 */
function almedis_cpt_instituciones()
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
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
        'show_in_rest'          => true,
    );
    register_post_type('instituciones', $args);
}
add_action('init', 'almedis_cpt_instituciones', 0);

/**
 * Method almedis_historial_db
 *
 * @return void
 */

class almedisActivation
{
    public function start_activation()
    {
        flush_rewrite_rules();
        $this->almedis_historial_db();
    }
    public function almedis_historial_db()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . "almedis_historial";
        $almedis_db_version = '1.0.0';
        $charset_collate = $wpdb->get_charset_collate();
    
        if ($wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name) {
            $sql = "CREATE TABLE $table_name (
                ID mediumint(9) NOT NULL AUTO_INCREMENT,
                `desc` text NOT NULL,
                `date` datetime NOT NULL,
                PRIMARY KEY  (ID)
            ) $charset_collate;";
    
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
            add_option('almedis_db_version', $almedis_db_version);
        }
    
        var_dump($almedis_db_version);
    }
}



 
/**
 * Method almedis_activate
 *
 * @return void
 */

register_activation_hook(__FILE__, array( 'almedisActivation', 'start_activation' ));
