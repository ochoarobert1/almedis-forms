<?php
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
class Almedis_Forms_Admin_Dashboard
{
    private $plugin_name;
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
     * Method almedis_admin_body_class
     *
     * @param $classes $classes [explicite description]
     *
     * @return void
     */
    public function almedis_admin_body_class($classes)
    {
        $screen = get_current_screen();
        if (strpos($screen->id, 'almedis') !== false) {
            $classes .= ' almedis-forms';
        }
        return $classes;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */

    public function almedis_remove_admin_footer_text()
    {
        $screen = get_current_screen();
        if (strpos($screen->id, 'almedis') !== false) {
            return null;
        }
    }

    /**
     * Method user_has_role
     *
     * @param $user_id $user_id [int]
     * @param $role_name $role_name [object]
     *
     * @return void
     */
    public function user_has_role($user_id, $role_name)
    {
        $user_meta = get_userdata($user_id);
        $user_roles = $user_meta->roles;
        return in_array($role_name, $user_roles);
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function almedis_admin_menu()
    {
        add_menu_page(
            __('Escritorio', 'almedis-forms'),
            'Almedis',
            'manage_options',
            'almedis',
            array($this, 'almedis_dashboard'),
            plugin_dir_url(__DIR__) . 'admin/img/icon.png',
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
        require_once('partials/admin-header.php');
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
        require_once('partials/admin-footer.php');
        $content_footer = ob_get_clean();
        return $content_footer;
    }

    /**
     * Method get_almedis_role_name
     *
     * @param $user_ID $user_ID [int]
     *
     * @return void
     */
    public function get_almedis_role_name($user_ID)
    {
        global $wp_roles;

        $user_data = get_userdata($user_ID);
        $user_role_slug = $user_data->roles[0];
        return translate_user_role($wp_roles->roles[$user_role_slug]['name']);
    }

    /**
     * Method almedis_clientes
     *
     * @return void
     */
    public function almedis_clientes()
    {
        echo $this->almedis_get_header();
        $users = get_users(); ?>
        <div class="almedis-forms-table-container">
            <table id="usersTable" class="table-custom">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?php _e('Nombre y Apellido', 'almedis'); ?></th>
                        <th><?php _e('RUT', 'almedis'); ?></th>
                        <th><?php _e('Correo Electrónico', 'almedis'); ?></th>
                        <th><?php _e('Teléfono/WhatsApp', 'almedis'); ?></th>
                        <th><?php _e('Tipo de Perfil', 'almedis'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) { ?>
                        <?php $admin_user = $this->user_has_role($user->ID, 'almedis_admin'); ?>
                        <?php $convenios_user = $this->user_has_role($user->ID, 'convenios_admin'); ?>
                        <?php $normal_user = $this->user_has_role($user->ID, 'almedis_client'); ?>
                        <?php $user = get_userdata($user->ID); ?>
                        <?php if (($admin_user == true) || ($convenios_user == true) || ($normal_user == true)) { ?>
                            <tr>
                                <td><?php echo $user->ID; ?></td>
                                <td><?php echo get_user_meta($user->ID, 'first_name', true) . ' ' . get_user_meta($user->ID, 'last_name', true); ?></td>
                                <td><?php echo get_user_meta($user->ID, 'almedis_user_rut', true); ?></td>
                                <td><?php echo $user->user_email; ?></td>
                                <td><?php echo get_user_meta($user->ID, 'almedis_user_phone', true); ?></td>
                                <td><?php echo $this->get_almedis_role_name($user->ID); ?></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php
        echo $this->almedis_get_footer();
    }

    /**
     * Method almedis_historial
     *
     * @return void
     */
    public function almedis_historial()
    {
        echo $this->almedis_get_header(); ?>

        <div class="almedis-content">
            <div class="almedis-historial-content-wrapper">
                <?php $historicalClass = new Almedis_Forms_Historial($this->plugin_name, $this->version); ?>
                <?php $historial = $historicalClass->select_almedis_historial(); ?>
                <?php if (!empty($historial)) : ?>
                    <?php foreach ($historial as $item) { ?>
                        <?php $type = $historicalClass->get_almedis_historial_type($item->desc); ?>
                        <div class="almedis-historial-item historial-type-<?php echo strtolower(sanitize_title($type[0])); ?>">
                            <?php $fecha = DateTime::createFromFormat('Y-m-d H:i:s', $item->date); ?>
                            <span><strong><?php _e('Dia:', 'almedis'); ?></strong> <?php echo $fecha->format('d-m-Y'); ?></span> <span><strong><?php _e('Hora:', 'almedis'); ?></strong> <?php echo $fecha->format('H:i:s'); ?></span>

                            <p><strong><?php echo $type[0]; ?>:</strong> <?php echo $type[1]; ?></p>
                        </div>
                    <?php } ?>
                <?php endif; ?>
                <div class="almedis-historial-item last-item">
                    <p><span class="smiling-face">&#128512;</span> <?php _e('No hay más items de historial', 'almedis'); ?></p>
                </div>
            </div>
        </div>

    <?php
        echo $this->almedis_get_footer();
    }

    /**
     * Method register_almedis_settings
     *
     * @return void
     */
    public function register_almedis_settings()
    {
        register_setting('almedis-settings-group', 'almedis_admin_email');
        register_setting('almedis-settings-group', 'google_key');
        register_setting('almedis-settings-group', 'google_secret');
    }

    /**
     * Method almedis_opciones
     *
     * @return void
     */
    public function almedis_opciones()
    {
        echo $this->almedis_get_header();
        ?>
        <div class="wrap almedis-wrap-options">
            <form method="post" action="options.php">
                <?php settings_fields('almedis-settings-group'); ?>
                <?php do_settings_sections('almedis-settings-group'); ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><?php _e('Correo donde deben recibirse las notificaciones', 'almedis'); ?></th>
                        <td><input type="text" name="almedis_admin_email" value="<?php echo esc_attr(get_option('almedis_admin_email')); ?>" size="80" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e('Google Key', 'almedis'); ?></th>
                        <td><input type="password" name="google_key" value="<?php echo esc_attr(get_option('google_key')); ?>" size="80" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php _e('Google Secret', 'almedis'); ?></th>
                        <td><input type="password" name="google_secret" value="<?php echo esc_attr(get_option('google_secret')); ?>" size="80" /></td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
    <?php
        echo $this->almedis_get_footer();
    }

    /**
     * Method almedis_dashboard
     *
     * @return void
     */
    public function almedis_dashboard()
    {
        echo $this->almedis_get_header(); ?>
        <div class="almedis-content">
            <div class="almedis-dashboard-info main-dashboard">
                <div id="pedidos" class="almedis-dashboard-item">
                    <div class="almedis-dashicons-icon">
                        <span class="dashicons dashicons-money-alt"></span>
                    </div>
                    <div class="almedis-dashboard-wrapper">
                        <h4><?php _e('Pedidos', 'almedis'); ?></h4>
                        <?php $pedidos = get_posts(array('numberposts' => -1, 'post_type' => 'pedidos', 'orderby' => 'date', 'order' => 'DESC')); ?>
                        <?php if ($pedidos) : ?>
                            <p class="big-number"><?php echo count($pedidos); ?> <?php _e('Pedidos', 'almedis'); ?></p>
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
                        <h4><?php _e('Clientes', 'almedis'); ?></h4>
                        <?php $clients = 0; ?>
                        <?php $users = get_users(); ?>
                        <?php foreach ($users as $user) { ?>
                            <?php $admin_user = $this->user_has_role($user->ID, 'almedis_admin'); ?>
                            <?php $convenios_user = $this->user_has_role($user->ID, 'convenios_admin'); ?>
                            <?php $normal_user = $this->user_has_role($user->ID, 'almedis_client'); ?>
                            <?php $user = get_userdata($user->ID); ?>
                            <?php if (($admin_user == true) || ($convenios_user == true) || ($normal_user == true)) { ?>
                                <?php $clients++; ?>
                            <?php } ?>
                        <?php } ?>
                        <p class="big-number"><?php echo $clients; ?> <?php _e('Clientes', 'almedis'); ?></p>
                    </div>
                </div>
                <?php $pedidos = get_posts(array('numberposts' => -1, 'post_type' => 'pedidos', 'orderby' => 'date', 'order' => 'DESC')); ?>
                <?php $acumPedidos = 0; ?>
                <?php foreach ($pedidos as $pedido) { ?>
                    <?php $price = (int) get_post_meta($pedido->ID, 'almedis_pedido_payment_qty', true); ?>
                    <?php $acumPedidos = $acumPedidos + $price; ?>
                <?php } ?>
                <?php if ($acumPedidos == '') { ?>
                <div id="orders" class="almedis-dashboard-item">
                    <div class="almedis-dashicons-icon">
                        <span class="dashicons dashicons-admin-users"></span>
                    </div>
                    <div class="almedis-dashboard-wrapper">
                        <h4><?php _e('Ordenes de Compra', 'almedis'); ?></h4>

                        <p class="big-number">$ <?php number_format($acumPedidos, 0, ',', '.'); ?></p>
                    </div>
                </div>
                <?php } ?>
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
                                            <p><?php _e('Cliente:', 'almedis'); ?> <?php echo get_post_meta($pedido->ID, 'almedis_client_name', true); ?></p>
                                            <span><?php _e('Medicamentos:', 'almedis'); ?> <?php echo get_post_meta($pedido->ID, 'almedis_client_medicine', true); ?></span>
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
                        <?php $historial_class = new Almedis_Forms_Historial($this->plugin_name, $this->version); ?>
                        <?php $historial = $historial_class->select_almedis_historial(); ?>
                        <?php if (!empty($historial)) : ?>
                            <?php foreach ($historial as $item) { ?>
                                <?php $type = $historial_class->get_almedis_historial_type($item->desc); ?>
                                <div class="almedis-list-item">
                                    <div class="almedis-list-item-wrapper">
                                        <div class="almedis-list-notification notification-type-<?php echo strtolower(sanitize_title($type[0])); ?>">
                                            <div class="date-container">
                                                <?php $fecha = DateTime::createFromFormat('Y-m-d H:i:s', $item->date); ?>
                                                <span><strong><?php _e('Dia:', 'almedis'); ?></strong> <?php echo $fecha->format('d-m-Y'); ?></span> <span><strong><?php _e('Hora:', 'almedis'); ?></strong> <?php echo $fecha->format('H:i:s'); ?></span>
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
        echo $this->almedis_get_footer();
    }
}
