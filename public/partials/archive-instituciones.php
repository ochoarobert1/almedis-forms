<?php echo get_header(); ?>
<?php if (!is_user_logged_in()) { ?>
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
            if (in_array('almedis_admin', (array) $user->roles)) {
                $instituto = get_user_meta($user->ID, 'almedis_client_instituto', true);
                if ($instituto != '') {
                    $instituto_url = get_permalink($instituto); ?>
                    <script type="text/javascript">
                        var redirectURL = '<?php echo $instituto_url; ?>';
                        window.location.replace(redirectURL);
                    </script>
                    <?php
                }
            }
        }?>
<?php echo get_footer(); ?>