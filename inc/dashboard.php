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
            __('Clientes', 'almedis_form'),
            __('Clientes', 'almedis_form'),
            'manage_options',
            'edit.php?post_type=pedidos',
            false,
            null
        );

        add_submenu_page(
            'almedis',
            __('Historial', 'almedis_form'),
            __('Historial', 'almedis_form'),
            'manage_options',
            'edit.php?post_type=pedidos',
            false,
            null
        );

        add_submenu_page(
            'almedis',
            __('Opciones', 'almedis_form'),
            __('Opciones', 'almedis_form'),
            'manage_options',
            'edit.php?post_type=pedidos',
            false,
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
                <p class="big-number">12 <span>+ 10 esta semana</span></p>
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
                <div class="almedis-list-item">
                    <div class="almedis-list-item-wrapper">
                        <div class="almedis-list-header">
                            <h3>Pedido #356</h3>
                            <p>Cliente: Robert Ochoa</p>
                            <span>Medicamentos: Amoxicilina</span>
                        </div>
                        <div class="actions-container">
                            <button><span class="dashicons dashicons-search"></span></button>
                            <button><span class="dashicons dashicons-yes"></span></button>
                            <button><span class="dashicons dashicons-no"></span></button>
                            <button><span class="dashicons dashicons-trash"></span></button>
                        </div>
                    </div>
                </div>

                <div class="almedis-list-item">
                    <div class="almedis-list-item-wrapper">
                        <div class="almedis-list-header">
                            <h3>Pedido #356</h3>
                            <p>Cliente: Robert Ochoa</p>
                            <span>Medicamentos: Amoxicilina</span>
                        </div>
                        <div class="actions-container">
                            <button><span class="dashicons dashicons-search"></span></button>
                            <button><span class="dashicons dashicons-yes"></span></button>
                            <button><span class="dashicons dashicons-no"></span></button>
                            <button><span class="dashicons dashicons-trash"></span></button>
                        </div>
                    </div>
                </div>

                <div class="almedis-list-item">
                    <div class="almedis-list-item-wrapper">
                        <div class="almedis-list-header">
                            <h3>Pedido #356</h3>
                            <p>Cliente: Robert Ochoa</p>
                            <span>Medicamentos: Amoxicilina</span>
                        </div>
                        <div class="actions-container">
                            <button><span class="dashicons dashicons-search"></span></button>
                            <button><span class="dashicons dashicons-yes"></span></button>
                            <button><span class="dashicons dashicons-no"></span></button>
                            <button><span class="dashicons dashicons-trash"></span></button>
                        </div>
                    </div>
                </div>

                <div class="almedis-list-item">
                    <div class="almedis-list-item-wrapper">
                        <div class="almedis-list-header">
                            <h3>Pedido #356</h3>
                            <p>Cliente: Robert Ochoa</p>
                            <span>Medicamentos: Amoxicilina</span>
                        </div>
                        <div class="actions-container">
                            <button><span class="dashicons dashicons-search"></span></button>
                            <button><span class="dashicons dashicons-yes"></span></button>
                            <button><span class="dashicons dashicons-no"></span></button>
                            <button><span class="dashicons dashicons-trash"></span></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="almedis-all-notifications">
                <button><?php _e('Ver Todos los Pedidos', 'almedis'); ?></button>
            </div>
        </div>
        <div class="almedis-dashboard-list-container">
            <div class="almedis-dashboard-list-header">
                <h2><span class="dashicons dashicons-warning"></span> <?php _e('Historial de Cambios', 'almedis'); ?></h2>
            </div>
            <div class="almedis-dashboard-list-content notifications-list">
                <div class="almedis-list-item">
                    <div class="almedis-list-item-wrapper">
                        <div class="almedis-list-notification">
                            Nuevo Ingreso
                        </div>
                    </div>
                </div>
                <div class="almedis-list-item">
                    <div class="almedis-list-item-wrapper">
                        <div class="almedis-list-notification">
                            Nuevo Ingreso
                        </div>
                    </div>
                </div>
                <div class="almedis-list-item">
                    <div class="almedis-list-item-wrapper">
                        <div class="almedis-list-notification">
                            Nuevo Ingreso
                        </div>
                    </div>
                </div>
                <div class="almedis-list-item">
                    <div class="almedis-list-item-wrapper">
                        <div class="almedis-list-notification">
                            Nuevo Ingreso
                        </div>
                    </div>
                </div>
                <div class="almedis-list-item">
                    <div class="almedis-list-item-wrapper">
                        <div class="almedis-list-notification">
                            Nuevo Ingreso
                        </div>
                    </div>
                </div>
                <div class="almedis-list-item">
                    <div class="almedis-list-item-wrapper">
                        <div class="almedis-list-notification">
                            Nuevo Ingreso
                        </div>
                    </div>
                </div>
                <div class="almedis-list-item">
                    <div class="almedis-list-item-wrapper">
                        <div class="almedis-list-notification">
                            Nuevo Ingreso
                        </div>
                    </div>
                </div>
                <div class="almedis-list-item">
                    <div class="almedis-list-item-wrapper">
                        <div class="almedis-list-notification">
                            Nuevo Ingreso
                        </div>
                    </div>
                </div>
                <div class="almedis-list-item">
                    <div class="almedis-list-item-wrapper">
                        <div class="almedis-list-notification">
                            Nuevo Ingreso
                        </div>
                    </div>
                </div>
                <div class="almedis-list-item">
                    <div class="almedis-list-item-wrapper">
                        <div class="almedis-list-notification">
                            Nuevo Ingreso
                        </div>
                    </div>
                </div>

            </div>
            <div class="almedis-all-notifications">
                <button><?php _e('Ver Todo el Historial', 'almedis'); ?></button>
            </div>
        </div>
    </div>
</div>
<?php
        echo self::almedis_get_footer();
    }
}

new AlmedisDashboard;