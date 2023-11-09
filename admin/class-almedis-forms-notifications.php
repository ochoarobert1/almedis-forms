<?php
/**
 * Notifications by Email Class
 *
 * @package    Almedis_Forms
 * @subpackage Almedis_Forms/admin
 * @author     IndexArt <indexart@gmail.com>
 */
class Almedis_Forms_Notificactions
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

    public function almedis_admin_lost_password($data, $link) {
        $title = 'Reestableza su contraseña';
        $title_long = 'Se ha recibido una solicitud de reestablecimiento de contraseña';
        ob_start(); ?>
<p>Estimado usuario,</p>
<p>Se ha recibido una solicitud de reestablecimiento de contraseña, pulse en el botón de abajo para recuperar su cuenta.</p>
<br>
<div style="margin:15px;text-align:center;">
    <a href="<?php echo $link; ?>" style="margin: 18px auto;max-width:200px;text-align:center;background-color:#009DF1;color:#FFF;padding:15px 25px;display: block;">Reestablecer mi contraseña</a>
</div>
<br>
<p>Si ud. no hizo la solicitud puede ignorar este correo.</p>
<br>
<br>
<br>
<?php
                $content = ob_get_clean();
        $this->almedis_send_notification($title, $title_long, $content, $data);
    }

    public function almedis_admin_new_password($data) {
        $title = 'Se ha reestablecido su contraseña';
        $title_long = 'Se ha reestablecido su contraseña exitosamente';
        ob_start(); ?>
<p>Estimado usuario,</p>
<p>Se ha reestablecido el acceso a su cuenta, al cambiar su contraseña.</p>
<br>
<p>Si ud. no hizo la solicitud, le instamos a cambiar su contraseña de inmediato.</p>
<br>
<br>
<br>
<?php
                $content = ob_get_clean();
        $this->almedis_send_notification($title, $title_long, $content, $data);
    }

    /**
     * Method email_form_submit
     * Email notification after form submission
     *
     * @param   $post_type
     * @since   1.0.0
     * @return  void
     */
    public function email_form_submit($data, $type)
    {
        if ($type == 'natural') {
            $tipo = $data['natural_type'];
            $institucion = '';
            $convenio = '';
            $nombre = $data['natural_nombre'];
            $rut = $data['natural_rut'];
            $email = $data['natural_email'];
            $phone = $data['natural_phone'];
            $medicine = $data['natural_medicine'];
            $notif = $data['natural_notification'];
            $title = 'Notificación de Nuevo Pedido - Natural';
        }
        if ($type == 'convenio') {
            $tipo = $data['convenio_type'];
            $institucion = '';
            $convenio = $data['convenio_usuario'];
            $nombre = $data['convenio_nombre'];
            $rut = $data['convenio_rut'];
            $email = $data['convenio_email'];
            $phone = $data['convenio_phone'];
            $medicine = $data['convenio_medicine'];
            $notif = $data['convenio_notification'];
            $title = 'Notificación de Nuevo Pedido - Convenio';
        }
        if ($type == 'institucion') {
            $tipo = $data['convenio_type'];
            $convenio = '';
            $institucion = $data['convenio_institucion'];
            $nombre = $data['convenio_nombre'];
            $rut = '';
            $email = $data['convenio_email'];
            $phone = '';
            $medicine = $data['convenio_medicine'];
            $notif = '';
            $title = 'Notificación de Nuevo Pedido - Institucion';
        }
        $title_long = 'Nuevo Pedido de ' . $nombre;

        $pedido_data = get_post_meta($data['pedido_id'], 'almedis_unique_id', true);

        ob_start(); ?>
<p>Gracias por generar un nuevo pedido en nuestra plataforma, en breve le enviaremos más información al respecto</p>
<br>
<p>Estos son los datos que hemos recibido</p>
<?php if ($convenio != '') {
            $user = get_user_by('ID', $convenio);
            if ($user) { ?>
<p><b>Convenio:</b> <?php echo $user->first_name . ' ' . $user->last_name; ?></p>
<?php
        }
        } ?>
<?php if ($institucion != '') {
            $institucion_post = get_post($institucion); ?>
<p><b>Institucion:</b> <?php echo $institucion_post->post_title; ?></p>
<?php
        } ?>
<p><b>Nro de Pedido:</b> <?php echo $pedido_data; ?></p>
<br>
<p><b>Nombre:</b> <?php echo $nombre; ?></p>
<p><b>Tipo de Usuario:</b> <?php echo $tipo; ?></p>
<?php if ($type != 'institucion') { ?>
<p><b>RUT:</b> <?php echo $rut; ?></p>
<?php } ?>
<p><b>Correo Electrónico:</b> <?php echo $email; ?></p>
<?php if ($type != 'institucion') { ?>
<p><b>Teléfono:</b> <?php echo $phone; ?></p>
<?php } ?>
<p><b>Medicina a ubicar:</b> <?php echo $medicine; ?></p>
<?php if ($type != 'institucion') { ?>
<p><b>Vía de notificación preferida:</b> <?php echo $notif; ?></p>
<?php } ?>
<br>
<p>Mientras tanto, lo invitamos a abrir su cuenta dentro de nuestro sistema, esto nos permitirá poder ofrecerle un servicio más personalizado y directo.</p>
<p>Puede crear su cuenta haciendo click en el sigiente botón</p>
<div style="margin:15px;text-align:center;">
    <a href="<?php echo home_url('/registro?id=') . $pedido_data; ?>" style="margin: 18px auto;max-width:200px;text-align:center;background-color:#009DF1;color:#FFF;padding:15px 25px;display: block;">Crear mi cuenta</a>
</div>
<br>
<small>Si no puedes hacer click en el boton, puedes copiar y pegar el siguiente link en tu navegador</small>
<a href="<?php echo home_url('/registro?id=') . $pedido_data; ?>"><?php echo home_url('/registro?id=') . $pedido_data; ?></a>
<br>
<br>
<br>
<br>
<?php
        $content = ob_get_clean();

        $this->almedis_send_notification($title, $title_long, $content, $email);
    }
    
    /**
     * Method almedis_admin_medicine_notification
     *
     * @param $data $data [explicite description]
     * @param $type $type [explicite description]
     *
     * @return void
     */
    public function almedis_admin_medicine_notification($data, $type)
    {
        if ($type == 'natural') {
            $tipo = $data['natural_type'];
            $institucion = '';
            $convenio = '';
            $nombre = $data['natural_nombre'];
            $rut = $data['natural_rut'];
            $email = $data['natural_email'];
            $phone = $data['natural_phone'];
            $medicine = $data['natural_medicine'];
            $notif = $data['natural_notification'];
            $title = 'Notificación de Nuevo Pedido - Natural';
        }
        if ($type == 'convenio') {
            $tipo = $data['convenio_type'];
            $institucion = '';
            $convenio = $data['convenio_usuario'];
            $nombre = $data['convenio_nombre'];
            $rut = $data['convenio_rut'];
            $email = $data['convenio_email'];
            $phone = $data['convenio_phone'];
            $medicine = $data['convenio_medicine'];
            $notif = $data['convenio_notification'];
            $title = 'Notificación de Nuevo Pedido - Convenio';
        }
        if ($type == 'institucion') {
            $tipo = $data['convenio_type'];
            $convenio = '';
            $institucion = $data['convenio_institucion'];
            $nombre = $data['convenio_nombre'];
            $rut = '';
            $email = $data['convenio_email'];
            $phone = '';
            $medicine = $data['convenio_medicine'];
            $notif = '';
            $title = 'Notificación de Nuevo Pedido - Institucion';
        }
        $title_long = 'Nuevo Pedido de ' . $nombre;

        $pedido_data = get_post_meta($data['pedido_id'], 'almedis_unique_id', true);

        ob_start(); ?>
<p>Se ha recibido un nuevo pedido pendiente por confirmar.</p>
<p>Estos son los datos que hemos recibido</p>
<?php if ($convenio != '') {
            $user = get_user_by('ID', $convenio);
            if ($user) { ?>
<p><b>Convenio:</b> <?php echo $user->first_name . ' ' . $user->last_name; ?></p>
<?php
        }
        } ?>
<?php if ($institucion != '') {
            $institucion_post = get_post($institucion); ?>
<p><b>Institucion:</b> <?php echo $institucion_post->post_title; ?></p>
<?php
        } ?>
<p><b>Nombre:</b> <?php echo $nombre; ?></p>
<p><b>Tipo de Usuario:</b> <?php echo $tipo; ?></p>
<?php if ($type != 'institucion') { ?>
<p><b>RUT:</b> <?php echo $rut; ?></p>
<?php } ?>
<p><b>Correo Electrónico:</b> <?php echo $email; ?></p>
<?php if ($type != 'institucion') { ?>
<p><b>Teléfono:</b> <?php echo $phone; ?></p>
<?php } ?>
<p><b>Medicina a ubicar:</b> <?php echo $medicine; ?></p>
<?php if ($type != 'institucion') { ?>
<p><b>Vía de notificación preferida:</b> <?php echo $notif; ?></p>
<?php } ?>
<br>
<br>
<?php
        $content_admin = ob_get_clean();
        $admin_email = get_option('almedis_admin_email');
        $this->almedis_send_notification($title, $title_long, $content_admin, $admin_email);
    }

    /**
     * Method almedis_payment_confirmation
     *
     * @param $data $data [explicite description]
     *
     * @return void
     */
    public function almedis_payment_confirmation($data)
    {
        $title = 'Registro de Pago # ' . $data['payment_pedido'];
        $title_long = 'Se ha recibido un registro de pago del pedido # ' . $data['payment_pedido'];
        ob_start(); ?>
<p>Estimado usuario,</p>
<p>Hemos recibido un registro de pago para su pedido, nuestro departamento de administración va a confirmar estas coordenadas y le haremos saber cuando este procesado.</p>
<br>
<p>Para su control, hemos recibido los siguientes datos.</p>
<br>
<p><b>Código del Pedido:</b> <?php echo $data['payment_pedido']; ?></p>
<?php if ($data['payment_method'] == 'copago') {
            $method = 'Bono';
            $monto = $data['copago_total'];
        } ?>
<?php if ($data['payment_method'] == 'transferencia') {
            $method = 'Transferencia Bancaria';
            $monto = $data['transferencia_total'];
        } ?>
<p><b>Método de Pago:</b> <?php echo $method; ?></p>
<p><b>Monto:</b> <?php echo $monto; ?></p>
<br>
<br>
<br>
<?php
        $content = ob_get_clean();
        $admin_email = get_option('almedis_admin_email');
        $this->almedis_send_notification($title, $title_long, $content, $admin_email);
    }


    /**
    * Method almedis_change_status
    *
    * @param $data $data [explicite description]
    *
    * @return void
    */
    public function almedis_change_status($data)
    {
        $codigo = get_post_meta($data['pedidoID'], 'almedis_unique_id', true);
        $nombre = get_post_meta($data['pedidoID'], 'almedis_client_name', true);
        $email = get_post_meta($data['pedidoID'], 'almedis_client_email', true);
        $title = 'Nuevo estatus del Pedido # ' . $codigo;
        $title_long = 'Su pedido nro: ' . $codigo . 'tiene un nuevo estatus';

        ob_start(); ?>

<p>Estimado: <?php echo $nombre; ?></p>
<br>

<br>
<?php if ($data['estatus'] == 'Cotización Recibida') { ?>
<p>Su pedido nro: <?php echo $codigo; ?> tiene un nuevo estatus: <?php echo $data['estatus']; ?></p>
<p>Puede gestionar el pago de su pedido a través de la opción:</p>
<div style="margin:15px;text-align:center;">
    <a href="<?php echo home_url('/registrar-pago?pedido_id=') . $codigo; ?>" style="margin: 18px auto;max-width:200px;text-align:center;background-color:#009DF1;color:#FFF;padding:15px 25px;display: block;">Registrar Pago</a>
</div>
<br>
<p>Ante cualquier duda o consulta, nuestro sistema de atención al cliente está disponible para atenderle a través del mail: <a href="mailto:ventas@almedis.cl">ventas@almedis.cl</a></p>
<?php } ?>

<?php if ($data['estatus'] == 'Pendiente de Pago') { ?>
<p>Su pedido nro: <?php echo $codigo; ?> tiene un nuevo estatus: <?php echo $data['estatus']; ?></p>
<p>Puede gestionar el pago de su pedido a través de la opción:</p>
<div style="margin:15px;text-align:center;">
    <a href="<?php echo home_url('/registrar-pago?pedido_id=') . $codigo; ?>" style="margin: 18px auto;max-width:200px;text-align:center;background-color:#009DF1;color:#FFF;padding:15px 25px;display: block;">Registrar Pago</a>
</div>
<br>
<p>Ante cualquier duda o consulta, nuestro sistema de atención al cliente está disponible para atenderle a través del mail: <a href="mailto:ventas@almedis.cl">ventas@almedis.cl</a></p>
<?php } ?>

<?php if ($data['estatus'] == 'Pago Confirmado') { ?>
<p>Su pedido nro: <?php echo $codigo; ?> tiene un nuevo estatus: <?php echo $data['estatus']; ?></p>
<p>Hemos recibido satisfactoriamente el pago efectuado para la gestión de su pedido. Puede dar seguimiento al mismo a través de la opción:</p>
<div style="margin:15px;text-align:center;">
    <a href="<?php echo home_url('/seguimiento'); ?>" style="margin: 18px auto;max-width:200px;text-align:center;background-color:#009DF1;color:#FFF;padding:15px 25px;display: block;">Seguimiento</a>
</div>
<br>
<p>Ante cualquier duda o consulta, nuestro sistema de atención al cliente está disponible para atenderle a través del mail: <a href="mailto:ventas@almedis.cl">ventas@almedis.cl</a></p>
<?php } ?>

<?php if ($data['estatus'] == 'En Tránsito') { ?>
<p>Su pedido nro: <?php echo $codigo; ?> tiene un nuevo estatus: <?php echo $data['estatus']; ?></p>
<p>Estamos trabajando en la importación de su pedido, lo que nos puede tomar de 8 a 11 días. El avance será reportado vía email y podrá seguir siendo monitoreado a través de la opción:</p>
<div style="margin:15px;text-align:center;">
    <a href="<?php echo home_url('/seguimiento'); ?>" style="margin: 18px auto;max-width:200px;text-align:center;background-color:#009DF1;color:#FFF;padding:15px 25px;display: block;">Seguimiento</a>
</div>
<br>
<p>Ante cualquier duda o consulta, nuestro sistema de atención al cliente está disponible para atenderle a través del mail: <a href="mailto:ventas@almedis.cl">ventas@almedis.cl</a></p>
<?php } ?>

<?php if ($data['estatus'] == 'Completada') { ?>
<p>Su pedido nro: <?php echo $codigo; ?> tiene un nuevo estatus: Producto Arribado a Chile</p>
<p>Estimado cliente, su pedido está en el país y estamos trabajando para hacer la entrega en la dirección indicada. Este proceso puede tomar de 2 a 3 días.</p>
<h2>INFORMACIÓN IMPORTANTE</h2>
<br>
<p>Para avanzar con el proceso de entrega, es necesario que gestione el pago restante a su pedido, Las opciones son las siguientes:</p>
<ol>
    <li> Convenios:<br>
        <ul>
            <li>Pago sólo con Bono pago total</li>
            <li>Pago con bono parcial más transferencia.</li>
            <li>Pago con bono parcial más Tarjetas (Vía Flow).</li>
        </ul>
    </li>
    <li>
        Persona Natural: <br>
        <ul>
            <li>Pago 50% restante con Transferencia</li>
            <li>Pago 50% restante con tarjetas (Vía Flow).</li>
        </ul>
    </li>
</ol>
<div style="margin:15px;text-align:center;">
    <a href="<?php echo home_url('/registrar-pago?pedido_id=') . $codigo; ?>" style="margin: 18px auto;max-width:200px;text-align:center;background-color:#009DF1;color:#FFF;padding:15px 25px;display: block;">Registrar Pago</a>
</div>
<p>Si ya ha pagado el total de su pedido, ignore este mensaje.</p>
<p>Ante cualquier duda o consulta, nuestro sistema de atención al cliente está disponible para atenderle a través del mail: <a href="mailto:ventas@almedis.cl">ventas@almedis.cl</a></p>
<?php } ?>

<?php if ($data['estatus'] == 'Cancelada') { ?>
<p>Estimado cliente, su pedido está en el país y pronto será entregado a la dirección indicada. Este proceso puede tomar de 2 a 3 días.</p>
<br>
<p>Si cree que ha sido un error, puede comunicarse con nuestro soporte de ventas al correo <a href="mailto:ventas@almedis.cl">ventas@almedis.cl</a></p>
<?php } ?>
<br>
<p>Gracias por usar ALMEDIS SpA.</p>
<br>
<br>
<?php
        $content = ob_get_clean();

        $this->almedis_send_notification($title, $title_long, $content, $email);
    }

    /**
     * Method almedis_send_notification
     *
     * @param $title $title [explicite description]
     * @param $title_long $title_long [explicite description]
     * @param $message $message [explicite description]
     *
     * @return void
     */
    public function almedis_send_notification($title, $title_long, $message, $email)
    {
        $logo = WP_PLUGIN_URL . '/almedis-forms/admin/img/logo.png';
        $body = '';
        $subject = $title;
        ob_start();
        require('partials/email-template.php');
        $body = ob_get_clean();
        $body = str_replace([
                '{title}',
                '{subject_long}',
                '{content}',
                '{logo}'
            ], [
                $title,
                $title_long,
                $message,
                $logo
            ], $body);


        $to = $email;
        $emailsCC = '';
        $emailsBCC = '';
                
        $headers[] = 'Content-Type: text/html; charset=UTF-8';
        $headers[] = 'From: ' . esc_html(get_bloginfo('name')) . ' <noreply@' . strtolower($_SERVER['SERVER_NAME']) . '>';
        $headers[] = 'Cc: ' . $emailsCC;
        $headers[] = 'Bcc: ' . $emailsBCC;

        $sent = wp_mail($to, $subject, $body, $headers);
        return $sent;
    }
}