<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://indexart.cl
 * @since      1.0.0
 *
 * @package    Almedis_Forms
 * @subpackage Almedis_Forms/admin
 */

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
class Almedis_Forms_Public_Account_Dashboard
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
        ob_start();
        if (!is_user_logged_in()) { ?>
<form id="almedisLoginForm" class="almedis-login-form">
    <div class="almedis-login-form-wrapper">
        <div class="almedis-login-title-wrapper">
            <img src="<?php echo WP_PLUGIN_URL . '/almedis-forms/public/img/logo.png'; ?>" alt="Almedis" class="img-fluid logo" />
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
                <a href="<?php echo home_url('/recuperar-contrasena'); ?>" class="btn btn-md btn-recover"><?php _e('¿Olvido su contraseña?', 'almedis'); ?></a>
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
            $user = wp_get_current_user();
            foreach ($user->roles as $role) {
                if ($role == 'almedis_admin') {
                    $instituto = get_user_meta($user->ID, 'almedis_client_instituto', true);
                    if ($instituto != '') {
                        $instituto_url = get_permalink($instituto); ?>
    <script type="text/javascript">
        console.log('hola');
        var redirectURL = '<?php echo $instituto_url; ?>';
        window.location.replace(redirectURL);
    </script>
    <?php
                    }
                }
            } ?>
<section id="almedisUserDashboard" class="almedis-user-dashboard">
    <aside class="almedis-user-dashboard-menu">
        <ul>
            <li class="user-data-list"><span class="dashicons dashicons-admin-users"></span> <span class="user-name"> <?php echo $user->first_name.' '.$user->last_name; ?></span></li>
            <li><a href="" class="almedis-user-tab" data-tab="dashboard"><span class="dashicons dashicons-admin-home"></span> <span class="account-menu-name"><?php _e('Escritorio', 'almedis'); ?></span></a></li>
            <li><a href="" class="almedis-user-tab" data-tab="pedidos"><span class="dashicons dashicons-welcome-widgets-menus"></span> <span class="account-menu-name"><?php _e('Pedidos', 'almedis'); ?></span></a></li>
            <li><a href="" class="almedis-user-tab" data-tab="datos"><span class="dashicons dashicons-nametag"></span> <span class="account-menu-name"><?php _e('Datos Personales', 'almedis'); ?></span></a></li>
            <li><a href="<?php echo esc_url(wp_logout_url(home_url('/mi-cuenta'))); ?>"><span class="dashicons dashicons-download"></span> <span class="account-menu-name"><?php _e('Cerrar Sesión', 'almedis'); ?></span></a></li>
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
                <table id="tableUser">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Fecha</th>
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
                            <td><?php echo get_the_date('d-m-Y'); ?></td>
                            <td><span class="pedidos-code"><?php echo get_post_meta(get_the_ID(), 'almedis_unique_id', true); ?></span></td>
                            <td><?php echo get_post_meta(get_the_ID(), 'almedis_client_medicine', true); ?></td>
                            <td><span class="pedidos-status"><?php echo get_post_meta(get_the_ID(), 'almedis_client_status', true); ?></span></td>
                            <?php $codigo_id = get_post_meta(get_the_ID(), 'almedis_unique_id', true); ?>
                            <td><a class="almedis-pedido-click" href="<?php echo get_permalink(get_the_ID()); ?>" data-pedido="<?php echo get_the_ID(); ?>"><span class="dashicons dashicons-visibility"></span> Ver Pedido</a><a class="almedis-repeat-pedido-click" data-pedido="<?php echo get_the_ID(); ?>"><span class="dashicons dashicons-image-rotate"></span> Repetir Pedido</a><a href="<?php echo home_url('/registrar-pago?pedido_id=') . $codigo_id; ?>" class="almedis-process-pedido-click"><span class="dashicons dashicons-cart"></span> Registrar Pago</a></td>
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
                        
                    </tfoot>
                </table>
            </div>
            <div class="notice-mobile">Deslice hacia la derecha o izquierda para visualizar toda la información -></div>
            <a href="" class="btn btn-pedidos"><?php _e('Ver todos los pedidos', 'almedis'); ?></a>
        </div>
        <div id="pedidos" class="almedis-user-dashboard-tab hidden">
            <div class="almedis-user-dashboard-title">
                <h2><?php _e('Pedidos', 'almedis'); ?></h2>
                <a href="" class="btn new-pedido"><?php _e('Nuevo Pedido', 'almedis'); ?></a>
            </div>
            <div class="almedis-user-dashboard-table">
                <table id="tablePedidos">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Fecha</th>
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
                            <td><?php echo get_the_date('d-m-Y'); ?></td>
                            <td><span class="pedidos-code"><?php echo get_post_meta(get_the_ID(), 'almedis_unique_id', true); ?></span></td>
                            <td><?php echo get_post_meta(get_the_ID(), 'almedis_client_medicine', true); ?></td>
                            <td><span class="pedidos-status"><?php echo get_post_meta(get_the_ID(), 'almedis_client_status', true); ?></span></td>
                            <?php $codigo_id = get_post_meta(get_the_ID(), 'almedis_unique_id', true); ?>
                            <td><a class="almedis-pedido-click" href="<?php echo get_permalink(get_the_ID()); ?>" data-pedido="<?php echo get_the_ID(); ?>"><span class="dashicons dashicons-visibility"></span> Ver Pedido</a><a class="almedis-repeat-pedido-click" data-pedido="<?php echo get_the_ID(); ?>"><span class="dashicons dashicons-image-rotate"></span> Repetir Pedido</a><a href="<?php echo home_url('/registrar-pago?pedido_id=') . $codigo_id; ?>" class="almedis-process-pedido-click"><span class="dashicons dashicons-cart"></span> Registrar Pago</a></td>
                        </tr>
                        <?php endwhile; ?>
                        <?php else : ?>
                        <tr>
                            <td colspan="6">No hay pedidos actualmente</td>
                        </tr>
                        <?php endif; ?>
                        <?php wp_reset_query(); ?>
                    </tbody>
                </table>
            </div>
            <div class="notice-mobile">Deslice hacia la derecha o izquierda para visualizar toda la información -></div>
            <div class="almedis-user-single-pedido"></div>
        </div>
        <div id="datos" class="almedis-user-dashboard-tab hidden">
            <div class="almedis-user-dashboard-title">
                <h2><?php _e('Datos Personales', 'almedis'); ?></h2>
            </div>
            <form id="updateClientData" class="almedis-user-dashboard-data">
                <input id="userID" name="user_id" value="<?php echo get_current_user_id(); ?>" type="hidden">
                <div class="form-group">
                    <label for="client_nombre"><?php _e('Nombres', 'almedis'); ?></label>
                    <input id="client_nombre" name="client_nombre" class="form-control almedis-form-control" type="text" autocomplete="name" value="<?php echo get_user_meta(get_current_user_id(), 'first_name', true); ?>" />
                    <small class="form-helper danger hidden"><?php _e('Error: El nombre debe ser válido', 'almedis'); ?></small>
                </div>
                <div class="form-group">
                    <label for="client_apellido"><?php _e('Apellidos', 'almedis'); ?></label>
                    <input id="client_apellido" name="client_apellido" class="form-control almedis-form-control" type="text" autocomplete="surname" value="<?php echo get_user_meta(get_current_user_id(), 'last_name', true); ?>" />
                    <small class="form-helper danger hidden"><?php _e('Error: El nombre debe ser válido', 'almedis'); ?></small>
                </div>
                <div class="form-group">
                    <label for="client_rut"><?php _e('RUT', 'almedis'); ?></label>
                    <input id="client_rut" name="client_rut" class="form-control almedis-form-control" type="text" autocomplete="rut" value="<?php echo get_user_meta(get_current_user_id(), 'almedis_user_rut', true); ?>" />
                    <small class="form-helper danger hidden"><?php _e('Error: El RUT debe ser válido', 'almedis'); ?></small>
                </div>
                <div class="form-group">
                    <label for="client_phone"><?php _e('Teléfono / WhatsApp', 'almedis'); ?></label>
                    <input id="client_phone" name="client_phone" class="form-control almedis-form-control" type="text" autocomplete="tel" value="<?php echo get_user_meta(get_current_user_id(), 'almedis_user_phone', true); ?>" />
                    <small class="form-helper danger hidden"><?php _e('Error: El teléfono debe ser válido', 'almedis'); ?></small>
                </div>
                <div class="form-group">
                    <label for="client_address"><?php _e('Dirección', 'almedis'); ?></label>
                    <textarea id="client_address" name="client_address" class="form-control almedis-form-control" type="text" autocomplete="address"><?php echo get_user_meta(get_current_user_id(), 'almedis_user_address', true); ?></textarea>
                    <small class="form-helper danger hidden"><?php _e('Error: La dirección debe ser válido', 'almedis'); ?></small>
                </div>
                <div class="form-group submit-group">
                    <button id="clientSubmit" class="btn btn-md btn-cotizar"><?php _e('Guardar Cambios', 'almedis'); ?></button>
                    <div id="clientResult"></div>
                </div>
            </form>
        </div>
    </div>
    <div id="modal" class="modal modal-hidden">
        <div class="modal-container">
            <div id="closeModal" class="close-modal"></div>
            <div id="modalHeader" class="modal-header">

            </div>
            <div id="modalContent" class="modal-content">

            </div>
        </div>
    </div>
</section>
<?php
        }
        $content = ob_get_clean();
        return $content;
    }
}
