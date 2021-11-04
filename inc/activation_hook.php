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
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-money-alt',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
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
 * Method almedis_activate
 *
 * @return void
 */

function almedis_activate()
{
    almedis_cpt_pedidos();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'almedis_activate');
