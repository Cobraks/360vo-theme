<?php
/**
 * Variables globales: Datos de contacto, slug, etc.
 * QUITAR DE AQUÍ, PONER MEJOR EN EL PLUGIN
 *
 * @package 360vo-theme

 */

 if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

$telefono_principal = get_field('telefono-principal', 'option');


function obtener_valor_campo($nombre_campo) {
    return get_field($nombre_campo, 'option');
}

?>
<h1>VARIABLES GLOBALES</h1>

