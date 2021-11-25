<?php

/**
* Almedis Forms - Post Types
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



function almedis_filter_pedidos_columns($columns)
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

add_filter('manage_pedidos_posts_columns', 'almedis_filter_pedidos_columns');


function almedis_populate_columns($column, $post_id)
{
    // Image column
    if ('almedis_unique_id' === $column) {
        ob_start(); ?>
<code><?php echo get_post_meta($post_id, 'almedis_unique_id', true); ?></code>
<?php
        $content = ob_get_clean();
        echo $content;
    }

    if ('almedis_client_name' === $column) {
        echo get_post_meta($post_id, 'almedis_client_name', true);
    }

    if ('almedis_client_email' === $column) {
        echo get_post_meta($post_id, 'almedis_client_email', true);
    }

    if ('almedis_client_type' === $column) {
        $type = get_post_meta($post_id, 'almedis_client_type', true);
        $class = ($type == 'natural') ? 'client-type-natural' : 'client-type-convenio';
        ob_start(); ?>
<span class="client-type <?php echo $class; ?>"><?php echo $type; ?></span>
<?php
        $content = ob_get_clean();
        echo $content;
    }

    if ('almedis_pedido_status' === $column) {
        echo get_post_meta($post_id, 'almedis_pedido_status', true);
    }
}
add_action('manage_pedidos_posts_custom_column', 'almedis_populate_columns', 10, 2);
