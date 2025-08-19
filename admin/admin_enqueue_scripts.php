<?php
/**
 * Funciones para añadir las dependencias al panel de administración: Iconos, js, css y colores.
 *
 * @package 360vo-theme
 */

 if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function agregar_estilos_admin() {
        // Cargar archivo CSS de esquema de color
       /* $color_scheme = get_theme_mod('th360_color_scheme', 'azul');
        wp_enqueue_style('paleta_colores', get_template_directory_uri() . 'includes/assets/css/paleta_' . $color_scheme . '.css'); */
    wp_enqueue_style( 'icons_plantilla360vo', get_template_directory_uri() . '/public/assets/css/icons_plantilla360vo.css' );
    wp_enqueue_style( 'admin_styles', get_template_directory_uri() . '/admin/assets/css/admin_styles.css' );


}
add_action( 'admin_enqueue_scripts', 'agregar_estilos_admin' );

