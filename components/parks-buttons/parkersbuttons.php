<?php
/*
Plugin Name: Parkers-TinyMCE-buttons
Author: Parker Westfall
Version: 2.0
*/

add_action('admin_head', 'chromapro_add_my_tc_button');

function chromapro_add_my_tc_button() {
    global $typenow;

    // Verificar si el usuario actual tiene permisos para editar posts o páginas
    if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
        return;
    }

    // Verificar si el tipo de post actual es 'post' o 'page'
    if (!in_array($typenow, ['post', 'page'])) {
        return;
    }

    // Añadir botones solo si el usuario tiene habilitada la edición rica
    if (get_user_option('rich_editing') == 'true') {
        add_filter('mce_external_plugins', 'chromapro_add_tinymce_plugin');
        add_filter('mce_buttons_3', 'chromapro_register_my_tc_button');
    }
}

function chromapro_add_tinymce_plugin($plugin_array) {
    // Añadir el script JS personalizado para los botones de TinyMCE
    $plugin_array['chromapro_tc_button'] = plugins_url('/parkersbutton.js', __FILE__);
    return $plugin_array;
}

function chromapro_register_my_tc_button($buttons) {
    // Registrar nuevos botones en la tercera fila de TinyMCE
    $new_buttons = ['coolquotes', 'dropcap', 'question', 'coolbutton', 'bubble', 'table', 'anchor', 'image-container', 'clear-html', 'gift-card', 'rating-card', 'add-unique-id', 'auto-correct'];
    return array_merge($buttons, $new_buttons);
}

add_action('admin_init', 'parks_editor_styles');

function parks_editor_styles() {
    // Añadir estilos personalizados para el editor
    add_editor_style(plugins_url('/parks-buttons.css', __FILE__));
    wp_enqueue_style('admin-css', plugins_url('/parks-buttons.css', __FILE__), array(), '1.0', false);
}

// Incluir código para remover algunos botones del editor TinyMCE
include(plugin_dir_path(__FILE__) . '/remove-buttons.php');

add_filter('acf/fields/wysiwyg/toolbars', 'chroma_toolbars');

function chroma_toolbars($toolbars) {
    // Verificar si la barra de herramientas 'full' existe para evitar errores
    if (!isset($toolbars['full'])) {
        return $toolbars;
    }

    // Agregar una nueva barra de herramientas con configuración personalizada
    $toolbars['Chroma Toolbar'] = array();
    $toolbars['Chroma Toolbar'][1] = $toolbars['full'][1];
    $toolbars['Chroma Toolbar'][2] = ['coolquotes', 'dropcap', 'question', 'coolbutton', 'bubble', 'table', 'anchor', 'image-container'];
    $toolbars['Chroma Toolbar'][3] = ['clear-html', 'gift-card', 'rating-card', 'add-unique-id', 'auto-correct'];

    return $toolbars;
}
