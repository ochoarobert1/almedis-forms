<?php

/**
* Almedis Dashboard - Shortcodes Creator
*
*
* @package    almedis-forms
* @subpackage shortcodes
*
*/

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class AlmedisAccountDashboard extends AlmedisForm
{
    /**
     * Method __construct
     *
     * @return void
     */
    public function __construct()
    {
        add_action('init', array($this, 'almedis_account_custom_shortcode'));
    }
    
    
    /**
     * Method almedis_add_custom_shortcode
     *
     * @return void
     */
    public function almedis_account_custom_shortcode()
    {
        add_shortcode('almedis-myaccount', array($this, 'almedis_myaccount_callback' ));
    }
    
    /**
     * Method almedis_myaccount_callback
     *
     * @param $atts Array
     * @param $content String
     *
     * @return void
     */
    public function almedis_myaccount_callback($atts, $content = '')
    {
        wp_enqueue_script('almedis-login');

        ob_start();
        if (!is_user_logged_in()) { ?>
<form id="almedisLoginForm" class="almedis-login-form">
    <div class="almedis-login-form-wrapper">
        <div class="almedis-login-title-wrapper">
            <img src="<?php echo WP_PLUGIN_URL . '/almedis-forms/img/logo.png'; ?>" alt="Almedis" class="img-fluid logo" />
            <div class="almedis-login-form-title">
                <h2><?php _e('Ingrese en su cuenta', 'almedis'); ?></h2>
            </div>
        </div>
        <div class="almedis-login-form-content">
            <div class="almedis-login-form-input-item">
                <label for="username"><?php _e('Nombre de Usuario / Correo Electrónico:', 'almedis'); ?></label>
                <input id="username" class="almedis-form-control" type="text" name="username" autocomplete="username" />
                <small class="form-helper danger hidden"><?php _e('Error: El nombre debe ser válido', 'almedis'); ?></small>
            </div>
            <div class="almedis-login-form-input-item">
                <label for="password"><?php _e('Contraseña:', 'almedis'); ?></label>
                <input id="password" class="almedis-form-control" type="password" name="password" autocomplete="current-password" />
                <small class="form-helper danger hidden"><?php _e('Error: La contraseña debe ser válida', 'almedis'); ?></small>
            </div>

            <div class="almedis-login-form-input-item">
                <button id="almedisLoginSubmit" class="btn btn-md btn-login"><?php _e('Ingresar', 'almedis'); ?></button>
            </div>

            <div class="almedis-login-form-response-item">
                <div id="loginResult"></div>
            </div>
        </div>
    </div>
</form>
<?php
        } else {
            $user = wp_get_current_user(); ?>
<section id="almedisUserDashboard" class="almedis-user-dashboard">
    <aside class="almedis-user-dashboard-menu">
        <ul>
            <li class="user-data-list"><span class="dashicons dashicons-admin-users"></span> <span class="user-name"> <?php echo $user->first_name.' '.$user->last_name; ?></span></li>
            <li><a href="" class="almedis-user-tab" data-tab="dashboard"><span class="dashicons dashicons-admin-home"></span> <?php _e('Escritorio', 'almedis'); ?></a></li>
            <li><a href="" class="almedis-user-tab" data-tab="pedidos"><span class="dashicons dashicons-welcome-widgets-menus"></span> <?php _e('Pedidos', 'almedis'); ?></a></li>
            <li><a href="" class="almedis-user-tab" data-tab="datos"><span class="dashicons dashicons-nametag"></span> <?php _e('Datos Personales', 'almedis'); ?></a></li>
            <li><a href="<?php echo esc_url(wp_logout_url(home_url('/mi-cuenta'))); ?>"><span class="dashicons dashicons-download"></span> <?php _e('Cerrar Sesión', 'almedis'); ?></a></li>
        </ul>
    </aside>
    <div class="almedis-user-dashboard-menu">
        <?php $args = array('post_type' => 'pedidos', 'posts_per_page' => -1, 'order' => 'DESC', 'orderby' => 'date', 'meta_query' => array(array('key' => 'almedis_client_user', 'value' => get_current_user_id(), 'compare' => '='))); ?>
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
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Código</th>
                            <th>Medicina</th>
                            <th>Estatus</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $args = array('post_type' => 'pedidos', 'posts_per_page' => 7, 'order' => 'DESC', 'orderby' => 'date', 'meta_query' => array(array('key' => 'almedis_client_user', 'value' => get_current_user_id(), 'compare' => '='))); ?>
                        <?php $arr_pedidos = new WP_Query($args); ?>
                        <?php if ($arr_pedidos->have_posts()) : ?>
                        <?php while ($arr_pedidos->have_posts()) : $arr_pedidos->the_post(); ?>
                        <tr>
                            <td><?php echo get_the_ID(); ?></td>
                            <td><span class="pedidos-code"><?php echo get_post_meta(get_the_ID(), 'almedis_unique_id', true); ?></span></td>
                            <td><?php echo get_post_meta(get_the_ID(), 'almedis_client_medicine', true); ?></td>
                            <td><span class="pedidos-status">En Proceso</span></td>
                            <td><a href=""><span class="dashicons dashicons-visibility"></span></a></td>
                        </tr>
                        <?php endwhile; ?>
                        <?php else : ?>
                        <tr>
                            <td colspan="5">No hay pedidos actualmente</td>
                        </tr>
                        <?php endif; ?>
                        <?php wp_reset_query(); ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5">
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
                <a href="" class="btn new-pedido"><?php _e('Nuevo Pedido', 'almedis'); ?></a>
            </div>
            <div class="almedis-user-dashboard-table">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Código</th>
                            <th>Medicina</th>
                            <th>Estatus</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $args = array('post_type' => 'pedidos', 'posts_per_page' => -1, 'order' => 'DESC', 'orderby' => 'date', 'meta_query' => array(array('key' => 'almedis_client_user', 'value' => get_current_user_id(), 'compare' => '='))); ?>
                        <?php $arr_pedidos = new WP_Query($args); ?>
                        <?php if ($arr_pedidos->have_posts()) : ?>
                        <?php while ($arr_pedidos->have_posts()) : $arr_pedidos->the_post(); ?>
                        <tr>
                            <td><?php echo get_the_ID(); ?></td>
                            <td><span class="pedidos-code"><?php echo get_post_meta(get_the_ID(), 'almedis_unique_id', true); ?></span></td>
                            <td><?php echo get_post_meta(get_the_ID(), 'almedis_client_medicine', true); ?></td>
                            <td><span class="pedidos-status">En Proceso</span></td>
                            <td><a href=""><span class="dashicons dashicons-visibility"></span></a></td>
                        </tr>
                        <?php endwhile; ?>
                        <?php else : ?>
                        <tr>
                            <td colspan="5">No hay pedidos actualmente</td>
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
            <form action="" class="almedis-user-dashboard-data">
                <div class="form-group">
                    <label for="natural_nombre"><?php _e('Nombres y Apellidos', 'almedis'); ?></label>
                    <input id="natural_nombre" name="natural_nombre" class="form-control almedis-form-control" type="text" autocomplete="name" />
                    <small class="form-helper danger hidden"><?php _e('Error: El nombre debe ser válido', 'almedis'); ?></small>
                </div>
                <div class="form-group">
                    <label for="natural_rut"><?php _e('RUT', 'almedis'); ?></label>
                    <input id="natural_rut" name="natural_rut" class="form-control almedis-form-control" type="text" autocomplete="rut" />
                    <small class="form-helper danger hidden"><?php _e('Error: El RUT debe ser válido', 'almedis'); ?></small>
                </div>
                <div class="form-group">
                    <label for="natural_phone"><?php _e('Teléfono / WhatsApp', 'almedis'); ?></label>
                    <input id="natural_phone" name="natural_phone" class="form-control almedis-form-control" type="text" autocomplete="tel" />
                    <small class="form-helper danger hidden"><?php _e('Error: El teléfono debe ser válido', 'almedis'); ?></small>
                </div>
            </form>
        </div>
    </div>
</section>
<?php
        }
        $content = ob_get_clean();
        return $content;
    }
}

new AlmedisAccountDashboard;