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
        'items_list_navigation' => __('Navegaci??n del Listado de Pedidos', 'almedis'),
        'filter_items_list'     => __('Filtro del Listado de Pedidos', 'almedis'),
    );
    $args = array(
        'label'                 => __('Pedido', 'almedis'),
        'description'           => __('Pedidos dentro del sitio', 'almedis'),
        'labels'                => $labels,
        'supports'              => array( 'title' ),
        'taxonomies'            => array( 'status' ),
        'hierarchical'          => false,
        'public'                => false,
        'show_ui'               => true,
        'show_in_menu'          => false,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-money-alt',
        'show_in_admin_bar'     => false,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => false,
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
        'singular_name'         => _x('Instituci??n', 'Post Type Singular Name', 'almedis'),
        'menu_name'             => __('Instituciones', 'almedis'),
        'name_admin_bar'        => __('Instituciones', 'almedis'),
        'archives'              => __('Archivo de Instituciones', 'almedis'),
        'attributes'            => __('Atributos de Instituci??n', 'almedis'),
        'parent_item_colon'     => __('Instituci??n Padre:', 'almedis'),
        'all_items'             => __('Todas las Instituciones', 'almedis'),
        'add_new_item'          => __('Agregar Nueva Instituci??n', 'almedis'),
        'add_new'               => __('Agregar Nueva', 'almedis'),
        'new_item'              => __('Nueva Instituci??n', 'almedis'),
        'edit_item'             => __('Editar Instituci??n', 'almedis'),
        'update_item'           => __('Actualizar Instituci??n', 'almedis'),
        'view_item'             => __('Ver Instituci??n', 'almedis'),
        'view_items'            => __('Ver Instituciones', 'almedis'),
        'search_items'          => __('Buscar Instituci??n', 'almedis'),
        'not_found'             => __('No hay resultados', 'almedis'),
        'not_found_in_trash'    => __('No hay resultados en Papelera', 'almedis'),
        'featured_image'        => __('Imagen Destacada', 'almedis'),
        'set_featured_image'    => __('Colocar Imagen Destacada', 'almedis'),
        'remove_featured_image' => __('Remover Imagen Destacada', 'almedis'),
        'use_featured_image'    => __('Usar como Imagen Destacada', 'almedis'),
        'insert_into_item'      => __('Insertar en Instituci??n', 'almedis'),
        'uploaded_to_this_item' => __('Cargado a esta Instituci??n', 'almedis'),
        'items_list'            => __('Listado de Instituciones', 'almedis'),
        'items_list_navigation' => __('Navegaci??n del Listado de Instituciones', 'almedis'),
        'filter_items_list'     => __('Filtro del Listado de Instituciones', 'almedis'),
    );
    $args = array(
        'label'                 => __('Instituci??n', 'almedis'),
        'description'           => __('Instituciones dentro de la Empresa', 'almedis'),
        'labels'                => $labels,
        'supports'              => array( 'title' ),
        'taxonomies'            => array( 'status' ),
        'hierarchical'          => false,
        'public'                => false,
        'show_ui'               => true,
        'show_in_menu'          => false,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-building',
        'show_in_admin_bar'     => false,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => false,
        'capability_type'       => 'page',
        'show_in_rest'          => true,
    );
    register_post_type('instituciones', $args);
}
add_action('init', 'almedis_cpt_instituciones', 0);



function almedis_filter_pedidos_columns($columns)
{
    unset($columns['date']);
    $columns['almedis_unique_id'] = __('C??digo ??nico', 'almedis');
    $columns['almedis_client_name'] = __('Nombre y Apellido', 'almedis');
    $columns['almedis_client_email'] = __('Correo Electr??nico', 'almedis');
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

function almedis_filter_instituciones_columns($columns)
{
    unset($columns['date']);
    $columns['almedis_institucion_logo'] = __('Logo', 'almedis');
    $columns['almedis_institucion_rut'] = __('RUT', 'almedis');
    $columns['almedis_institucion_email'] = __('Correo Electr??nico', 'almedis');
    $columns['almedis_institucion_phone'] = __('Tel??fono', 'almedis');
    $columns['almedis_institucion_encargado'] = __('Encargado', 'almedis');
    $columns['date'] = __('Date', 'wordpress');
    return $columns;
}

add_filter('manage_instituciones_posts_columns', 'almedis_filter_instituciones_columns');


function almedis_instituciones_populate_columns($column, $post_id)
{
    // Image column
    if ('almedis_institucion_logo' === $column) {
        $value = get_post_meta($post_id, 'almedis_institucion_logo', true);
        ob_start(); ?>

        <?php $image = ($value == '') ? 'http://placehold.it/100x100' : $value; ?>
        <img id="almedis_institucion_logo_img" src="<?php echo $image ?>" alt="Logo" class="avatar avatar-img" />
<?php
        $content = ob_get_clean();
        echo $content;
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
add_action('manage_instituciones_posts_custom_column', 'almedis_instituciones_populate_columns', 10, 2);