<?php
/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Almedis_Forms
 * @subpackage Almedis_Forms/public
 * @author     IndexArt <indexart@gmail.com>
 */
class Almedis_Forms_Public
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
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Method enqueue_styles
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     * @param    void
     * @return void
     */
    public function enqueue_styles()
    {
        // Additional Styles
        wp_enqueue_style('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array(), $this->version, 'all');
        // Additional Styles
        wp_enqueue_style('datatables', 'https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css', array(), $this->version, 'all');
        // Main Styles
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/almedis-forms-public.css', array(), $this->version, 'all');
    }

    /**
     * Method enqueue_scripts
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     * @param    void
     * @return void
     */
    public function enqueue_scripts()
    {
        $sitekey = get_option('google_key');

        // Public Class JS
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/almedis-forms-public-class.js', array( 'jquery' ), $this->version, true);
        // Additional JS
        wp_enqueue_script('datatables', 'https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js', array( 'jquery' ), $this->version, true);
        wp_enqueue_script('sweetalert', 'https://cdn.jsdelivr.net/npm/sweetalert2@11', array( 'jquery' ), $this->version, true);
        wp_enqueue_script('almedis-recaptcha', 'https://www.google.com/recaptcha/api.js?render=' . esc_attr($sitekey), array( 'jquery' ), null, ['strategy' => 'async', 'in_footer' => false]);
        // Main Functions JS
        wp_enqueue_script($this->plugin_name . '-public', plugin_dir_url(__FILE__) . 'js/almedis-forms-public.js', array( 'jquery', 'datatables', 'sweetalert', 'almedis-recaptcha', $this->plugin_name ), $this->version, true);
        wp_localize_script(
            $this->plugin_name . '-public',
            'custom_admin_url',
            array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'micuenta_url' => home_url('/mi-cuenta'),
                'google_key' => get_option('google_key')
            )
        );
    }

    public function project_dequeue_recaptcha()
    {
        wp_dequeue_script('recaptcha-v3');
        wp_deregister_script('recaptcha-v3');
        wp_dequeue_script('et-core-api-spam-recaptcha');
        wp_deregister_script('et-core-api-spam-recaptcha');
    }

    /**
     * Method almedis_force_template
     * Register alternate templates for Instituciones Custom Post Type
     *
     * @since    1.0.0
     * @param $template
     * @return void
     */
    public function almedis_force_template($template)
    {
        // Check if archive template is called
        if (is_archive('instituciones')) {
            $template = WP_PLUGIN_DIR . '/' . plugin_basename(dirname(__FILE__)) . '/templates/archive-instituciones.php';
        }

        // Check if archive singular is called
        if (is_singular('instituciones')) {
            $template = WP_PLUGIN_DIR . '/' . plugin_basename(dirname(__FILE__)) . '/templates/single-instituciones.php';
        }

        return $template;
    }

    public function almedis_show_recaptcha()
    {
        $google_key = get_option('google_key');
        ?>
        <div id="recaptcha" class="g-recaptcha" data-size='compact' data-theme='dark' data-sitekey="<?php echo $google_key; ?>" style="display:none;"></div>
        <?php
    }
}
