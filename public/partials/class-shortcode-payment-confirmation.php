<?php
/**
 * Payment confirmation shortcode and callback
 *
 * @package    Almedis_Forms
 * @subpackage Almedis_Forms/admin
 * @author     IndexArt <indexart@gmail.com>
 */
class Almedis_Forms_Public_Payment_Confirmation
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
    * Add shortcode for payment confirmation
    *
    * @since   1.0.0
    * @param   void
    * @return  void
    */
    public function almedis_add_custom_shortcode()
    {
        add_shortcode('almedis-payment', array($this, 'almedis_forms_callback' ));
    }
    
    /**
    * Method almedis_forms_callback
    * Callback for shortcode almedis-payment
    *
    * @since    1.0.0
    * @param   $atts $atts [explicite description]
    * @param   $content $content [explicite description]
    * @return  $content
    */
    public function almedis_forms_callback($atts, $content = '')
    {
        ob_start();
        if (is_user_logged_in()) {
            ?>
<main class="almedis-payment-form-container">
    <form enctype="multipart/form-data" id="almedisPaymentForm" class="almedis-form-container">
        <div class="form-group">
            <label for="payment_pedido"><?php _e('Ingrese el código del pedido a pagar', 'almedis'); ?></label>
            <?php if (isset($_GET['pedido_id'])) {
                $value = $_GET['pedido_id'];
            } else {
                $value = '';
            } ?>
            <input id="payment_pedido" name="payment_pedido" class="form-control almedis-form-control" type="text" value="<?php echo $value; ?>" />
            <small class="form-helper danger hidden"><?php _e('Error: Este campo no puede estar vacio', 'almedis'); ?></small>
        </div>

        <div class="form-group">
            <label for="payment_cartapoder"><?php _e('¿Ya cargó su carta poder y carnet de identificación al sistema?', 'almedis'); ?></label>
            <div class="almedis-radio-wrapper">
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input almedis-form-control" type="radio" name="payment_cartapoder" value="<?php _e('si', 'almedis'); ?>"> <?php _e('Si', 'almedis'); ?>
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input almedis-form-control" type="radio" name="payment_cartapoder" value="<?php _e('no', 'almedis'); ?>"> <?php _e('No', 'almedis'); ?>
                    </label>
                </div>
            </div>
            <small class="form-helper danger hidden"><?php _e('Error: Debe seleccionar una de las opciones', 'almedis'); ?></small>
        </div>

        <div id="filesHandler" class="form-grouped-files hidden">
            <div id="cartaPoderFileWrapper" class="form-group form-files">
                <label for="payment_cartapoder_file" class="custom-file-upload">
                    <input id="payment_cartapoder_file" name="payment_cartapoder_file" type="file" />
                    Cargar Carta Poder
                </label>
                <small class="form-helper danger hidden"><?php _e('Error: Debe seleccionar una de las opciones', 'almedis'); ?></small>
                <div class="file-helper file-carta-helper hidden"><span class="almedis-file-icon"></span> <span id="fileSelected"></span></div>
                <small class="form-helper"><?php _e('Para poder procesar tu solicitud, debes enviar una carta poder que autorice el pedido, si no la tienes, puedes descargarla en la sección de recursos.')?></small>
            </div>
            <div id="carnetFileWrapper" class="form-group form-files">
                <label for="payment_carnet_file" class="custom-file-upload">
                    <input id="payment_carnet_file" name="payment_carnet_file" type="file" />
                    Cargar Carnet de Identificación
                </label>
                <small class="form-helper danger hidden"><?php _e('Error: Debe seleccionar una de las opciones', 'almedis'); ?></small>
                <div class="file-helper file-carnet-helper hidden"><span class="almedis-file-icon"></span> <span id="fileCarnetSelected"></span></div>
                <small class="form-helper"><?php _e('Para poder procesar tu solicitud, el ISP nos exige una copia de su Carnet de identidad por el lado de la foto y Poder Simple (No notarial) que puede descargarla desde aquí.')?></small>
            </div>
        </div>

        <div class="form-group">
            <p>Estimado Cliente, a continuación tiene 3 opciones de pasarelas disponibles para gestionar su pago:</p>
            <label for="payment_method"><?php _e('¿Qué método de pago quiere usar', 'almedis'); ?></label>
            <div class="almedis-radio-wrapper">
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input almedis-form-control" type="radio" name="payment_method" value="<?php _e('tarjeta', 'almedis'); ?>"> <?php _e('Pago con Tarjeta de Débito o Crédito FLOW', 'almedis'); ?>
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input almedis-form-control" type="radio" name="payment_method" value="<?php _e('copago', 'almedis'); ?>"> <?php _e('Bono', 'almedis'); ?>
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input almedis-form-control" type="radio" name="payment_method" value="<?php _e('transferencia', 'almedis'); ?>"> <?php _e('Transferencia Bancaria', 'almedis'); ?>
                    </label>
                </div>
            </div>
            <small class="form-helper danger hidden"><?php _e('Error: Debe seleccionar una de los métodos', 'almedis'); ?></small>
        </div>

        <div class="payment-info hidden" data-type="tarjeta">
            <div class="form-group">
                <h3>Pago con Tarjeta de Débito o Crédito FLOW</h3>
                <ul>
                    <li>Ingrese el monto a pagar en el formulario</li>
                    <li>Selecciones la opción Webpay</li>
                    <li>Ingrese su código de pédido en el campo *observaciones</li>
                </ul>
            </div>
        </div>

        <div class="payment-info hidden" data-type="copago">
            <div class="form-group">
                <h3>Pago con Bono Fonasa</h3>
                <ul>
                    <li>Cargue su bono</li>
                    <li>Ingrese su código de pedido</li>
                    <li>Ingrese el monto del bono</li>
                </ul>
            </div>
            <div class="form-group">
                <label for="copago_total"><?php _e('Monto total del bono', 'almedis'); ?></label>
                <input id="copago_total" name="copago_total" class="form-control almedis-form-control" type="text" />
                <small class="form-helper danger hidden"><?php _e('Error: Debe ingresar una cantidad', 'almedis'); ?></small>
            </div>
            <div id="copagoFileWrapper" class="form-group">
                <label for="copago_file" class="custom-file-full-upload">
                    <input id="copago_file" name="copago_file" type="file" />
                    <span id="copago_name">Subir Bono</span>
                    <span id="copago_file_selected"></span>
                </label>
                <small class="form-helper danger hidden"><?php _e('Error: Debe seleccionar el documento', 'almedis'); ?></small>
            </div>
        </div>

        <div class="payment-info hidden" data-type="transferencia">
            <div class="form-group">
                <h3>Pago por Transferencia Electrónica</h3>
                <ul>
                    <li>Cargue su comprobante de transferencia</li>
                    <li>Ingrese el código de su pedido</li>
                    <li>Ingrese el monto de su pago</li>
                </ul>
            </div>
            <div class="form-group">
                <label for="transferencia_total"><?php _e('Monto total de la transferencia', 'almedis'); ?></label>
                <input id="transferencia_total" name="transferencia_total" class="form-control almedis-form-control" type="text" />
                <small class="form-helper danger hidden"><?php _e('Error: Debe ingresar una cantidad', 'almedis'); ?></small>
            </div>
            <div id="transferenciaFileWrapper" class="form-group">
                <label for="transferencia_file" class="custom-file-full-upload">
                    <input id="transferencia_file" name="transferencia_file" type="file" />
                    <span id="transferencia_name">Subir comprobante</span>
                    <span id="transferencia_file_selected"></span>
                </label>
                <small class="form-helper danger hidden"><?php _e('Error: Debe seleccionar el documento', 'almedis'); ?></small>
            </div>
            <div class="image-group">
                <img src="<?php echo plugins_url('../img/logo-bancoestado.png', __FILE__) ?>" alt="BancoEstado" class="img-fluid" />
            </div>
            <div class="form-group">
                <div class="payment-data">
                    <h4>Datos para el pago</h4>
                    <h5>Banco Estado</h5>
                    <h5>Cuenta Vista</h5>
                    <h5>Nro: 291 70 78 54 85</h5>
                    <h5><a href="mailto:ventas@almedis.cl">ventas@almedis.cl</a></h5>
                </div>
            </div>
        </div>
        <div class="form-group additional-comments">
            <p>Puede gestionar su pago haciendo uso de las diferentes opciones disponibles, siempre y cuando ingrese el código único correspondiente a su pedido, el cual podrá encontrar en la parte superior derecha de su cotización y en su email de pedido.</p>
            <p>La confirmación de su pago será procesada vía email y su confirmación de recepción puede tomar de 24 a 48hrs.</p>
        </div>
        <div class="form-group submit-group">
            <button id="paymentSubmit" data-url="https://www.flow.cl/app/web/pagarBtnPago.php?token=ynqbndf" class="btn btn-md btn-cotizar"><span class="text-non-tarjeta"><?php _e('Confirmar Pago', 'almedis'); ?></span> <span class="text-tarjeta hidden">Pagar con Tarjeta en Flow</span></button>
            <div id="paymentResult"></div>
        </div>
    </form>
</main>
<?php
        } else {
            ?>
<main class="not-logged-container">
    <div class="not-logged-content">
        <h2><?php _e('Debes tener una cuenta y haber iniciado sesión para ingresar en esta zona', 'almedis'); ?></h2>
        <div class="not-logged-buttons">
            <a href="<?php echo home_url('/registro'); ?>" class="btn btn-registry"><?php _e('Crear cuenta', 'almedis')?></a>
            <a href="<?php echo home_url('/mi-cuenta'); ?>" class="btn btn-login"><?php _e('Iniciar Sesión', 'almedis')?></a>
        </div>
    </div>
</main>
<?php
        }
        $shortcode = ob_get_clean();
        return $shortcode;
    }
}