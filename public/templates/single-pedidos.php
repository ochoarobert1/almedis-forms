<?php
/**
 * Single Pedidos Template File
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
<?php get_header(); ?>
<?php the_post(); ?>
<div class="main-pedidos-container">
    <?php
    $pedido_id = get_the_ID();
$status = get_post_meta($pedido_id, 'almedis_pedido_status', true);
?>
    <h2><a href="<?php echo home_url('/mi-cuenta');?>"><i class="fa fa-chevron-left"></i></a> Ver Pedido # <?php echo $pedido_id; ?></h2>

    <form enctype="multipart/form-data" id="almedisModalForm" class="main-almedis-modal-container" data-pedido="<?php echo $pedido_id; ?>">
        <div class="form-group">
            <h3>Datos del Pedido</h3>
            <label for="almedis_client_tipo"><?php _e('Tipo', 'almedis'); ?>: <?php echo get_post_meta($pedido_id, 'almedis_client_tipo', true); ?></label>
            <label for="almedis_client_name"><?php _e('Nombres y Apellidos', 'almedis'); ?>: <?php echo get_post_meta($pedido_id, 'almedis_client_name', true); ?></label>
            <label for="almedis_client_rut"><?php _e('RUT', 'almedis'); ?>: <?php echo get_post_meta($pedido_id, 'almedis_client_rut', true); ?></label>
            <label for="almedis_client_email"><?php _e('Email', 'almedis'); ?>: <?php echo get_post_meta($pedido_id, 'almedis_client_email', true); ?></label>
            <label for="natural_rut"><?php _e('Teléfono / WhatsApp', 'almedis'); ?>: <?php echo get_post_meta($pedido_id, 'almedis_client_phone', true); ?></label>
            <label for="natural_notification"><?php _e('Tipo de Notificación', 'almedis'); ?>: <?php echo get_post_meta($pedido_id, 'almedis_client_notification', true); ?></label>
            <label for="almedis_client_medicine"><?php _e('Nombre del Medicamento', 'almedis'); ?>: <?php echo get_post_meta($pedido_id, 'almedis_client_medicine', true); ?></label>
        </div>
        <div class="form-group form-group-bigger">
            <div id="archivesSingle" class="form-group-archives">
                <h3>Archivos</h3>
                <div class="custom-modal-file-control">
                    <?php $receta = get_post_meta($pedido_id, 'almedis_client_recipe', true); ?>
                    <?php $class = ($receta == '') ? 'hidden' : ''; ?>
                    <?php $missing = ($receta == '') ? 'missing' : 'submitted'; ?>
                    <?php $text = ($receta == '') ? 'Cargar ' : ''; ?>
                    <label for="client_recipe_file" class="custom-modal-file-upload">
                        <input id="client_recipe_file" name="client_recipe" class="form-control" type="file" />
                        <?php if ($receta != '') { ?>
                        <a class="almedis-file-icon <?php echo $class; ?>"></a><?php } ?> Receta <i id="recetaSelected" class="modal-file-helper <?php echo $missing; ?> fa fa-cloud-upload upload-icon"></i>
                    </label>
                    <?php if ($receta != '') { ?>
                    <div class="view-file">
                        <a href="<?php echo $receta; ?>" target="_blank"><i class="fa fa-file-text"></i> Ver archivo cargado</a>
                    </div>
                    <?php } ?>
                </div>
                <div class="custom-modal-file-control">
                    <?php $carta = get_post_meta($pedido_id, 'almedis_client_cartapoder', true); ?>
                    <?php $class = ($carta == '') ? 'hidden' : ''; ?>
                    <?php $missing = ($carta == '') ? 'missing' : 'submitted'; ?>
                    <?php $text = ($carta == '') ? 'Cargar ' : ''; ?>
                    <label for="client_carta_file" class="custom-modal-file-upload">
                        <input id="client_carta_file" name="client_carta" class="form-control" type="file" />
                        <?php if ($carta != '') { ?>
                        <a class="almedis-file-icon <?php echo $class; ?>"></a><?php } ?> Carta Poder <i id="cartaSelected" class="modal-file-helper <?php echo $missing; ?> fa fa-cloud-upload upload-icon"></i>
                    </label>
                    <?php if ($carta != '') { ?>
                    <div class="view-file">
                        <a href="<?php echo $carta; ?>" target="_blank"><i class="fa fa-file-text"></i> Ver archivo cargado</a>
                    </div>
                    <?php } ?>
                </div>
                <div class="custom-modal-file-control">
                    <?php $carnet = get_post_meta($pedido_id, 'almedis_client_carnet', true); ?>
                    <?php $class = ($carnet == '') ? 'hidden' : ''; ?>
                    <?php $missing = ($carnet == '') ? 'missing' : 'submitted'; ?>
                    <?php $text = ($carnet == '') ? 'Cargar ' : ''; ?>
                    <label for="client_carnet_file" class="custom-modal-file-upload">
                        <input id="client_carnet_file" name="client_carnet" class="form-control" type="file" />
                        <?php if ($carnet != '') { ?>
                        <a class="almedis-file-icon <?php echo $class; ?>"></a><?php } ?> Carnet de Identificación <i id="carnetSelected" class="modal-file-helper <?php echo $missing; ?> fa fa-cloud-upload upload-icon"></i>
                    </label>
                    <?php if ($carnet != '') { ?>
                    <div class="view-file">
                        <a href="<?php echo $carnet; ?>" target="_blank"><i class="fa fa-file-text"></i> Ver archivo cargado</a>
                    </div>
                    <?php } ?>
                </div>
                <div id="modalSubmit" class="form-group submit-group hidden">
                    <button id="docsSubmit" class="btn btn-md btn-cotizar"><?php _e('Guardar Cambios', 'almedis'); ?></button>
                    <div id="docsResult"></div>
                </div>
            </div>

            <div class="form-group-actions">
                <h3>Acciones</h3>
                <?php $codigo_id = get_post_meta($pedido_id, 'almedis_unique_id', true); ?>
                <a href="<?php echo home_url('/registrar-pago?pedido_id=') . $codigo_id; ?>" target="_blank" class="btn btn-md btn-cotizar">Registrar Pago</a>
            </div>

        </div>
        <div class="form-group tracking-modal submit-group">
            <h3>Seguimiento</h3>
            <?php
        if (($status == 'Cotizacion Recibida') || ($status == 'Pendiente de Pago') || ($status == 'Pago Confirmado')) {
            $value = 25;
        }
    if ($status == 'En Tránsito') {
        $value = 66;
    }
    if ($status == 'Completada') {
        $value = 100;
    }
    if ($status == 'Cancelada') {
        $value = 0;
    } ?>
            <div class="pedido-tracking-line-container">
                <div class="pedido-tracking-line ">
                    <?php $class = ($value < 1) ? 'cancel' : 'success'; ?>
                    <progress value="<?php echo $value; ?>" max="100" class="<?php echo $class; ?>"></progress>
                    <div class="pedido-tracking-item pedido-tracking-item-1">
                        <?php _e('Orden de Importación Generada', 'almedis'); ?>
                    </div>
                    <div class="pedido-tracking-item pedido-tracking-item-2">
                        <?php _e('Pedido en proceso de importación', 'almedis'); ?>
                    </div>
                    <div class="pedido-tracking-item pedido-tracking-item-3">
                        <?php _e('Pedido en tránsito a la dirección de entrega', 'almedis'); ?>
                    </div>
                </div>
                <div class="pedido-tracking-table">
                    <div class="pedido-tracking-table-item">
                        <div class="wrapper-text">
                            <span class="pedido-tracking-icon icon-1"></span><?php _e('Orden de Importación Generada', 'almedis'); ?>
                        </div>
                        <div class="wrapper-status">
                            <?php if ($value == 25) { ?>
                            Completado
                            <?php } else { ?>
                            En curso
                            <?php } ?>
                        </div>
                    </div>
                    <div class="pedido-tracking-table-item">
                        <div class="wrapper-text">
                            <span class="pedido-tracking-icon icon-2"></span><?php _e('Pedido en proceso de importación', 'almedis'); ?>
                        </div>
                        <div class="wrapper-status">
                            <?php if ($value == 66) { ?>
                            Completado
                            <?php } else { ?>
                            En curso
                            <?php } ?>
                        </div>
                    </div>
                    <div class="pedido-tracking-table-item">
                        <div class="wrapper-text">
                            <span class="pedido-tracking-icon icon-3"></span><?php _e('Pedido en tránsito a la dirección de entrega', 'almedis'); ?>
                        </div>
                        <div class="wrapper-status">
                            <?php if ($value == 100) { ?>
                            Completado
                            <?php } else { ?>
                            En curso
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="pedido-tracking-desc">
                    <?php if ($value == 25) { ?>
                    <p>Este proceso puede tomar de 2 a 4 días. La actualización del mismo será informada a través de su email.</p>
                    <?php } ?>
                    <?php if ($value == 66) { ?>
                    <p>Estamos trabajando en la importación de su pedido, lo que nos puede tomar de 7 a 11 dias. El avance será reportado vía email.</p>
                    <?php } ?>
                    <?php if ($value > 90) { ?>
                    <p>Su pedido está en el país y pronto será entregado a la dirección indicada. Este proceso puede tomar de 2 a 3 días.</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </form>
</div>
<?php get_footer(); ?>