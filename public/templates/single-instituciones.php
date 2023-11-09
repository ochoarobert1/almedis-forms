<?php
/**
 * Single Instituciones Template File
 *
 * This file is used to markup the public-facing aspects of this custom post type.
 *
 * @link       https://indexart.cl
 * @since      1.0.0
 *
 * @package    Almedis_Forms
 * @subpackage Almedis_Forms/public/templates
 */
?>
<?php echo get_header(); ?>
<?php the_post(); ?>
<?php if (!is_user_logged_in()) { ?>
<main class="almedis-institucion-profile-container">
    <section class="almedis-institicion-data">
        <?php $image = get_post_meta(get_the_ID(), 'almedis_institucion_logo', true); ?>
        <?php $name = get_post_meta(get_the_ID(), 'almedis_institucion_name', true); ?>
        <?php $rut = get_post_meta(get_the_ID(), 'almedis_institucion_rut', true); ?>
        <?php $telf = get_post_meta(get_the_ID(), 'almedis_institucion_phone', true); ?>

        <?php if ($image != '') { ?>
        <img src="<?php echo $image?>" alt="<?php echo get_the_title(); ?>" />
        <h1><?php echo $name; ?></h1>
        <div class="meta-container">
            <?php if ($rut != '') { ?>
            <p><strong>RUT:</strong> <?php echo $rut; ?></p>
            <?php } ?>
            <?php if ($telf != '') { ?>
            <p><strong>Teléfono:</strong> <a href="tel:<?php echo $telf; ?>"><?php echo $telf; ?></a></p>
            <?php } ?>
        </div>
        <?php } ?>
    </section>
    <aside class="almedis-institicion-form">
        <h2 class="form-title">Formulario de Solicitud</h2>
        <form enctype="multipart/form-data" id="almedisConveniosSingleForm" class="almedis-form-container almedis-company-form-container">
            <input name="convenio_rut" id="convenio_rut" type="hidden" class="form-control almedis-form-control" value=" <?php echo $rut; ?>" />
            <input name="convenio_phone" id="convenio_phone" type="hidden" class="form-control almedis-form-control" value="<?php echo $telf; ?>" />
            <input name="convenio_notification" id="convenio_notification" type="hidden" class="form-control almedis-form-control" value="Correo Electrónico" />
            <input name="convenio_type" id="convenio_type" type="hidden" class="form-control almedis-form-control" value="institucion" />
            <input name="convenio_institucion" id="convenio_institucion" type="hidden" class="form-control almedis-form-control" value="<?php echo get_the_ID(); ?>" />
            <div class="form-group">
                <label for="convenio_nombre"><?php _e('Nombres y Apellidos', 'almedis'); ?></label>
                <input id="convenio_nombre" name="convenio_nombre" class="form-control almedis-form-control" type="text" autocomplete="name" />
                <small class="form-helper danger hidden"><?php _e('Error: El nombre debe ser válido', 'almedis'); ?></small>
            </div>
            <div class="form-group">
                <label for="convenio_email"><?php _e('Email', 'almedis'); ?></label>
                <input id="convenio_email" name="convenio_email" class="form-control almedis-form-control" type="text" autocomplete="email" />
                <small class="form-helper danger hidden"><?php _e('Error: El correo electrónico debe ser válido', 'almedis'); ?></small>
            </div>
            <div class="form-group form-group-button">
                <label for="convenio_medicine"><?php _e('Nombre del Medicamento', 'almedis'); ?></label>
                <input id="convenio_medicine" name="convenio_medicine" class="form-control almedis-form-control" type="text" />
                <small class="form-helper danger hidden"><?php _e('Error: El nombre del medicamento debe ser válido', 'almedis'); ?></small>
            </div>
            <div class="form-group">
                <label for="convenio_carnet_file" class="custom-file-upload">
                    <input id="convenio_carnet_file" name="convenio_carnet" class="form-control" type="file" />
                    Cargar Carnet de Identificación
                </label>
                <small class="form-helper danger hidden"><?php _e('Error: Debe seleccionar una de las opciones', 'almedis'); ?></small>
                <div class="file-helper carnet-file-helper hidden"><span class="almedis-file-icon"></span> <span id="convenioCarnetSelected"></span></div>
            </div>
            <div class="form-group">
                <small class="form-helper"><?php _e('Para poder procesar tu solicitud, el ISP nos exige una copia de su Carnet de identidad por el lado de la foto y Poder Simple (No notarial) que puede descargarla desde aquí.')?></small>
            </div>
            <div class="form-group">
                <label for="convenio_carta_file" class="custom-file-upload">
                    <input id="convenio_carta_file" name="convenio_cartapoder" class="form-control" type="file" />
                    Cargar Carta Poder
                </label>
                <small class="form-helper danger hidden"><?php _e('Error: Debe seleccionar una de las opciones', 'almedis'); ?></small>
                <div class="file-helper carta-file-helper hidden"><span class="almedis-file-icon"></span> <span id="convenioCartaSelected"></span></div>
            </div>
            <div class="form-group">
                <small class="form-helper"><?php _e('Para poder procesar tu solicitud, debes enviar una carta poder que autorice el pedido, si no la tienes, puedes descargarla en la sección de recursos.')?></small>
            </div>
            <div class="form-group submit-group">
                <button id="convenioSingleSubmit" class="btn btn-md btn-cotizar"><?php _e('Enviar documentos', 'almedis'); ?></button>
                <div id="convenioResult"></div>
            </div>
        </form>
    </aside>
</main>
<?php
} else {
    $user = wp_get_current_user(); ?>
<section id="almedisUserDashboard" class="almedis-user-dashboard almedis-institucion-dashboard">
    <aside class="almedis-user-dashboard-menu">
        <ul>
            <li class="user-data-list"><span class="dashicons dashicons-building"></span> <?php the_title(); ?></li>
            <li><a href="" class="almedis-user-tab" data-tab="dashboard"><span class="dashicons dashicons-admin-home"></span> <?php _e('Escritorio', 'almedis'); ?></a></li>
            <li><a href="" class="almedis-user-tab" data-tab="pedidos"><span class="dashicons dashicons-welcome-widgets-menus"></span> <?php _e('Pedidos', 'almedis'); ?></a></li>
            <li><a href="" class="almedis-user-tab" data-tab="datos"><span class="dashicons dashicons-nametag"></span> <?php _e('Datos de la Institución', 'almedis'); ?></a></li>
            <li><a href="" class="almedis-user-tab" data-tab="user"><span class="dashicons dashicons-admin-users"></span> <?php _e('Usuarios', 'almedis'); ?></a></li>
            <li><a href="<?php echo esc_url(wp_logout_url(home_url('/mi-cuenta'))); ?>"><span class="dashicons dashicons-download"></span> <?php _e('Cerrar Sesión', 'almedis'); ?></a></li>
        </ul>
    </aside>
    <div class="almedis-user-dashboard-menu">
        <?php $args = array('post_type' => 'pedidos', 'posts_per_page' => -1, 'order' => 'DESC', 'orderby' => 'date', 'meta_query' => array(array('key' => 'almedis_client_institucion', 'value' => get_the_ID(), 'compare' => '='))); ?>
        <?php $arr_pedidos = new WP_Query($args); ?>
        <?php $total = $arr_pedidos->found_posts; ?>
        <div id="dashboard" class="almedis-user-dashboard-tab">
            <div class="almedis-user-dashboard-title">
                <h2><?php _e('Escritorio', 'almedis'); ?></h2>
            </div>
            <div class="almedis-user-dashboard-card">
                <div class="card-list">
                    <span class="dashicons dashicons-cloud-saved"></span>
                    <h3><?php _e('Pedidos', 'almedis'); ?></h3>
                </div>
                <div class="almedis-user-dashboard-big-number"><?php echo $total; ?></div>
            </div>
            <div class="almedis-user-dashboard-card">
                <div class="card-list">
                    <span class="dashicons dashicons-cloud-upload"></span>
                    <h3><?php _e('Pendientes', 'almedis'); ?></h3>
                </div>
                <div class="almedis-user-dashboard-big-number"><?php echo $total; ?></div>
            </div>
            <div class="almedis-user-dashboard-table">
                <table id="tableUser">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Nombre</th>
                            <th>Código</th>
                            <th>Medicina</th>
                            <th>Estatus</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $args = array('post_type' => 'pedidos', 'posts_per_page' => 7, 'order' => 'DESC', 'orderby' => 'date', 'meta_query' => array(array('key' => 'almedis_client_institucion', 'value' => get_the_ID(), 'compare' => '='))); ?>
                        <?php $arr_pedidos = new WP_Query($args); ?>
                        <?php if ($arr_pedidos->have_posts()) : ?>
                        <?php while ($arr_pedidos->have_posts()) : $arr_pedidos->the_post(); ?>
                        <tr>
                            <td><?php echo get_the_ID(); ?></td>
                            <td><?php echo get_the_date('d-m-Y'); ?></td>
                            <td><?php echo get_post_meta(get_the_ID(), 'almedis_client_name', true); ?></td>
                            <td><span class="pedidos-code"><?php echo get_post_meta(get_the_ID(), 'almedis_unique_id', true); ?></span></td>
                            <td><?php echo get_post_meta(get_the_ID(), 'almedis_client_medicine', true); ?></td>
                            <td><span class="pedidos-status"><?php echo get_post_meta(get_the_ID(), 'almedis_client_status', true); ?></span></td>
                            <?php $codigo_id = get_post_meta(get_the_ID(), 'almedis_unique_id', true); ?>
                            <td><a class="almedis-pedido-click" href="<?php echo get_permalink(get_the_ID()); ?>" data-pedido="<?php echo get_the_ID(); ?>"><span class="dashicons dashicons-visibility"></span> Ver Pedido</a><a class="almedis-repeat-pedido-click" data-pedido="<?php echo get_the_ID(); ?>"><span class="dashicons dashicons-image-rotate"></span> Repetir Pedido</a><a href="<?php echo home_url('/registrar-pago?pedido_id=') . $codigo_id; ?>" class="almedis-process-pedido-click"><span class="dashicons dashicons-cart"></span> Registrar Pago</a></td>
                        </tr>
                        <?php endwhile; ?>
                        <?php else : ?>
                        <tr>
                            <td colspan="7">No hay pedidos actualmente</td>
                        </tr>
                        <?php endif; ?>
                        <?php wp_reset_query(); ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7">
                                <a href="" class="btn btn-pedidos"><?php _e('Ver todos los pedidos', 'almedis'); ?></a>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div id="pedidos" class="almedis-user-dashboard-tab hidden">
            <div class="almedis-user-dashboard-title">
                <h2><?php _e('Pedidos', 'almedis'); ?></h2>
                <div class="buttons-container">
                    <a href="" class="btn new-pedido"><?php _e('Nuevo Pedido', 'almedis'); ?></a>
                    <a id="downloadXLS" href="" class="btn download-pedido"><?php _e('Descargar Pedido', 'almedis'); ?></a>
                </div>
            </div>
            <div class="almedis-user-dashboard-table">
                <table id="tablePedidos">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Nombre</th>
                            <th>Código</th>
                            <th>Medicina</th>
                            <th>Estatus</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $args = array('post_type' => 'pedidos', 'posts_per_page' => -1, 'order' => 'DESC', 'orderby' => 'date', 'meta_query' => array(array('key' => 'almedis_client_institucion', 'value' => get_the_ID(), 'compare' => '='))); ?>
                        <?php $arr_pedidos = new WP_Query($args); ?>
                        <?php if ($arr_pedidos->have_posts()) : ?>
                        <?php while ($arr_pedidos->have_posts()) : $arr_pedidos->the_post(); ?>
                        <tr>
                            <td><?php echo get_the_ID(); ?></td>
                            <td><?php echo get_the_date('d-m-Y'); ?></td>
                            <td><?php echo get_post_meta(get_the_ID(), 'almedis_client_name', true); ?></td>
                            <td><span class="pedidos-code"><?php echo get_post_meta(get_the_ID(), 'almedis_unique_id', true); ?></span></td>
                            <td><?php echo get_post_meta(get_the_ID(), 'almedis_client_medicine', true); ?></td>
                            <td><span class="pedidos-status"><?php echo get_post_meta(get_the_ID(), 'almedis_client_status', true); ?></span></td>
                            <?php $codigo_id = get_post_meta(get_the_ID(), 'almedis_unique_id', true); ?>
                            <td><a class="almedis-pedido-click" href="<?php echo get_permalink(get_the_ID()); ?>" data-pedido="<?php echo get_the_ID(); ?>"><span class="dashicons dashicons-visibility"></span> Ver Pedido</a><a class="almedis-repeat-pedido-click" data-pedido="<?php echo get_the_ID(); ?>"><span class="dashicons dashicons-image-rotate"></span> Repetir Pedido</a><a href="<?php echo home_url('/registrar-pago?pedido_id=') . $codigo_id; ?>" class="almedis-process-pedido-click"><span class="dashicons dashicons-cart"></span> Registrar Pago</a></td>
                        </tr>
                        <?php endwhile; ?>
                        <?php else : ?>
                        <tr>
                            <td colspan="7">No hay pedidos actualmente</td>
                        </tr>
                        <?php endif; ?>
                        <?php wp_reset_query(); ?>
                    </tbody>
                </table>
            </div>
            <div class="almedis-user-single-pedido"></div>
        </div>
        <div id="datos" class="almedis-user-dashboard-tab hidden">
            <div class="almedis-user-dashboard-title">
                <h2><?php _e('Datos Personales', 'almedis'); ?></h2>
            </div>
            <form id="updateInstitucionData" class="almedis-user-dashboard-data">
                <input type="hidden" name="inst_id" id="inst_id" value="<?php echo get_the_ID(); ?>">
                <div class="form-group">
                    <label for="institucion_nombre"><?php _e('Nombres de la Clinica', 'almedis'); ?></label>
                    <input id="institucion_nombre" name="institucion_nombre" class="form-control almedis-form-control" type="text" autocomplete="name" value="<?php echo get_the_title(); ?>" />
                    <small class="form-helper danger hidden"><?php _e('Error: El nombre debe ser válido', 'almedis'); ?></small>
                </div>
                <div class="form-group">
                    <label for="institucion_rut"><?php _e('RUT', 'almedis'); ?></label>
                    <input id="institucion_rut" name="institucion_rut" class="form-control almedis-form-control" type="text" autocomplete="rut" value="<?php echo get_post_meta(get_the_ID(), 'almedis_institucion_rut', true); ?>" />
                    <small class="form-helper danger hidden"><?php _e('Error: El RUT debe ser válido', 'almedis'); ?></small>
                </div>
                <div class="form-group">
                    <label for="institucion_phone"><?php _e('Teléfono / WhatsApp', 'almedis'); ?></label>
                    <input id="institucion_phone" name="institucion_phone" class="form-control almedis-form-control" type="text" autocomplete="tel" value="<?php echo get_post_meta(get_the_ID(), 'almedis_institucion_phone', true); ?>" />
                    <small class="form-helper danger hidden"><?php _e('Error: El teléfono debe ser válido', 'almedis'); ?></small>
                </div>
                <div class="form-group submit-group">
                    <button id="institucionSubmit" class="btn btn-md btn-cotizar"><?php _e('Guardar Cambios', 'almedis'); ?></button>
                    <div id="institucionResult"></div>
                </div>
            </form>
        </div>
    </div>
</section>
<?php
}?>
<div id="modal" class="modal modal-hidden">
    <div class="modal-container">
        <div id="closeModal" class="close-modal"></div>
        <div id="modalHeader" class="modal-header">

        </div>
        <div id="modalContent" class="modal-content">

        </div>
    </div>
</div>
<?php echo get_footer(); ?>