<?php
/*
Plugin Name: Botón flotante de WhatsApp
Plugin URI: http://asuagencia.com/plugins/
Description: Añade un botón flotante de WhatsApp personalizable en tu sitio web.
Version: 1.0
Author: Oscar Cantaro
Author URI: http://oscarcantaro.site
License: GPL2
*/

// Evitar acceso directo al archivo.
if (!defined('ABSPATH')) {
    exit;
}

// Encolar los scripts y estilos necesarios.
function wb_enqueue_scripts() {
    wp_enqueue_style('wb-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
    wp_enqueue_script('wb-script', plugin_dir_url(__FILE__) . 'assets/js/whatsapp-button.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'wb_enqueue_scripts');


// Genera el botón flotante
function wb_display_whatsapp_button() {
    $whatsapp_number = get_option('wb_whatsapp_number', '');
    $country_code = get_option('wb_country_code', '');
    $message = get_option('wb_message', '');
    $position = get_option('wb_position', 'right');

    if ($whatsapp_number && $country_code) {
        $full_number = $country_code . $whatsapp_number;
        $encoded_message = urlencode($message); // Codificar el mensaje para la URL
        echo '<a href="https://wa.me/'.$full_number.'?text='.$encoded_message.'" class="wb-whatsapp-button" target="_blank" style="position: fixed; bottom: 20px; '.$position.': 20px;">
            <img src="' . plugin_dir_url(__FILE__) . 'assets/img/whatsapp-icon.svg" alt="WhatsApp">
        </a>';
    }
}
add_action('wp_footer', 'wb_display_whatsapp_button');


// Añade la página de configuración al menú de WordPress.
function wb_create_menu() {
    add_options_page('WhatsApp Button Settings', 'WhatsApp Button', 'manage_options', 'wb-whatsapp-button', 'wb_settings_page');
}
add_action('admin_menu', 'wb_create_menu');

// Crea la página de configuración
function wb_settings_page() {
    $south_american_countries = array(
        '+54' => 'Argentina',
        '+591' => 'Bolivia',
        '+55' => 'Brasil',
        '+56' => 'Chile',
        '+57' => 'Colombia',
        '+593' => 'Ecuador',
        '+595' => 'Paraguay',
        '+51' => 'Perú',
        '+598' => 'Uruguay',
        '+58' => 'Venezuela'
    );
    ?>
    <div class="wrap">
        <h1>Configuración del botón de WhatsApp</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('wb-settings-group');
            do_settings_sections('wb-settings-group');
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Código del país:</th>
                    <td>
                        <select name="wb_country_code">
                            <?php foreach ($south_american_countries as $code => $country): ?>
                                <option value="<?php echo esc_attr($code); ?>" <?php selected(get_option('wb_country_code'), $code); ?>>
                                    <?php echo esc_html($country); ?> (<?php echo esc_html($code); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Número de WhatsApp:</th>
                    <td><input type="text" name="wb_whatsapp_number" value="<?php echo esc_attr(get_option('wb_whatsapp_number')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Mensaje inicial en el chat:</th>
                    <td><textarea name="wb_message" rows="4" cols="50"><?php echo esc_textarea(get_option('wb_message')); ?></textarea></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Posición del botón:</th>
                    <td>
                        <select name="wb_position">
                            <option value="right" <?php selected(get_option('wb_position'), 'right'); ?>>Abajo a la derecha</option>
                            <option value="left" <?php selected(get_option('wb_position'), 'left'); ?>>Abajo a la izquierda</option>
                        </select>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Registrar las configuraciones.
function wb_register_settings() {
    register_setting('wb-settings-group', 'wb_country_code');
    register_setting('wb-settings-group', 'wb_whatsapp_number');
    register_setting('wb-settings-group', 'wb_message');
    register_setting('wb-settings-group', 'wb_position');
}
add_action('admin_init', 'wb_register_settings');
