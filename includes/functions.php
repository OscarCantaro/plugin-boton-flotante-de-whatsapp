<?php
// Evitar acceso directo al archivo
if (!defined('ABSPATH')) {
    exit;
}

// Función para agregar el botón flotante
function wsud_agregar_boton_whatsapp() {
    $opciones = get_option('whatsapp_button_sudamerica_options');
    $codigo_pais = isset($opciones['codigo_pais']) ? $opciones['codigo_pais'] : '';
    $numero_whatsapp = isset($opciones['numero_whatsapp']) ? $opciones['numero_whatsapp'] : '';
    $mensaje_predefinido = isset($opciones['mensaje_predefinido']) ? $opciones['mensaje_predefinido'] : '';
    $posicion = isset($opciones['posicion']) ? $opciones['posicion'] : 'abajo_derecha';

    $numero_completo = $codigo_pais . $numero_whatsapp;
    $url_whatsapp = 'https://wa.me/' . $numero_completo . '?text=' . urlencode($mensaje_predefinido);

    $clase_posicion = ($posicion == 'abajo_izquierda') ? 'wsud-left' : 'wsud-right';

    echo '<a href="' . esc_url($url_whatsapp) . '" target="_blank" id="wsud-whatsapp-button" class="wsud-float-button ' . $clase_posicion . '">
        <svg width="30" height="30" viewBox="0 0 24 24" fill="white" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 0C5.37 0 0 5.37 0 12C0 14.4 0.715 16.635 1.935 18.53L0.105 24L5.715 22.205C7.56 23.315 9.705 23.925 12 23.925C18.63 23.925 24 18.555 24 11.925C24 5.295 18.63 0 12 0ZM18.9 16.76C18.63 17.445 17.61 18.015 16.815 18.195C16.275 18.315 15.555 18.405 12.735 17.16C9.135 15.57 6.87 11.895 6.69 11.67C6.51 11.445 5.22 9.72 5.22 7.935C5.22 6.15 6.15 5.265 6.51 4.89C6.81 4.575 7.29 4.425 7.755 4.425C7.89 4.425 8.01 4.425 8.115 4.44C8.475 4.455 8.655 4.485 8.91 5.22C9.225 6.135 10.14 7.935 10.23 8.115C10.32 8.295 10.41 8.535 10.275 8.775C10.14 9.015 10.05 9.135 9.87 9.345C9.69 9.555 9.495 9.825 9.33 9.975C9.15 10.155 8.955 10.35 9.165 10.71C9.375 11.07 10.29 12.54 11.625 13.725C13.35 15.255 14.775 15.735 15.18 15.915C15.48 16.05 15.84 16.02 16.05 15.78C16.32 15.465 16.65 14.955 16.995 14.46C17.25 14.1 17.58 14.055 17.925 14.19C18.285 14.31 20.085 15.195 20.475 15.39C20.865 15.585 21.135 15.675 21.225 15.84C21.315 16.005 21.315 16.59 18.9 16.76Z"/>
        </svg>
    </a>';
}


// Función para mostrar la página de opciones
function wsud_mostrar_pagina_opciones() {
    $paises_sudamerica = array(
        '54' => 'Argentina',
        '591' => 'Bolivia',
        '55' => 'Brasil',
        '56' => 'Chile',
        '57' => 'Colombia',
        '593' => 'Ecuador',
        '594' => 'Guayana Francesa',
        '592' => 'Guyana',
        '595' => 'Paraguay',
        '51' => 'Perú',
        '597' => 'Surinam',
        '598' => 'Uruguay',
        '58' => 'Venezuela'
    );

    ?>
    <div class="wrap">
        <h1>Opciones del Botón de WhatsApp</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('whatsapp_button_sudamerica_options_group');
            $opciones = get_option('whatsapp_button_sudamerica_options');
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Selecciona el código del país</th>
                    <td>
                        <select name="whatsapp_button_sudamerica_options[codigo_pais]">
                            <?php foreach ($paises_sudamerica as $codigo => $pais) : ?>
                                <option value="<?php echo $codigo; ?>" <?php selected($opciones['codigo_pais'] ?? '', $codigo); ?>>
                                    <?php echo $pais . ' (+' . $codigo . ')'; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Ingrese el número de WhatsApp</th>
                    <td><input type="text" name="whatsapp_button_sudamerica_options[numero_whatsapp]" value="<?php echo esc_attr($opciones['numero_whatsapp'] ?? ''); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Defina el mensaje inicial</th>
                    <td><textarea name="whatsapp_button_sudamerica_options[mensaje_predefinido]" rows="3" cols="50"><?php echo esc_textarea($opciones['mensaje_predefinido'] ?? ''); ?></textarea></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Seleccione la posición del botón</th>
                    <td>
                        <select name="whatsapp_button_sudamerica_options[posicion]">
                            <option value="abajo_derecha" <?php selected($opciones['posicion'] ?? '', 'abajo_derecha'); ?>>Abajo Derecha</option>
                            <option value="abajo_izquierda" <?php selected($opciones['posicion'] ?? '', 'abajo_izquierda'); ?>>Abajo Izquierda</option>
                        </select>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
