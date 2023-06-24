<?php
/**
 * The Ajax functions for public functions
 *
 * @package    Almedis_Forms
 * @subpackage Almedis_Forms/public
 * @author     IndexArt <indexart@gmail.com>
 */
class Almedis_Forms_Ajax_Public
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

    /* --------------------------------------------------------------
        CUSTOM FUNCTIONS AND HANDLERS
    -------------------------------------------------------------- */
    /**
     * Method user_id_exists
     * Callback for checking if email exist on database
     *
     * @since    1.0.0
     * @param $email [email]
     * @return boolean
     */
    public function user_id_exists($email)
    {
        global $wpdb;
        // get user count
        $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->users WHERE user_email = %s", $email));

        // check response
        if ($count >= 1) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Method function_login_user
     * Callback for registering an user
     *
     * @since    1.0.0
     * @param $data $data [user,pass]
     * @return boolean
     */
    public function function_login_user($data)
    {
        // create array from credentials
        $creds = array(
            'user_login'    => $data['user_login'],
            'user_password' => $data['user_password'],
            'remember'      => true
        );

        // try user login
        $user = wp_signon($creds, false);
        // check wp response from wp_signon
        if (!is_wp_error($user)) {
            return array(
                'response' => true,
                'user_id'  => $user->ID
            );
        } else {
            return array(
                'response' => false,
                'user_id'  => ''
            );
        }
    }
   
    /**
     * Method function_get_client_user_id
     * Callback for get a user id for future use
     *
     * @since    1.0.0
     * @param $data $data [explicite description]
     * @param $type $type [explicite description]
     * @return boolean
     */
    public function function_get_client_user_id($data, $type)
    {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        }

        // initialize user vars
        $user_id = '';
        $registered = false;

        // check if this user is natural or anything else
        if ($type == 'natural') {
            if ($this->user_id_exists($data['natural_email'])) {
                $user = get_user_by('email', $data['natural_email']);
                $user_id = $user->ID;
                $registered = true;
            } else {
                $registered = false;
            }
        } else {
            if ($this->user_id_exists($data['convenio_email'])) {
                $user = get_user_by('email', $data['convenio_email']);
                $user_id = $user->ID;
                $registered = true;
            } else {
                $registered = false;
            }
        }

        // if registered add a new historial data
        if ($registered == true) {
            add_user_meta($user_id, 'almedis_client_type', $type);
            $user_info = get_userdata($user_id);
            $text = 'Registro: El usuario del correo ' . $user_info->user_email . ' ha realizado un pedido adicional';

            $historial = new Almedis_Forms_Historial($this->plugin_name, $this->version);
            $historial->create_almedis_historial($text);
        }

        // return user_id for future use
        return $user_id;
    }
    
    /**
     * Method function_set_documents
     * Callback for register the documents from forms.
     *
     * @since    1.0.0
     * @param $data $data [explicite description]
     * @param $type $type [explicite description]
     * @return boolean
     */
    public function function_set_documents($data, $type)
    {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        }

        // initialize vars
        $docs = array(
            'recipe' => '',
            'cartapoder' => '',
            'carnet' => ''
        );

        // check user type
        if ($type == 'natural') {
            // Save sent files from forms
            if (isset($data['natural_recipe'])) {
                $uploadedfile = $data['natural_recipe'];
                $upload_overrides = array( 'test_form' => false );
                $recipe = wp_handle_upload($uploadedfile, $upload_overrides);
                $docs['recipe'] = $recipe['url'];
            }
            if (isset($data['natural_cartapoder'])) {
                $uploadedfile = $data['natural_cartapoder'];
                $upload_overrides = array( 'test_form' => false );
                $cartapoder = wp_handle_upload($uploadedfile, $upload_overrides);
                $docs['cartapoder'] = $cartapoder['url'];
            }
            if (isset($data['natural_carnet'])) {
                $uploadedfile = $data['natural_carnet'];
                $upload_overrides = array( 'test_form' => false );
                $carnet = wp_handle_upload($uploadedfile, $upload_overrides);
                $docs['carnet'] = $carnet['url'];
            }
        } else {
            // Save sent files from forms
            if (isset($data['convenio_recipe'])) {
                $uploadedfile = $data['convenio_recipe'];
                $upload_overrides = array( 'test_form' => false );
                $recipe = wp_handle_upload($uploadedfile, $upload_overrides);
                $docs['recipe'] = $recipe['url'];
            }
            if (isset($data['convenio_cartapoder'])) {
                $uploadedfile = $data['convenio_cartapoder'];
                $upload_overrides = array( 'test_form' => false );
                $cartapoder = wp_handle_upload($uploadedfile, $upload_overrides);
                $docs['cartapoder'] = $cartapoder['url'];
            }
            if (isset($data['convenio_carnet'])) {
                $uploadedfile = $data['convenio_carnet'];
                $upload_overrides = array( 'test_form' => false );
                $carnet = wp_handle_upload($uploadedfile, $upload_overrides);
                $docs['carnet'] = $carnet['url'];
            }
        }
        return $docs;
    }
       
    /**
     * Method function_set_pedido
     * Callback for setting a Pedido custom post type
     *
     * @param $data $data [explicite description]
     * @param $files $files [explicite description]
     * @param $type $type [explicite description]
     * @param $user_id $user_id [explicite description]
     *
     * @return void
     */
    public function function_set_pedido($data, $files, $type, $user_id)
    {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        }

        // Get quantity of created pedidos custom post type
        $query_pedidos = new WP_Query(array('post_type' => 'pedidos', 'posts_per_page' => -1));
        $qty_pedidos = $query_pedidos->found_posts;
        // Add one for a new pedido custom post type
        $qty_pedidos = $qty_pedidos + 1;
        wp_reset_query();

        // if user is natural - inst_id and conv_id are null
        if ($type == 'natural') {
            $instituto_id = null;
            $convenio_id = null;
            $tipo = $data['natural_type'];
            $nombre = $data['natural_nombre'];
            $rut = $data['natural_rut'];
            $email = $data['natural_email'];
            $phone = $data['natural_phone'];
            $medicine = $data['natural_medicine'];
            $notificacion = $data['natural_notification'];
        }

        // if user is convenio - inst_id are null
        if ($type == 'convenio') {
            $instituto_id = null;
            $convenio_id = $data['convenio_usuario'];
            $tipo = $data['convenio_type'];
            $nombre = $data['convenio_nombre'];
            $rut = $data['convenio_rut'];
            $email = $data['convenio_email'];
            $phone = $data['convenio_phone'];
            $medicine = $data['convenio_medicine'];
            $notificacion = $data['convenio_notification'];
        }

        // if user is institucion - conv_id are null
        if ($type == 'institucion') {
            $instituto_id = $data['convenio_institucion'];
            $convenio_id = null;
            $tipo = $data['convenio_type'];
            $nombre = $data['convenio_nombre'];
            $rut = $data['convenio_rut'];
            $email = $data['convenio_email'];
            $phone = $data['convenio_phone'];
            $medicine = $data['convenio_medicine'];
            $notificacion = $data['convenio_notification'];
        }

        // create pedido post from all array data
        $pedidos_post = array(
            'post_title'    => wp_strip_all_tags('Pedido #' . $qty_pedidos),
            'post_content'  => ' ',
            'post_type'  => 'pedidos',
            'post_status'   => 'publish',
            'post_author'   => 1,
            'meta_input'    => array(
                'almedis_unique_id'             => uniqid(),
                'almedis_client_tipo'           => $tipo,
                'almedis_client_type'           => $type,
                'almedis_client_institucion'    => $instituto_id,
                'almedis_client_convenio'       => $convenio_id,
                'almedis_client_name'           => $nombre,
                'almedis_client_rut'            => $rut,
                'almedis_client_email'          => $email,
                'almedis_client_phone'          => $phone,
                'almedis_client_medicine'       => $medicine,
                'almedis_client_notification'   => $notificacion,
                'almedis_client_user'           => $user_id,
                'almedis_pedido_status'         => 'Cotizacion Recibida',
                'almedis_pedido_confirmation'   => '',
                'almedis_client_recipe'         => $files['recipe'],
                'almedis_client_cartapoder'     => $files['cartapoder'],
                'almedis_client_carnet'         => $files['carnet']
            )
        );
           
        // Insert the post into the database
        $pedidos_id = wp_insert_post($pedidos_post);

        // register new historial
        $text = 'Pedido: El ' . wp_strip_all_tags('Pedido #' . $qty_pedidos) . ' ha sido registrado correctamente';
        $historial = new Almedis_Forms_Historial($this->plugin_name, $this->version);
        $historial->create_almedis_historial($text);

        // return newly created pedido id for foture use
        return $pedidos_id;
    }

    /* --------------------------------------------------------------
        USER REGISTRATION AND UPDATE
    -------------------------------------------------------------- */
    /**
     * Method almedis_register_user_callback
     * Callback for registering an user
     *
     * @since    1.0.0
     * @param    void
     * @return void
     */
    public function almedis_register_user_callback()
    {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        }

        global $wpdb;

        $response = array();
        $data =  isset($_POST) ? $_POST : array();

        // check if user exists using email address
        if ($this->user_id_exists($data['client_email'])) {
            $user = get_user_by('email', $data['client_email']);
            $user_id = $user->ID;
            $registered = true;
        } else {
            $registered = false;
        }

        // if user is not registered
        if ($registered == false) {
            // create name and username from email / name
            $username = explode('@', $data['client_email']);
            $nombres = explode(' ', $data['client_nombre']);

            // construct user array with params
            $info_user = array(
                'user_login'    => $username[0],
                'first_name'    => $nombres[0],
                'last_name'     => $nombres[1],
                'user_email'    => $data['client_email'],
                'user_pass'     => $data['client_password'],
                'role'          => 'almedis_client',
            );

            // register new user and get user_id
            $user_id = wp_insert_user($info_user);

            // if there aren't any errors
            if (! is_wp_error($user_id)) {
                // register user meta.
                update_user_meta($user_id, 'almedis_user_rut', $data['client_rut']);
                update_user_meta($user_id, 'almedis_user_phone', $data['client_phone']);
                update_user_meta($user_id, 'almedis_user_address', $data['client_address']);
                update_user_meta($user_id, 'show_admin_bar_front', false);

                // search and update every pedido with user data
                $results = $wpdb->get_results("select post_id from $wpdb->postmeta where meta_value = '{$data['client_email']}'", ARRAY_A);
                if (!empty($results)) {
                    foreach ($results as $item) {
                        update_post_meta($item['post_id'], 'almedis_client_user', $user_id);
                        update_post_meta($item['post_id'], 'almedis_client_rut', $data['client_rut']);
                        update_post_meta($item['post_id'], 'almedis_client_phone', $data['client_phone']);
                    }
                }
            }

            // construct user creds for login
            $creds = array(
                'user_login'    => $username[0],
                'user_password' => $data['client_password']
            );

            // login user
            $user = $this->function_login_user($creds);

            $response =array(
                'message' => __('El registro ha sido exitoso, en breve serás redigirido a tu cuenta', 'almedis'),
                'action' => 'redirect'
            );
        } else {
            $response =array(
                'message' => __('Este usuario ya esta registrado, puedes iniciar sesión en "mi cuenta"', 'almedis'),
                'action' => 'nothing'
            );
        }

        wp_send_json_success($response, 200);
        wp_die();
    }

    /**
     * Method almedis_login_user_callback
     * Callback for login user
     *
     * @since    1.0.0
     * @param    void
     * @return void
     */
    public function almedis_login_user_callback()
    {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        }

        // initialize vars
        $response = array();
        $posted_data =  isset($_POST) ? $_POST : array();

        // create array credentials
        $creds = array(
            'user_login'    => $posted_data['username'],
            'user_password' => $posted_data['password'],
            'remember'      => true
        );

        // login user and get status
        $user = $this->function_login_user($creds);
        // check login status
        if ($user['response'] == false) {
            $response =array(
                'message' => __('Hay un problema con sus credenciales, por favor revise sus datos y reintente', 'almedis'),
                'class' => 'error'
            );
        } else {
            $instituto = get_user_meta($user['user_id'], 'almedis_client_instituto', true);
            if ($instituto == '') {
                $response =array(
                    'message' => __('Login exitoso, en breve serás redirigido a tu cuenta', 'almedis'),
                    'class' => 'success',
                    'redirect' => home_url('/mi-cuenta')
                );
            } else {
                $response =array(
                    'message' => __('Login exitoso, en breve serás redirigido a tu cuenta', 'almedis'),
                    'class' => 'success',
                    'redirect' => get_permalink($instituto)
                );
            }
        }

        wp_send_json_success($response, 200);
        wp_die();
    }

    
    
    /**
    * Method almedis_update_user_callback
    * Callback for update user info
    *
    * @since    1.0.0
    * @param    void
    * @return void
    */
    public function almedis_update_user_callback()
    {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        }

        // initialize vars
        $response = array();
        $data =  isset($_POST) ? $_POST : array();

        // get user id
        $user_id = $data['user_id'];

        // update user data
        update_user_meta($user_id, 'first_name', $data['client_nombre']);
        update_user_meta($user_id, 'last_name', $data['client_apellido']);
        update_user_meta($user_id, 'almedis_user_rut', $data['client_rut']);
        update_user_meta($user_id, 'almedis_user_phone', $data['client_phone']);
        update_user_meta($user_id, 'almedis_user_address', $data['client_address']);

        // update all pedidos custom post type with user id with user data
        $arr_pedidos = new WP_Query(array('post_type' => 'pedidos', 'posts_per_page' => -1, 'order' => 'DESC', 'orderby' => 'date', 'meta_query' => array(array('key' => 'almedis_client_user', 'value' => $user_id, 'compare' => '='))));
        if ($arr_pedidos->have_posts()) :
            while ($arr_pedidos->have_posts()) : $arr_pedidos->the_post();
        update_post_meta(get_the_ID(), 'almedis_client_name', $data['client_nombre'] . ' ' . $data['client_apellido']);
        update_post_meta(get_the_ID(), 'almedis_client_phone', $data['client_phone']);
        update_post_meta(get_the_ID(), 'almedis_client_rut', $data['client_rut']);
        endwhile;
        endif;
        wp_reset_query();

        // return response
        $response =array(
            'message' => __('El registro ha sido exitoso', 'almedis'),
            'class' => 'success'
        );
        
        wp_send_json_success($response, 200);
        wp_die();
    }

    /* --------------------------------------------------------------
         FORM REGISTRATION
     -------------------------------------------------------------- */
    /**
    * Method almedis_register_natural_callback
    * Callback for register a natural user's pedido custom post type
    *
    * @since    1.0.0
    * @param    void
    * @return void
    */
    public function almedis_register_natural_callback()
    {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        }

        if (! function_exists('wp_handle_upload')) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
        }

        // Process sent data from AJAX
        $posted_data =  isset($_POST) ? $_POST : array();
        $file_data = isset($_FILES) ? $_FILES : array();
        $files = array();
        
        $data = array_merge($posted_data, $file_data);

        // search if user exists and get his id
        $user_id = $this->function_get_client_user_id($data, 'natural');

        // register sent documents
        $files = $this->function_set_documents($data, 'natural');

        // register a client natural - pedido custom post type
        $pedido_id = $this->function_set_pedido($data, $files, 'natural', $user_id);

        // add pedido_id to array data
        $data['pedido_id'] = $pedido_id;

        // Send emails notifications
        $notification = new Almedis_Forms_Notificactions($this->plugin_name, $this->version);
        $notification->email_form_submit($data, 'natural');
        $notification_admin = new Almedis_Forms_Notificactions($this->plugin_name, $this->version);
        $notification_admin->almedis_admin_medicine_notification($data, 'natural');

        // send response
        wp_send_json_success(__('Su pedido fue procesado, en breve recibirá un correo con esta transacción', 'almedis'), 200);
        wp_die();
    }

    /**
    * Method almedis_register_convenio_callback
    * Callback for register a convenio user's pedido custom post type
    *
    * @since    1.0.0
    * @param    void
    * @return void
    */
    public function almedis_register_convenio_callback()
    {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        }

        if (! function_exists('wp_handle_upload')) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
        }

        // Process sent data from AJAX
        $posted_data =  isset($_POST) ? $_POST : array();
        $file_data = isset($_FILES) ? $_FILES : array();
        $files = array();
        
        $data = array_merge($posted_data, $file_data);

        // search if user exists and get his id
        $user_id = $this->function_get_client_user_id($data, 'convenio');

        // register sent documents
        $files = $this->function_set_documents($data, 'convenio');

        // register a client convenio - pedido custom post type
        $pedido_id = $this->function_set_pedido($data, $files, 'convenio', $user_id);

        // add pedido_id to array data
        $data['pedido_id'] = $pedido_id;

        // Send emails notifications
        $notification = new Almedis_Forms_Notificactions($this->plugin_name, $this->version);
        $notification->email_form_submit($data, 'convenio');
        $notification_admin = new Almedis_Forms_Notificactions($this->plugin_name, $this->version);
        $notification_admin->almedis_admin_medicine_notification($data, 'convenio');

        // send response
        wp_send_json_success(__('Su pedido fue procesado, en breve recibirá un correo con esta transacción', 'almedis'), 200);
        wp_die();
    }

    /**
    * Method almedis_register_institucion_callback
    * Callback for register a institucion user's pedido custom post type
    *
    * @since    1.0.0
    * @param    void
    * @return void
    */
    public function almedis_register_institucion_callback()
    {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        }

        if (! function_exists('wp_handle_upload')) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
        }

        // Process sent data from AJAX
        $posted_data =  isset($_POST) ? $_POST : array();
        $file_data = isset($_FILES) ? $_FILES : array();
        $files = array();
        
        $data = array_merge($posted_data, $file_data);

        // search if user exists and get his id
        $user_id = $this->function_get_client_user_id($data, 'institucion');

        // register sent documents
        $files = $this->function_set_documents($data, 'institucion');

        // register a client institucion - pedido custom post type
        $pedido_id = $this->function_set_pedido($data, $files, 'institucion', $user_id);

        // add pedido_id to array data
        $data['pedido_id'] = $pedido_id;

        // Send emails notifications
        $notification = new Almedis_Forms_Notificactions($this->plugin_name, $this->version);
        $notification->email_form_submit($data, 'institucion');
        $notification_admin = new Almedis_Forms_Notificactions($this->plugin_name, $this->version);
        $notification_admin->almedis_admin_medicine_notification($data, 'institucion');

        // send response
        wp_send_json_success(__('Su pedido fue procesado, en breve recibirá un correo con esta transacción', 'almedis'), 200);
        wp_die();
    }

    /* --------------------------------------------------------------
        PEDIDOS OPERATIONS AND FUNCTIONS
    -------------------------------------------------------------- */
    /**
    * Method almedis_payment_confirmation_callback
    * Callback for register a payment for any pedido custom post type
    *
    * @since    1.0.0
    * @param    void
    * @return void
    */
    public function almedis_payment_confirmation_callback()
    {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        }

        if (! function_exists('wp_handle_upload')) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
        }

        /* PROCESS SENT DATA FROM AJAX */
        global $wpdb;
        $posted_data =  isset($_POST) ? $_POST : array();
        $file_data = isset($_FILES) ? $_FILES : array();
        $response = array();
        
        $data = array_merge($posted_data, $file_data);
        
        $results = $wpdb->get_results("select post_id from $wpdb->postmeta where meta_value = '{$data['payment_pedido']}'", ARRAY_A);
        if (!empty($results)) {
            foreach ($results as $item) {
                $data['pedido_id'] = $item['post_id'];
                update_post_meta($item['post_id'], 'almedis_pedido_confirmation', true);

                if ($data['payment_method'] == 'copago') {
                    update_post_meta($item['post_id'], 'almedis_pedido_bono_amount', $data['copago_total']);
                    update_post_meta($item['post_id'], 'almedis_pedido_bono_date', date('Y-m-d'));

                    if (!empty($file_data)) {
                        $uploadedfile = $data['file'];
                        $upload_overrides = array( 'test_form' => false );
                        $filename = wp_handle_upload($uploadedfile, $upload_overrides);
                        update_post_meta($item['post_id'], 'almedis_pedido_bono_file', $filename['url']);
                    }
                }
                if ($data['payment_method'] == 'transferencia') {
                    update_post_meta($item['post_id'], 'almedis_pedido_transferencia_amount', $data['transferencia_total']);
                    update_post_meta($item['post_id'], 'almedis_pedido_transferencia_date', date('Y-m-d'));

                    if (!empty($file_data)) {
                        $uploadedfile = $data['file'];
                        $upload_overrides = array( 'test_form' => false );
                        $filename = wp_handle_upload($uploadedfile, $upload_overrides);
                        update_post_meta($item['post_id'], 'almedis_pedido_transferencia_file', $filename['url']);
                    }
                }

                if (!empty($data['carta'])) {
                    $uploadedfile = $data['carta'];
                    $upload_overrides = array( 'test_form' => false );
                    $filename = wp_handle_upload($uploadedfile, $upload_overrides);
                    update_post_meta($item['post_id'], 'almedis_client_cartapoder', $filename['url']);
                }
    
                if (!empty($data['carnet'])) {
                    $uploadedfile = $data['carnet'];
                    $upload_overrides = array( 'test_form' => false );
                    $filename = wp_handle_upload($uploadedfile, $upload_overrides);
                    update_post_meta($item['post_id'], 'almedis_client_carnet', $filename['url']);
                }
            }

            $text = 'Pago: Se ha registrado el pago del ' . wp_strip_all_tags('Pedido #' . $data['pedido_id']);
            $historial = new Almedis_Forms_Historial($this->plugin_name, $this->version);
            $historial->create_almedis_historial($text);

            $notification = new Almedis_Forms_Notificactions($this->plugin_name, $this->version);
            $notification->almedis_payment_confirmation($data);

            $response =array(
                'message' => __('El pago fue registrado exitosamente, recibiras una notificación al correo electrónico.', 'almedis'),
                'class' => 'success'
            );
        } else {
            $response =array(
                'message' => __('El código del pedido no existe, por favor confirme esta información e intente nuevamente', 'almedis'),
                'class' => 'error'
            );
        }

        wp_send_json_success($response, 200);
        wp_die();
    }

    /**
    * Method almedis_tracking_pedido_callback
    * Callback for checking pedido custom post type status
    *
    * @since    1.0.0
    * @param    void
    * @return void
    */
    public function almedis_tracking_pedido_callback()
    {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        }

        // Initialize globals and vars
        global $wpdb;
        $response = array();

        // Process sent data from ajax
        $data =  isset($_POST) ? $_POST : array();
        
        // Search pedido custom post type from pedido_id
        $results = $wpdb->get_results("select post_id from $wpdb->postmeta where meta_value = '{$data['payment_pedido']}'", ARRAY_A);
        if (!empty($results)) {
            foreach ($results as $item) {
                // get pedido_id and current status
                $data['pedido_id'] = $item['post_id'];
                $status = get_post_meta($item['post_id'], 'almedis_pedido_status', true);
            }

            // calculate progress from status
            if ($status == 'Cancelada') {
                $value = 0;
            }
            if (($status == 'Cotizacion Recibida') || ($status == 'Pendiente de Pago') || ($status == 'Pago Confirmado')) {
                $value = 25;
            }
            if ($status == 'En Tránsito') {
                $value = 66;
            }
            if ($status == 'Completada') {
                $value = 100;
            }

            // create ob_content with response
            ob_start(); ?>
<div class="pedido-tracking-line-container">
    <div class="pedido-tracking-line">
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
<?php
            $content = ob_get_clean();
            // return response
            $response =array(
                'message' => $content,
                'class' => 'success'
            );
        } else {
            // return response
            $response =array(
                'message' => __('El código del pedido no existe, por favor confirme esta información e intente nuevamente', 'almedis'),
                'class' => 'error'
            );
        }

        wp_send_json_success($response, 200);
        wp_die();
    }

    /* --------------------------------------------------------------
        TESTIMONIALS FUNCTIONS
    -------------------------------------------------------------- */
    /**
    * Method almedis_testimonial_submit_callback
    * Callback for uploading a testimonials custom post type
    *
    * @since    1.0.0
    * @param    void
    * @return void
    */
    public function almedis_testimonial_submit_callback()
    {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        }

        if (! function_exists('wp_handle_upload')) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
        }

        // Process sent data from AJAX
        $posted_data =  isset($_POST) ? $_POST : array();
        $file_data = isset($_FILES) ? $_FILES : array();
        $data = array_merge($posted_data, $file_data);
        $response = array();

        // Upload the picture for testimonial custom post type
        $uploadedfile = $data['test_picture'];
        $upload_overrides = array( 'test_form' => false );
        $test_picture = wp_handle_upload($uploadedfile, $upload_overrides);
        $filename = $test_picture['url'];

        // Build testimonial custom post type array data
        $testimonial_post = array(
            'post_title'    => wp_strip_all_tags($data['test_nombre']),
            'post_content'  => $data['test_message'],
            'post_type'     => 'testimonios',
            'post_status'   => 'draft',
            'post_author'   => 1
        );

        // Insert the post into the database
        $parent_post_id = wp_insert_post($testimonial_post);
        
        // Get the path to the upload directory.
        $wp_upload_dir = wp_upload_dir();
        
        // Prepare an array of post data for the attachment.
        $attachment = array(
            'guid'           => $wp_upload_dir['url'] . '/' . basename($filename),
            'post_title'     => preg_replace('/\.[^.]+$/', '', basename($filename)),
            'post_content'   => '',
            'post_status'    => 'inherit'
        );
        
        // Insert the attachment.
        $attach_id = wp_insert_attachment($attachment, $filename, $parent_post_id);
        
        // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        
        // Generate the metadata for the attachment, and update the database record.
        $attach_data = wp_generate_attachment_metadata($attach_id, $filename);
        wp_update_attachment_metadata($attach_id, $attach_data);
        set_post_thumbnail($parent_post_id, $attach_id);

        // Create new historial data
        $text = 'Sistema: Se ha registrado un nuevo testimonio';
        $historial = new Almedis_Forms_Historial($this->plugin_name, $this->version);
        $historial->create_almedis_historial($text);

        // return response
        $response =array(
            'message' => __('Gracias por su testimonio! De esa manera nos ayudas a mejorar.', 'almedis'),
            'class' => 'success'
        );

        wp_send_json_success($response, 200);
        wp_die();
    }

    /* --------------------------------------------------------------
        DASHBOARD USER AND INSTITUCION FUNCTIONS
    -------------------------------------------------------------- */
    /**
    * Method almedis_repeat_pedido_callback
    * Callback for repeat a pedido custom post type
    *
    * @since    1.0.0
    * @param    void
    * @return void
    */
    public function almedis_repeat_pedido_callback()
    {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        }

        $data = array();
        // Get current quantity of pedidos custom post type
        $query_pedidos = new WP_Query(array('post_type' => 'pedidos', 'posts_per_page' => -1));
        $qty_pedidos = $query_pedidos->found_posts;
        // Add additional one
        $qty_pedidos = $qty_pedidos + 1;
        wp_reset_query();

        // Get pedido_id
        $pedido_id = $_POST['pedido_id'];
        // Get pedido status
        $type = get_post_meta($pedido_id, 'almedis_client_type', true);

        // Construct pedido array data
        $pedidos_post = array(
            'post_title'    => wp_strip_all_tags('Pedido #' . $qty_pedidos),
            'post_content'  => ' ',
            'post_type'  => 'pedidos',
            'post_status'   => 'publish',
            'post_author'   => 1,
            'meta_input'    => array(
                'almedis_unique_id'             => uniqid(),
                'almedis_client_tipo'           => get_post_meta($pedido_id, 'almedis_client_tipo', true),
                'almedis_client_type'           => get_post_meta($pedido_id, 'almedis_client_type', true),
                'almedis_client_institucion'    => get_post_meta($pedido_id, 'almedis_client_institucion', true),
                'almedis_client_convenio'       => get_post_meta($pedido_id, 'almedis_client_convenio', true),
                'almedis_client_name'           => get_post_meta($pedido_id, 'almedis_client_name', true),
                'almedis_client_rut'            => get_post_meta($pedido_id, 'almedis_client_rut', true),
                'almedis_client_email'          => get_post_meta($pedido_id, 'almedis_client_email', true),
                'almedis_client_phone'          => get_post_meta($pedido_id, 'almedis_client_phone', true),
                'almedis_client_medicine'       => get_post_meta($pedido_id, 'almedis_client_medicine', true),
                'almedis_client_notification'   => get_post_meta($pedido_id, 'almedis_client_notification', true),
                'almedis_client_user'           => get_post_meta($pedido_id, 'almedis_client_user', true),
                'almedis_pedido_status'         => 'Cotizacion Recibida',
                'almedis_pedido_confirmation'   => '',
                'almedis_client_recipe'         => get_post_meta($pedido_id, 'almedis_client_recipe', true),
                'almedis_client_cartapoder'     => get_post_meta($pedido_id, 'almedis_client_cartapoder', true),
                'almedis_client_carnet'         => get_post_meta($pedido_id, 'almedis_client_carnet', true)
            )
        );

        // Insert the post into the database
        $pedido_new_id = wp_insert_post($pedidos_post);

        // Construct natural type data for notifications and historial
        if ($type == 'natural') {
            $data['natural_type'] = get_post_meta($pedido_new_id, 'almedis_client_type', true);
            $data['natural_nombre'] = get_post_meta($pedido_new_id, 'almedis_client_name', true);
            $data['natural_rut'] = get_post_meta($pedido_new_id, 'almedis_client_rut', true);
            $data['natural_email'] = get_post_meta($pedido_new_id, 'almedis_client_email', true);
            $data['natural_phone'] = get_post_meta($pedido_new_id, 'almedis_client_phone', true);
            $data['natural_medicine'] = get_post_meta($pedido_new_id, 'almedis_client_medicine', true);
            $data['natural_notification'] = get_post_meta($pedido_new_id, 'almedis_client_notification', true);
        }

        // Construct convenio type data for notifications and historial
        if ($type == 'convenio') {
            $data['convenio_type'] = get_post_meta($pedido_new_id, 'almedis_client_type', true);
            $data['convenio_usuario'] = get_post_meta($pedido_new_id, 'almedis_client_convenio', true);
            $data['convenio_nombre'] = get_post_meta($pedido_new_id, 'almedis_client_name', true);
            $data['convenio_rut'] = get_post_meta($pedido_new_id, 'almedis_client_rut', true);
            $data['convenio_email'] = get_post_meta($pedido_new_id, 'almedis_client_email', true);
            $data['convenio_phone'] = get_post_meta($pedido_new_id, 'almedis_client_phone', true);
            $data['convenio_medicine'] = get_post_meta($pedido_new_id, 'almedis_client_medicine', true);
            $data['convenio_notification'] = get_post_meta($pedido_new_id, 'almedis_client_notification', true);
        }

        // Construct institucion type data for notifications and historial
        if ($type == 'institucion') {
            $data['convenio_type'] = get_post_meta($pedido_new_id, 'almedis_client_type', true);
            $data['convenio_institucion'] = get_post_meta($pedido_new_id, 'almedis_client_institucion', true);
            $data['convenio_nombre'] = get_post_meta($pedido_new_id, 'almedis_client_name', true);
            $data['convenio_rut'] = get_post_meta($pedido_new_id, 'almedis_client_rut', true);
            $data['convenio_email'] = get_post_meta($pedido_new_id, 'almedis_client_email', true);
            $data['convenio_phone'] = get_post_meta($pedido_new_id, 'almedis_client_phone', true);
            $data['convenio_medicine'] = get_post_meta($pedido_new_id, 'almedis_client_medicine', true);
            $data['convenio_notification'] = get_post_meta($pedido_new_id, 'almedis_client_notification', true);
        }
 
        // Create historial data
        $text = 'Pedido: El ' . wp_strip_all_tags('Pedido #' . $qty_pedidos) . ' ha sido copiado correctamente';
        $historial = new Almedis_Forms_Historial($this->plugin_name, $this->version);
        $historial->create_almedis_historial($text);

        // Send notification email
        $notification = new Almedis_Forms_Notificactions($this->plugin_name, $this->version);
        $notification->email_form_submit($data, 'institucion');

        if ($tipo == 'institucion') {
            $notification_admin = new Almedis_Forms_Notificactions($this->plugin_name, $this->version);
            $notification_admin->almedis_admin_medicine_notification($data, 'institucion');
        }

        wp_die();
    }

    /**
    * Method almedis_edit_pedido_callback
    * Callback for edit a pedido custom post type
    *
    * @since    1.0.0
    * @param    void
    * @return void
    */
    public function almedis_edit_pedido_callback()
    {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        }

        $pedido_id = $_POST['pedido_id'];
        $status = get_post_meta($pedido_id, 'almedis_pedido_status', true);
        $title = '<h2>Ver Pedido #' . ' ' . $pedido_id . '</h2>';

        ob_start(); ?>
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
        <div class="form-group-archives">
            <h3>Archivos</h3>
            <div class="custom-modal-file-control">
                <?php $receta = get_post_meta($pedido_id, 'almedis_client_recipe', true); ?>
                <?php $class = ($receta == '') ? 'hidden' : ''; ?>
                <?php $missing = ($receta == '') ? 'missing' : ''; ?>
                <?php $text = ($receta == '') ? 'Cargar ' : ''; ?>
                <label for="client_recipe_file" class="custom-modal-file-upload <?php echo $missing; ?>">
                    <input id="client_recipe_file" name="client_recipe" class="form-control" type="file" />
                    <?php echo $text; ?>Receta
                </label>
                <a href="<?php echo $receta; ?>" title="Ver Archivo" target="_blank" class="almedis-file-icon <?php echo $class; ?>"></a>
                <div class="file-helper <?php echo $class; ?>"> <span id="recetaSelected"></span></div>
            </div>
            <div class="custom-modal-file-control">
                <?php $carta = get_post_meta($pedido_id, 'almedis_client_cartapoder', true); ?>
                <?php $class = ($carta == '') ? 'hidden' : ''; ?>
                <?php $missing = ($carta == '') ? 'missing' : ''; ?>
                <?php $text = ($carta == '') ? 'Cargar ' : ''; ?>
                <label for="client_carta_file" class="custom-modal-file-upload <?php echo $missing; ?>">
                    <input id="client_carta_file" name="client_carta" class="form-control" type="file" />
                    <?php echo $text; ?>Carta Poder
                </label>
                <a href="<?php echo $carta; ?>" title="Ver Archivo" target="_blank" class="almedis-file-icon <?php echo $class; ?>"></a>
                <div class="file-helper <?php echo $class; ?>"> <span id="cartaSelected"></span></div>
            </div>
            <div class="custom-modal-file-control">
                <?php $carnet = get_post_meta($pedido_id, 'almedis_client_carnet', true); ?>
                <?php $class = ($carnet == '') ? 'hidden' : ''; ?>
                <?php $missing = ($carnet == '') ? 'missing' : ''; ?>
                <?php $text = ($carnet == '') ? 'Cargar ' : ''; ?>
                <label for="client_carnet_file" class="custom-modal-file-upload <?php echo $missing; ?>">
                    <input id="client_carnet_file" name="client_carnet" class="form-control" type="file" />
                    <?php echo $text; ?>Carnet de Identificación
                </label>
                <a href="<?php echo $carnet; ?>" title="Ver Archivo" target="_blank" class="almedis-file-icon <?php echo $class; ?>"></a>
                <div class="file-helper <?php echo $class; ?>"> <span id="carnetSelected"></span></div>
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
            <div class="pedido-tracking-line">
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
<?php
        $content = ob_get_clean();
        $data = array(
            'title' => $title,
            'content' => $content
        );
        wp_send_json_success($data, 200);

        wp_die();
    }

    public function almedis_lost_pass_user_callback()
    {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        }

        // initialize vars
        $response = array();
        $data =  isset($_POST) ? $_POST : array();

        $user = get_user_by('email', $data['username']);

        if ($user) {
            $unique_id = uniqid();
            add_user_meta($user->ID, 'reset_pass', $unique_id);
            $link = home_url('/recuperar-contrasena') . '?pass_nonce=' . $unique_id . '&username=' . $data['username'];

            $notification_admin = new Almedis_Forms_Notificactions($this->plugin_name, $this->version);
            $notification_admin->almedis_admin_lost_password($data['username'], $link);
            $response =array(
                'message' => __('Se le ha enviado a su correo electrónico un link de reestablecimiento de contraseña.', 'almedis'),
                'class' => 'success'
            );
        } else {
            $response =array(
                'message' => __('El correo no existe en nuestra base de datos.', 'almedis'),
                'class' => 'error'
            );
        }


        // send response
        
        
        wp_send_json_success($response, 200);
        wp_die();
    }


    public function almedis_new_pass_user_callback()
    {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        }

        // initialize vars
        $response = array();
        $data =  isset($_POST) ? $_POST : array();

        $user = get_user_by('ID', $data['username']);
        wp_set_password($data['password'], $user->ID);
        delete_user_meta($user->ID, 'reset_pass');
       
        $response =array(
            'message' => __('Reestablecimiento exitoso, en breve serás redirigido a tu cuenta', 'almedis'),
            'class' => 'success',
            'redirect' => home_url('/mi-cuenta')
        );

        $notification_admin = new Almedis_Forms_Notificactions($this->plugin_name, $this->version);
        $notification_admin->almedis_admin_new_password($user->user_email);
        // send response
        wp_send_json_success($response, 200);
        wp_die();
    }

    /* --------------------------------------------------------------
        DASHBOARD INSTITUCION FUNCTIONS
    -------------------------------------------------------------- */
    /**
    * Method almedis_update_institucion_callback
    * Callback for edit an institucion custom post type
    *
    * @since    1.0.0
    * @param    void
    * @return void
    */
    public function almedis_update_institucion_callback()
    {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        }

        // initialize vars
        $response = array();
        $data =  isset($_POST) ? $_POST : array();

        // Get instituto id for edit
        $inst_id = $data['inst_id'];

        // Create array data for instituto edition
        $instituto_data = array(
            'ID'           => $inst_id,
            'post_title'   => $data['institucion_nombre']
        );

        // Update instituto data
        wp_update_post($instituto_data);

        // Update instituto post meta
        update_post_meta($inst_id, 'almedis_institucion_rut', $data['institucion_rut']);
        update_post_meta($inst_id, 'almedis_institucion_phone', $data['institucion_phone']);

        // send response
        $response =array(
            'message' => __('Los datos del instituto se han actualizado exitosamente.', 'almedis'),
            'class' => 'success'
        );
        
        wp_send_json_success($response, 200);
        wp_die();
    }

    public function almedis_download_modal_callback()
    {
        ob_start();
        $user = get_current_user_id();
        $instituto = get_user_meta($user, 'almedis_client_instituto', true);
        $arr_pedidos = new WP_Query(array('post_type' => 'pedidos', 'posts_per_page' => -1, 'meta_query' => array(array('key' => 'almedis_client_institucion', 'value' => $instituto, 'compare' => '=' ))));
        if ($arr_pedidos->have_posts()) :
            while ($arr_pedidos->have_posts()) : $arr_pedidos->the_post();
        $arr_medicinas[] = get_post_meta(get_the_ID(), 'almedis_client_medicine', true);
        endwhile;
        endif;
        wp_reset_query(); ?>
<div class="almedis-filter-container">
    <h2>Descargar Pedidos</h2>
    <p>Seleccione los filtros a aplicar para el archivo.</p>
    <form class="almedis-filter-form">
        <div class="filters-fields">
            <h3>Filtrar por Medicina</h3>
            <label for="medicine">Seleccione Medicina</label>
            <select name="medicine" id="medicine">
                <option value="all">Todas</option>
                <?php foreach ($arr_medicinas as $item) { ?>
                <option value="<?php echo $item; ?>"><?php echo $item; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="filters-fields">
            <h3>Filtrar por Fechas</h3>
            <label for="medicine">Fecha Inicial</label>
            <input type="date" name="start-date" id="start-date">

            <label for="medicine">Fecha Final</label>
            <input type="date" name="end-date" id="end-date">
        </div>

        <div class="filter-button-container">
            <button class="filter-file-btn" data-export="filter">Exportar Archivo</button>
            <button class="filter-file-btn" data-export="all">Exportar Todo</button>
            <div class="filter-mini-loader"></div>
        </div>
    </form>
</div>
<?php
        $content = ob_get_clean();
        $data = array(
            'title' => $title,
            'content' => $content
        );
        wp_send_json_success($data, 200);
        wp_die();
    }


    public function almedis_get_archhive_callback()
    {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        }

        $books = [
            ['Código', 'Tipo de Cliente', 'Nombres y Apellidos', 'RUT', 'Correo Electrónico', 'Teléfono / WhatsApp', 'Medicamento', 'Recepción de Cotización' ],
        ];

        parse_str($_POST['info'], $info);
        $user = get_current_user_id();
        $instituto = get_user_meta($user, 'almedis_client_instituto', true);
        $arr_pedidos = new WP_Query(
            array(
            'post_type' => 'pedidos',
            'posts_per_page' => -1,
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'almedis_client_institucion',
                    'value' => $instituto,
                    'compare' => '='
                ),
                array(
                    'key' => 'almedis_client_medicine',
                    'value' => $info['medicine'],
                    'compare' => '='
                )
            )
        )
        );
        if ($arr_pedidos->have_posts()) :
        while ($arr_pedidos->have_posts()) : $arr_pedidos->the_post();
        $books[] = array(
                get_post_meta(get_the_ID(), 'almedis_unique_id', true),
                get_post_meta(get_the_ID(), 'almedis_client_tipo', true),
                get_post_meta(get_the_ID(), 'almedis_client_name', true),
                get_post_meta(get_the_ID(), 'almedis_client_rut', true),
                get_post_meta(get_the_ID(), 'almedis_client_email', true),
                get_post_meta(get_the_ID(), 'almedis_client_phone', true),
                get_post_meta(get_the_ID(), 'almedis_client_medicine', true),
                get_post_meta(get_the_ID(), 'almedis_client_notification', true)
            );
        endwhile;
        endif;
        wp_reset_query();

        $xlsx = Shuchkin\SimpleXLSXGen::fromArray($books);
        $xlsx->saveAs('books.xlsx');


        return $xlsx->download();
        wp_die();
    }
    
    /**
     * Method almedis_load_docs_callback
     *
     * @return void
     */
    public function almedis_load_docs_callback()
    {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        }

        if (! function_exists('wp_handle_upload')) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
        }

        $pedido_id = $_POST['pedido_id'];

        if (isset($_FILES['client_carta'])) {
            $uploadedfile = $_FILES['client_carta'];
            $upload_overrides = array( 'test_form' => false );
            $recipe = wp_handle_upload($uploadedfile, $upload_overrides);
            update_post_meta($pedido_id, 'almedis_client_cartapoder', $recipe['url']);
        }

        if (isset($_FILES['client_carnet'])) {
            $uploadedfile = $_FILES['client_carnet'];
            $upload_overrides = array( 'test_form' => false );
            $recipe = wp_handle_upload($uploadedfile, $upload_overrides);
            update_post_meta($pedido_id, 'almedis_client_carnet', $recipe['url']);
        }

        if (isset($_FILES['client_recipe'])) {
            $uploadedfile = $_FILES['client_recipe'];
            $upload_overrides = array( 'test_form' => false );
            $recipe = wp_handle_upload($uploadedfile, $upload_overrides);
            update_post_meta($pedido_id, 'almedis_client_recipe', $recipe['url']);
        }

        wp_send_json_success('Los archivos han sido cargados exitosamente', 200);

        wp_die();
    }

    public function almedis_reload_docs_callback()
    {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        }
        $pedido_id = $_POST['pedido_id'];
        ob_start(); ?>
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
<?php
        $content = ob_get_clean();
        wp_send_json_success($content, 200);
        wp_die();
    }
}
