<?php
/**
 * Plugin Name: Botón de WhatsApp
 * Plugin URI: http://oscarcantaro.site/plugins
 * Description: Añade un botón flotante de WhatsApp con opciones para países de Sudamérica y mensaje predefinido.
 * Version: 1.0
 * Author: Tu Nombre
 * Author URI: http://oscarcantaro.site
 * License: GPL2
 */

// Evitar acceso directo al archivo
if (!defined('ABSPATH')) {
    exit;
}


// Incluir archivo de funciones
require_once plugin_dir_path(__FILE__) . 'includes/functions.php';


// Agregar el botón al pie de página
add_action('wp_footer', 'wsud_agregar_boton_whatsapp');


// Registrar scripts y estilos
function wsud_enqueue_scripts() {
    wp_enqueue_style('wsud-styles', plugin_dir_url(__FILE__) . 'assets/css/style.css', array(), '1.0.0');
    wp_enqueue_script('wsud-script', plugin_dir_url(__FILE__) . 'assets/js/script.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'wsud_enqueue_scripts');


// Función para registrar las opciones del plugin
function wsud_registrar_opciones_plugin() {
    register_setting('whatsapp_button_sudamerica_options_group', 'whatsapp_button_sudamerica_options');
}
add_action('admin_init', 'wsud_registrar_opciones_plugin');


// Función para agregar el menú de opciones en el panel de administración
function wsud_agregar_menu_opciones() {
    add_options_page('Opciones Botón WhatsApp', 'Botón WhatsApp Sudamérica', 'manage_options', 'whatsapp-button-sudamerica', 'wsud_mostrar_pagina_opciones');
}
add_action('admin_menu', 'wsud_agregar_menu_opciones');
