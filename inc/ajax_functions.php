<?php

/**
* Almedis Dashboard - Ajax Functions
*
*
* @package    almedis-forms
* @subpackage dashboard
*
*/

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class AlmedisAjax extends AlmedisForm
{
    /**
     * Method __construct
     *
     * @return void
     */
    public function __construct()
    {
        // NATURAL FORMS
        add_action('wp_ajax_almedis_register_natural', array($this, 'almedis_register_natural_callback'));
        add_action('wp_ajax_nopriv_almedis_register_natural', array($this, 'almedis_register_natural_callback'));
        // CONVENIOS FORMS
        add_action('wp_ajax_almedis_register_convenio', array($this, 'almedis_register_convenio_callback'));
        add_action('wp_ajax_nopriv_almedis_register_convenio', array($this, 'almedis_register_convenio_callback'));
    }

    /**
     * Method user_id_exists
     *
     * @param $email $email emaill address
     *
     * @return void
     */
    public function user_id_exists($email)
    {
        global $wpdb;
    
        $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->users WHERE user_email = %d", $email));
    
        if ($count == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method almedis_register_natural_callback
     *
     * @return void
     */
    public function almedis_register_natural_callback()
    {
        if (! function_exists('wp_handle_upload')) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
        }
        /* PROCESS SENT DATA FROM AJAX */
        $posted_data =  isset($_POST) ? $_POST : array();
        $file_data = isset($_FILES) ? $_FILES : array();
        
        $data = array_merge($posted_data, $file_data);

        /* SEARCH FOR USER AND CREATE / FIND USER ID */
        $user_id = $this->create_almedis_client_user($data, 'natural');

        /* REGISTER ALMEDIS DOCUMENTS */
        $files = $this->register_almedis_documents($data, 'natural');

        /* REGISTER A NATURAL CLIENT PEDIDO */
        $pedido_id = $this->create_almedis_pedido($data, $files, 'natural', $user_id);

        // send response
        wp_send_json_success(__('Su pedido fue procesado, en breve recibirá un correo con esta transacción', 'almedis'), 200);
        
        wp_die();
    }

    
    /**
     * Method almedis_register_convenio_callback
     *
     * @return void
     */
    public function almedis_register_convenio_callback()
    {
        if (! function_exists('wp_handle_upload')) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
        }
        /* PROCESS SENT DATA FROM AJAX */
        $posted_data =  isset($_POST) ? $_POST : array();
        $file_data = isset($_FILES) ? $_FILES : array();
        
        $data = array_merge($posted_data, $file_data);

        /* SEARCH FOR USER AND CREATE / FIND USER ID */
        $user_id = $this->create_almedis_client_user($data, 'convenio');

        /* REGISTER ALMEDIS DOCUMENTS */
        $files = $this->register_almedis_documents($data, 'convenio');

        /* REGISTER A NATURAL CLIENT PEDIDO */
        $pedido_id = $this->create_almedis_pedido($data, $files, 'convenio', $user_id);

        // send response
        wp_send_json_success(__('Su pedido fue procesado, en breve recibirá un correo con esta transacción', 'almedis'), 200);
        
        wp_die();
    }
    
    
    /**
     * Method create_almedis_client_user
     *
     * @param $data $data [explicite description]
     *
     * @return void
     */
    public function create_almedis_client_user($data, $type)
    {
        if ($type == 'natural') {
            if ($this->user_id_exists($data['natural_email'])) {
                $user = get_user_by('email', $data['natural_email']);
                $user_id = $user->ID;
            } else {
                $nombre = explode(' ', $data['natural_nombre']);
                $login = explode('@', $data['natural_email']);

                $data = array(
                'user_login'           => $login[0],
                'user_email'           => $data['natural_email'],
                'user_pass'            => $data['natural_password'],
                'role'                 => 'almedis-client',
                'first_name'           => $nombre[0],
                'last_name'            => $nombre[1],
                'use_ssl'              => false,
                'user_registered'      => date('Y-m-d H:i:s'),
                'show_admin_bar_front' => false
            );
              
                $user_id = wp_insert_user($data);
            }
        } else {
            if ($this->user_id_exists($data['convenio_email'])) {
                $user = get_user_by('email', $data['convenio_email']);
                $user_id = $user->ID;
            } else {
                $nombre = explode(' ', $data['convenio_nombre']);
                $login = explode('@', $data['convenio_email']);

                $data = array(
                'user_login'           => $login[0],
                'user_email'           => $data['convenio_email'],
                'user_pass'            => $data['convenio_password'],
                'role'                 => 'almedis-client',
                'first_name'           => $nombre[0],
                'last_name'            => $nombre[1],
                'use_ssl'              => false,
                'user_registered'      => date('Y-m-d H:i:s'),
                'show_admin_bar_front' => false
            );
              
                $user_id = wp_insert_user($data);
            }
        }

        return $user_id;
    }
    
    /**
     * Method register_almedis_documents
     *
     * @param $data $data [explicite description]
     *
     * @return void
     */
    public function register_almedis_documents($data, $type)
    {
        $docs = array();

        if ($type == 'natural') {
            /* SAVE SENT FILES */
            if (isset($data['natural_medicine_file'])) {
                $uploadedfile = $data['natural_medicine_file'];
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
        } else {
            /* SAVE SENT FILES */
            if (isset($data['convenio_medicine_file'])) {
                $uploadedfile = $data['convenio_medicine_file'];
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
        }

        return $docs;
    }
       
    /**
     * Method create_almedis_pedido
     *
     * @param $data $data [explicite description]
     * @param $files $files [explicite description]
     * @param $type $type [explicite description]
     * @param $user_id $user_id [explicite description]
     *
     * @return void
     */
    public function create_almedis_pedido($data, $files, $type, $user_id)
    {
        /* SAVE SENT INPUTS AND CREATE PEDIDO POST TYPE */
        $query_pedidos = new WP_Query(array('post_type' => 'pedidos', 'posts_per_page' => -1));

        // GET PEDIDOS CUSTOM POST TYPE QUANTITY
        $qty_pedidos = $query_pedidos->found_posts;
        $qty_pedidos = $qty_pedidos + 1;

        if ($type == 'natural') {
            $instituto_id = null;
            $nombre = $data['natural_nombre'];
            $rut = $data['natural_rut'];
            $email = $data['natural_email'];
            $phone = $data['natural_phone'];
            $medicine = $data['natural_medicine'];
            $notificacion = $data['natural_notification'];
        } else {
            $instituto_id = $data['convenio_institucion'];
            $nombre = $data['convenio_nombre'];
            $rut = $data['convenio_rut'];
            $email = $data['convenio_email'];
            $phone = $data['convenio_phone'];
            $medicine = $data['convenio_medicine'];
            $notificacion = $data['convenio_notification'];
        }

        $pedidos_post = array(
            'post_title'    => wp_strip_all_tags('Pedido #' . $qty_pedidos),
            'post_content'  => ' ',
            'post_type'  => 'pedidos',
            'post_status'   => 'publish',
            'post_author'   => 1,
            'meta_input'    => array(
                'almedis_client_type'           => $type,
                'almedis_client_instituto'      => $instituto_id,
                'almedis_client_name'           => $nombre,
                'almedis_client_rut'            => $rut,
                'almedis_client_email'          => $email,
                'almedis_client_phone'          => $phone,
                'almedis_client_medicine'       => $medicine,
                'almedis_client_notification'   => $notificacion,
                'almedis_client_user'           => $user_id,
                'almedis_client_recipe'         => $files['recipe'],
                'almedis_client_cartapoder'     => $files['cartapoder']
            )
        );
           
        // Insert the post into the database
        $pedidos_id = wp_insert_post($pedidos_post);

        return $pedidos_id;
    }
}

new AlmedisAjax;
