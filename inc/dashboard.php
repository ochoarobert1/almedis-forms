<?php

/**
* Almedis Dashboard - Dashboard Creator
*
*
* @package    almedis-forms
* @subpackage dashboard
*
*/

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class AlmedisDashboard extends AlmedisForm
{
    /**
     * Method __construct
     *
     * @return void
     */
    public function __construct()
    {
        add_action('admin_menu', array($this, 'almedis_admin_menu'));
    }

    /**
     * Method almedis_admin_menu
     *
     * @return void
     */
    public function almedis_admin_menu()
    {
        // Add menu admin
        add_menu_page(
            __('Escritorio', 'almedis-forms'),
            'Almedis',
            'manage_options',
            'almedis',
            array($this, 'almedis_dashboard'),
            plugin_dir_url(__DIR__) . 'img/icon.png',
            3
        );

        add_submenu_page(
            'almedis',
            __('Pedidos', 'almedis_form'),
            __('Pedidos', 'almedis_form'),
            'manage_options',
            'edit.php?post_type=pedidos',
            false,
            null
        );

        add_submenu_page(
            'almedis',
            __('Instituciones', 'almedis_form'),
            __('Instituciones', 'almedis_form'),
            'manage_options',
            'edit.php?post_type=instituciones',
            false,
            null
        );

        add_submenu_page(
            'almedis',
            __('Clientes', 'almedis_form'),
            __('Clientes', 'almedis_form'),
            'manage_options',
            'almedis-clienes',
            array($this, 'almedis_clientes'),
            null
        );

        add_submenu_page(
            'almedis',
            __('Historial de Cambios', 'almedis_form'),
            __('Historial', 'almedis_form'),
            'manage_options',
            'almedis-historial',
            array($this, 'almedis_historial'),
            null
        );

        add_submenu_page(
            'almedis',
            __('Opciones', 'almedis_form'),
            __('Opciones', 'almedis_form'),
            'manage_options',
            'almedis-opciones',
            array($this, 'almedis_opciones'),
            null
        );
    }
    
    /**
     * Method almedis_get_header
     *
     * @return void
     */
    public function almedis_get_header()
    {
        ob_start();
        require_once('template-parts/admin-header.php');
        $content_header = ob_get_clean();
        return $content_header;
    }
    
    /**
     * Method almedis_get_footer
     *
     * @return void
     */
    public function almedis_get_footer()
    {
        ob_start();
        require_once('template-parts/admin-footer.php');
        $content_footer = ob_get_clean();
        return $content_footer;
    }

    public function almedis_clientes()
    {
        echo self::almedis_get_header();

        echo self::almedis_get_footer();
    }

    public function almedis_historial()
    {
        echo self::almedis_get_header(); ?>

<div class="almedis-content">
    <div class="almedis-historial-content-wrapper">
        <?php $historial = AlmedisHistorial::select_almedis_historial(); ?>
        <?php if (!empty($historial)) : ?>
        <?php foreach ($historial as $item) { ?>
        <?php $type = AlmedisHistorial::get_almedis_historial_type($item->desc); ?>
        <div class="almedis-historial-item historial-type-<?php echo strtolower(sanitize_title($type[0])); ?>">
            <?php $fecha = DateTime::createFromFormat('Y-m-d H:i:s', $item->date); ?>
            <span><strong>Dia:</strong> <?php echo $fecha->format('d-m-Y'); ?></span> <span><strong>Hora:</strong> <?php echo $fecha->format('H:i:s'); ?></span>

            <p><strong><?php echo $type[0]; ?>:</strong> <?php echo $type[1]; ?></p>
        </div>
        <?php } ?>
        <?php endif; ?>
        <div class="almedis-historial-item last-item">
            <p><span class="smiling-face">☺</span> No hay más items de historial</p>
        </div>
    </div>
</div>

<?php
        echo self::almedis_get_footer();
    }

    public function almedis_opciones()
    {
        echo self::almedis_get_header();

        echo self::almedis_get_footer();
    }
    
    /**
     * Method almedis_dashboard
     *
     * @return void
     */
    public function almedis_dashboard()
    {
        echo self::almedis_get_header(); ?>
<div class="almedis-content">
    <div class="almedis-dashboard-info main-dashboard">
        <div id="pedidos" class="almedis-dashboard-item">
            <div class="almedis-dashicons-icon">
                <span class="dashicons dashicons-money-alt"></span>
            </div>
            <div class="almedis-dashboard-wrapper">
                <h4>Pedidos</h4>
                <?php $pedidos = get_posts(array('numberposts' => -1, 'post_type' => 'pedidos', 'orderby' => 'date', 'order' => 'DESC')); ?>
                <?php if ($pedidos) : ?>
                <p class="big-number"><?php echo count($pedidos); ?> <span>+ 10 esta semana</span></p>
                <?php else : ?>
                <p class="big-number">0</p>
                <?php endif; ?>
                
            </div>
        </div>
        <div id="clients" class="almedis-dashboard-item">
            <div class="almedis-dashicons-icon">
                <span class="dashicons dashicons-admin-users"></span>
            </div>
            <div class="almedis-dashboard-wrapper">
                <h4>Clientes</h4>
                <p class="big-number">12 <span>+ 5 esta semana</span></p>
            </div>
        </div>
        <div id="orders" class="almedis-dashboard-item">
            <div class="almedis-dashicons-icon">
                <span class="dashicons dashicons-admin-users"></span>
            </div>
            <div class="almedis-dashboard-wrapper">
                <h4>Ordenes de Compra</h4>
                <p class="big-number">$ 1,200.00 <span>+ $ 100 esta semana</span></p>
            </div>
        </div>
    </div>
    <div class="almedis-dashboard-info">
        <div class="almedis-dashboard-list-container">
            <div class="almedis-dashboard-list-header">
                <h2><span class="dashicons dashicons-money-alt"></span> <?php _e('Últimos Pedidos', 'almedis'); ?></h2>
            </div>
            <div class="almedis-dashboard-list-content">
                <?php $pedidos = get_posts(array('numberposts' => -1, 'post_type' => 'pedidos', 'orderby' => 'date', 'order' => 'DESC')); ?>
                <?php if ($pedidos) { ?>
                <?php foreach ($pedidos as $pedido) { ?>
                <div class="almedis-list-item">
                    <div class="almedis-list-item-wrapper">
                        <div class="almedis-list-header">
                            <h3><?php echo $pedido->post_title; ?></h3>
                            <p>Cliente: <?php echo get_post_meta($pedido->ID, 'almedis_client_name', true); ?></p>
                            <span>Medicamentos: <?php echo get_post_meta($pedido->ID, 'almedis_client_medicine', true); ?></span>
                        </div>
                        <div class="actions-container">
                            <a><span class="dashicons dashicons-search"></span></a>
                            <a><span class="dashicons dashicons-yes"></span></a>
                            <a><span class="dashicons dashicons-no"></span></a>
                            <a><span class="dashicons dashicons-trash"></span></a>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php } ?>
            </div>
            <div class="almedis-all-notifications">
                <a href="<?php echo admin_url('/edit.php?post_type=pedidos'); ?>" class="btn-dashboard"><?php _e('Ver Todos los Pedidos', 'almedis'); ?></a>
            </div>
        </div>
        <div class="almedis-dashboard-list-container">
            <div class="almedis-dashboard-list-header">
                <h2><span class="dashicons dashicons-warning"></span> <?php _e('Historial de Cambios', 'almedis'); ?></h2>
            </div>
            <div class="almedis-dashboard-list-content notifications-list">
                <?php $historial = AlmedisHistorial::select_almedis_historial(); ?>
                <?php if (!empty($historial)) : ?>
                <?php foreach ($historial as $item) { ?>
                <?php $type = AlmedisHistorial::get_almedis_historial_type($item->desc); ?>
                <div class="almedis-list-item">
                    <div class="almedis-list-item-wrapper">
                        <div class="almedis-list-notification notification-type-<?php echo strtolower(sanitize_title($type[0])); ?>">
                            <div class="date-container">
                                <?php $fecha = DateTime::createFromFormat('Y-m-d H:i:s', $item->date); ?>
                                <span><strong>Dia:</strong> <?php echo $fecha->format('d-m-Y'); ?></span> <span><strong>Hora:</strong> <?php echo $fecha->format('H:i:s'); ?></span>
                            </div>
                            <div class="info-container">
                                <strong><?php echo $type[0]; ?>:</strong> <span><?php echo $type[1]; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php endif; ?>
            </div>
            <div class="almedis-all-notifications">
                <a class="btn-dashboard" href="<?php echo admin_url('/admin.php?page=almedis-historial'); ?>"><?php _e('Ver Todo el Historial', 'almedis'); ?></a>
            </div>
        </div>
    </div>
</div>
<?php
        echo self::almedis_get_footer();
    }
}

new AlmedisDashboard;
