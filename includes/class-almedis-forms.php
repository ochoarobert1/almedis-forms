<?php
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Almedis_Forms
 * @subpackage Almedis_Forms/includes
 * @author     IndexArt <indexart@gmail.com>
 */
class Almedis_Forms
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Almedis_Forms_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        if (defined('ALMEDIS_FORMS_VERSION')) {
            $this->version = ALMEDIS_FORMS_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'almedis-forms';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Almedis_Forms_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Almedis_Forms_Loader. Orchestrates the hooks of the plugin.
     * - Almedis_Forms_i18n. Defines internationalization functionality.
     * - Almedis_Forms_Admin. Defines all hooks for the admin area.
     * - Almedis_Forms_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-almedis-forms-loader.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-almedis-forms-historial.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-almedis-forms-notifications.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-almedis-forms-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-almedis-forms-admin.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-almedis-forms-dashboard.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-almedis-forms-pedidos-metaboxes.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-almedis-forms-instituciones-metaboxes.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-almedis-forms-dashboard.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-almedis-forms-public.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/class-shortcode-login-buton.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/class-shortcode-lost-password.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/class-shortcode-submission-form.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/class-shortcode-register-form.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/class-shortcode-account-dashboard.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/class-shortcode-payment-confirmation.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/class-shortcode-tracking-form.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/class-shortcode-experience-form.php';

        $this->loader = new Almedis_Forms_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Almedis_Forms_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale()
    {
        $plugin_i18n = new Almedis_Forms_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks()
    {
        $plugin_admin = new Almedis_Forms_Admin($this->get_plugin_name(), $this->get_version());
        $plugin_pedidos_metabox = new Almedis_Forms_Pedidos_Metaboxes($this->get_plugin_name(), $this->get_version());
        $plugin_instituciones_metabox = new Almedis_Forms_Instituciones_Metaboxes($this->get_plugin_name(), $this->get_version());
        $plugin_admin_dashboard = new Almedis_Forms_Admin_Dashboard($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');

        $this->loader->add_action('admin_menu', $plugin_admin_dashboard, 'almedis_admin_menu');
        $this->loader->add_action('admin_menu', $plugin_admin_dashboard, 'almedis_admin_menu');
        $this->loader->add_action('admin_init', $plugin_admin_dashboard, 'register_almedis_settings');

        $this->loader->add_filter('admin_body_class', $plugin_admin_dashboard, 'almedis_admin_body_class');
        $this->loader->add_filter('admin_footer_text', $plugin_admin_dashboard, 'almedis_remove_admin_footer_text', 11);
        $this->loader->add_filter('update_footer', $plugin_admin_dashboard, 'almedis_remove_admin_footer_text', 11);

        $this->loader->add_action('init', $plugin_admin, 'almedis_cpt_pedidos');
        $this->loader->add_action('init', $plugin_admin, 'almedis_cpt_instituciones');
        $this->loader->add_filter('single_template', $plugin_admin, 'custom_pedidos_template_file');

        $this->loader->add_filter('manage_pedidos_posts_columns', $plugin_admin, 'almedis_filter_pedidos_columns');
        $this->loader->add_action('manage_pedidos_posts_custom_column', $plugin_admin, 'almedis_populate_columns', 10, 2);
        $this->loader->add_filter('manage_instituciones_posts_columns', $plugin_admin, 'almedis_filter_instituciones_columns');
        $this->loader->add_action('manage_instituciones_posts_custom_column', $plugin_admin, 'almedis_instituciones_populate_columns', 10, 2);

        $this->loader->add_action('load-post.php', $plugin_admin, 'almedis_remove_post_type_edit_screen', 10);

        $this->loader->add_action('add_meta_boxes', $plugin_pedidos_metabox, 'pedidos_add_meta_box');
        $this->loader->add_action('save_post', $plugin_pedidos_metabox, 'pedidos_save_postmeta', 10, 3);

        $this->loader->add_action('add_meta_boxes', $plugin_instituciones_metabox, 'instituciones_add_meta_box');
        $this->loader->add_action('save_post', $plugin_instituciones_metabox, 'instituciones_save_postmeta');

        $this->loader->add_filter('postbox_classes_pedidos_almedis_metabox', $plugin_admin, 'add_pedido_metabox_classes');
        $this->loader->add_filter('postbox_classes_pedidos_almedis_type_metabox', $plugin_admin, 'add_cliente_metabox_classes');
        $this->loader->add_filter('postbox_classes_pedidos_almedis_status_metabox', $plugin_admin, 'add_pedido_metabox_classes');
        $this->loader->add_filter('postbox_classes_pedidos_almedis_admin_metabox', $plugin_admin, 'add_pedido_metabox_classes');
        $this->loader->add_filter('postbox_classes_instituciones_almedis_instituciones_metabox', $plugin_admin, 'add_pedido_metabox_classes');
        $this->loader->add_filter('postbox_classes_instituciones_almedis_instituciones_qr_metabox', $plugin_admin, 'add_pedido_metabox_classes');

        $this->loader->add_action('show_user_profile', $plugin_admin, 'almedis_additional_profile_fields');
        $this->loader->add_action('edit_user_profile', $plugin_admin, 'almedis_additional_profile_fields');

        $this->loader->add_action('personal_options_update', $plugin_admin, 'almedis_save_profile_fields');
        $this->loader->add_action('edit_user_profile_update', $plugin_admin, 'almedis_save_profile_fields');

        

    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks()
    {
        $plugin_public = new Almedis_Forms_Public($this->get_plugin_name(), $this->get_version());
        $plugin_ajax_public = new Almedis_Forms_Ajax_Public($this->get_plugin_name(), $this->get_version());
        $plugin_submission_shortcode = new Almedis_Forms_Public_Submission_Form($this->get_plugin_name(), $this->get_version());
        $plugin_register_shortcode = new Almedis_Forms_Public_Register_Form($this->get_plugin_name(), $this->get_version());
        $plugin_login_btn_shortcode = new Almedis_Forms_Public_Login_Button($this->get_plugin_name(), $this->get_version());
        $plugin_lost_pass_shortcode = new Almedis_Forms_Public_Lost_Password($this->get_plugin_name(), $this->get_version());
        $plugin_myaccount_shortcode = new Almedis_Forms_Public_Account_Dashboard($this->get_plugin_name(), $this->get_version());
        $plugin_payment_shortcode = new Almedis_Forms_Public_Payment_Confirmation($this->get_plugin_name(), $this->get_version());
        $plugin_tracking_shortcode = new Almedis_Forms_Public_Tracking_Form($this->get_plugin_name(), $this->get_version());
        $plugin_testimonial_shortcode = new Almedis_Forms_Public_Testimonial_Form($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');

        $this->loader->add_filter('template_include', $plugin_public, 'almedis_force_template');

        $this->loader->add_action('init', $plugin_submission_shortcode, 'almedis_add_custom_shortcode');

        // LOGIN BUTTON
        $this->loader->add_action('init', $plugin_login_btn_shortcode, 'almedis_add_custom_shortcode');
        $this->loader->add_action('init', $plugin_lost_pass_shortcode, 'almedis_add_custom_shortcode');
        $this->loader->add_action('wp_ajax_almedis_lost_pass_user', $plugin_ajax_public, 'almedis_lost_pass_user_callback');
        $this->loader->add_action('wp_ajax_nopriv_almedis_lost_pass_user', $plugin_ajax_public, 'almedis_lost_pass_user_callback');
        $this->loader->add_action('wp_ajax_almedis_new_pass_user', $plugin_ajax_public, 'almedis_new_pass_user_callback');
        $this->loader->add_action('wp_ajax_nopriv_almedis_new_pass_user', $plugin_ajax_public, 'almedis_new_pass_user_callback');
        
        // VALIDATE RECATPCHA 
        $this->loader->add_action('wp_ajax_nopriv_validate_recaptcha_token', $plugin_ajax_public, 'validate_recaptcha_token_callback');
        $this->loader->add_action('wp_ajax_validate_recaptcha_token', $plugin_ajax_public, 'validate_recaptcha_token_callback');

        // NATURAL FORMS
        $this->loader->add_action('wp_ajax_almedis_register_natural', $plugin_ajax_public, 'almedis_register_natural_callback');
        $this->loader->add_action('wp_ajax_nopriv_almedis_register_natural', $plugin_ajax_public, 'almedis_register_natural_callback');

        // CONVENIOS FORMS
        $this->loader->add_action('wp_ajax_almedis_register_convenio', $plugin_ajax_public, 'almedis_register_convenio_callback');
        $this->loader->add_action('wp_ajax_nopriv_almedis_register_convenio', $plugin_ajax_public, 'almedis_register_convenio_callback');

        // INSTITUCION FORMS
        $this->loader->add_action('wp_ajax_almedis_register_institucion', $plugin_ajax_public, 'almedis_register_institucion_callback');
        $this->loader->add_action('wp_ajax_nopriv_almedis_register_institucion', $plugin_ajax_public, 'almedis_register_institucion_callback');

        // LOGIN FORMS
        $this->loader->add_action('wp_ajax_nopriv_almedis_login_user', $plugin_ajax_public, 'almedis_login_user_callback');
        $this->loader->add_action('wp_ajax_almedis_login_user', $plugin_ajax_public, 'almedis_login_user_callback');

        // REGISTER USER
        $this->loader->add_action('init', $plugin_register_shortcode, 'almedis_add_custom_shortcode');
        $this->loader->add_action('wp_ajax_nopriv_almedis_register_user', $plugin_ajax_public, 'almedis_register_user_callback');
        $this->loader->add_action('wp_ajax_almedis_register_user', $plugin_ajax_public, 'almedis_register_user_callback');
        $this->loader->add_action('wp_ajax_nopriv_almedis_load_docs', $plugin_ajax_public, 'almedis_load_docs_callback');
        $this->loader->add_action('wp_ajax_almedis_load_docs', $plugin_ajax_public, 'almedis_load_docs_callback');

        // PAYMENT CONFIRMATION
        $this->loader->add_action('init', $plugin_payment_shortcode, 'almedis_add_custom_shortcode');
        $this->loader->add_action('wp_ajax_nopriv_almedis_payment_confirmation', $plugin_ajax_public, 'almedis_payment_confirmation_callback');
        $this->loader->add_action('wp_ajax_almedis_payment_confirmation', $plugin_ajax_public, 'almedis_payment_confirmation_callback');

        // TRACKING
        $this->loader->add_action('init', $plugin_tracking_shortcode, 'almedis_add_custom_shortcode');
        $this->loader->add_action('wp_ajax_nopriv_almedis_tracking_pedido', $plugin_ajax_public, 'almedis_tracking_pedido_callback');
        $this->loader->add_action('wp_ajax_almedis_tracking_pedido', $plugin_ajax_public, 'almedis_tracking_pedido_callback');

        // TESTIMONIALS
        $this->loader->add_action('init', $plugin_testimonial_shortcode, 'almedis_add_custom_shortcode');
        $this->loader->add_action('wp_ajax_nopriv_almedis_testimonial_submit', $plugin_ajax_public, 'almedis_testimonial_submit_callback');
        $this->loader->add_action('wp_ajax_almedis_testimonial_submit', $plugin_ajax_public, 'almedis_testimonial_submit_callback');

        // MY ACCOUNT
        $this->loader->add_action('init', $plugin_myaccount_shortcode, 'almedis_account_custom_shortcode');
        $this->loader->add_action('wp_ajax_nopriv_almedis_edit_pedido', $plugin_ajax_public, 'almedis_edit_pedido_callback');
        $this->loader->add_action('wp_ajax_almedis_edit_pedido', $plugin_ajax_public, 'almedis_edit_pedido_callback');
        
        $this->loader->add_action('wp_ajax_nopriv_almedis_update_user', $plugin_ajax_public, 'almedis_update_user_callback');
        $this->loader->add_action('wp_ajax_almedis_update_user', $plugin_ajax_public, 'almedis_update_user_callback');

        $this->loader->add_action('wp_ajax_nopriv_almedis_repeat_pedido', $plugin_ajax_public, 'almedis_repeat_pedido_callback');
        $this->loader->add_action('wp_ajax_almedis_repeat_pedido', $plugin_ajax_public, 'almedis_repeat_pedido_callback');

        $this->loader->add_action('wp_ajax_nopriv_almedis_update_institucion', $plugin_ajax_public, 'almedis_update_institucion_callback');
        $this->loader->add_action('wp_ajax_almedis_update_institucion', $plugin_ajax_public, 'almedis_update_institucion_callback');

        $this->loader->add_action('wp_ajax_nopriv_almedis_download_modal', $plugin_ajax_public, 'almedis_download_modal_callback');
        $this->loader->add_action('wp_ajax_almedis_download_modal', $plugin_ajax_public, 'almedis_download_modal_callback');

        $this->loader->add_action('wp_ajax_nopriv_almedis_get_archhive', $plugin_ajax_public, 'almedis_get_archhive_callback');
        $this->loader->add_action('wp_ajax_almedis_get_archhive', $plugin_ajax_public, 'almedis_get_archhive_callback');

        $this->loader->add_action('wp_ajax_nopriv_almedis_reload_docs', $plugin_ajax_public, 'almedis_reload_docs_callback');
        $this->loader->add_action('wp_ajax_almedis_reload_docs', $plugin_ajax_public, 'almedis_reload_docs_callback');

        
    }
}
