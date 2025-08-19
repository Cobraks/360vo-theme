<?php

/**
 * Funciones para 360vo-theme
 *
 *
 * @package 360vo-theme
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}



require_once get_template_directory() . '/classes/Autoloader.php';
E360VO_Autoloader::register();


// Al principio de functions.php, después de registrar el autoloader:
add_action('after_switch_theme', 'th360_generar_min_assets');
function th360_generar_min_assets()
{
    if (class_exists('E360VO_AssetMinifier')) {
        // suponiendo que ya hicisteis E360VO_AssetMinifier::register(...) en el functions.php
        E360VO_AssetMinifier::maybe_minify_all();
    }
}


/*Mover jQuery al footer para evitar bloqueo*/


add_action('wp_enqueue_scripts', 'mi_reemplazar_jquery_por_footer', 5);

function mi_reemplazar_jquery_por_footer()
{
    if (is_admin()) {
        return;
    }

    // 1) Desregistramos cualquier jQuery que ya esté registrado
    if (wp_script_is('jquery', 'registered')) {
        wp_deregister_script('jquery');
    }

    // 2) Lo volvemos a registrar para que cargue en el footer
    wp_register_script(
        'jquery',
        includes_url('/js/jquery/jquery.min.js'),
        [],       // dependencias
        null,     // versión
        true      // en footer
    );

    // 3) ¡Aquí es donde fallaba!: añadir defer
    wp_script_add_data('jquery', 'defer', true);

    // 4) Finalmente lo encolamos
    wp_enqueue_script('jquery');
}





//Agregar botón gestionar cookies
function agregar_item_gestionar_cookies($items, $args)
{
    if (isset($args->theme_location) && $args->theme_location === 'terminos_condiciones') {
        // Generamos un li con un botón
        $extra  = '<li class="menu-item menu-item-type-custom menu-item-object-custom">';
        $extra .= '<button type="button" class="cmplz-show-banner"><i class="fa fa-cookie"></i> Gestionar Cookies</button>';
        $extra .= '</li>';
        $items .= $extra;
    }
    return $items;
}
add_filter('wp_nav_menu_items', 'agregar_item_gestionar_cookies', 10, 2);


function cmplz_enqueue_inline_script()
{
    // Registrar y encolar un script vacío
    wp_register_script('cmplz-inline', '');
    wp_enqueue_script('cmplz-inline');

    $script = "
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('.cmplz-show-banner').forEach(function(element) {
        element.addEventListener('click', function(e) {
          e.preventDefault();
          document.querySelectorAll('.cmplz-manage-consent').forEach(function(btn) {
            btn.click();
          });
        });
      });
    });
    ";
    wp_add_inline_script('cmplz-inline', $script);
}
add_action('wp_enqueue_scripts', 'cmplz_enqueue_inline_script');



// Re-mostrar banner Complianz tras rechazo parcial, test 10s, persistente entre páginas
add_action('wp_footer', 'rv_complianz_reopen_banner', 1001);
function rv_complianz_reopen_banner()
{ ?>
    <script>
        (function() {
            var KEY = 'complianz_partial_reject';
            var DELAY = 10 * 1000; // 10 s para test (en prod 5*60*1000)

            // parsea cmplz_preferences JSON
            function getPrefs() {
                var m = document.cookie.match('(?:^|; )cmplz_preferences=([^;]+)');
                if (!m) return null;
                try {
                    return JSON.parse(decodeURIComponent(m[1]));
                } catch (e) {
                    return null;
                }
            }

            function hasAll() {
                var p = getPrefs();
                return p && p.statistics === '1' && p.marketing === '1';
            }

            function triggerBanner() {
                document.querySelectorAll('.cmplz-show-banner').forEach(function(btn) {
                    btn.click();
                });
            }

            document.addEventListener('DOMContentLoaded', function() {
                // 0) Si ya aceptó todo, limpiamos flag y salimos
                if (hasAll()) {
                    localStorage.removeItem(KEY);
                    return;
                }

                // 1) Si hay rechazo parcial pendiente...
                var ts = localStorage.getItem(KEY);
                if (ts) {
                    var age = Date.now() - parseInt(ts, 10);
                    if (age >= DELAY) {
                        triggerBanner(); // ya pasó el delay
                    } else {
                        setTimeout(triggerBanner, // espera el resto
                            DELAY - age);
                    }
                }

                // 2) Al click en “Guardar preferencias” o “Aceptar todas”
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.cmplz-save-preferences')) {
                        setTimeout(function() {
                            if (!hasAll()) {
                                localStorage.setItem(KEY, Date.now());
                            } else {
                                localStorage.removeItem(KEY);
                            }
                        }, 200);
                    }
                    if (e.target.closest('.cmplz-accept')) {
                        localStorage.removeItem(KEY);
                    }
                }, false);
            });
        })();
    </script>
<?php }















//add_action('wp_print_scripts', 'debug_list_scripts_styles', 999);
function debug_list_scripts_styles()
{
    global $wp_scripts, $wp_styles;
    echo '<pre style="background:#fff;color:#000;font-size:14px;">';
    echo "==== REGISTERED SCRIPTS ====\n";
    foreach ($wp_scripts->registered as $handle => $data) {
        echo $handle . ' -> ' . $data->src . "\n";
    }

    echo "\n==== ENQUEUED SCRIPTS (QUEUE) ====\n";
    foreach ($wp_scripts->queue as $handle) {
        echo $handle . "\n";
    }

    echo "\n==== REGISTERED STYLES ====\n";
    foreach ($wp_styles->registered as $handle => $data) {
        echo $handle . ' -> ' . $data->src . "\n";
    }

    echo "\n==== ENQUEUED STYLES (QUEUE) ====\n";
    foreach ($wp_styles->queue as $handle) {
        echo $handle . "\n";
    }
    echo '</pre>';
}

define('THEME_VERSION', '1.0.1');
define('THEME_DIR', get_template_directory());
define('THEME_URI', get_template_directory_uri());


// Función para generar las clases del contenedor de la entrada
function generar_clases_entry_container()
{
    $clases = ['entry__container'];

    if (get_field('cabecera_imagen_de_fondo')) {
        $imagen_diferente_id = get_field('cabecera_imagen_diferente');
        if ($imagen_diferente_id) {
            $background_image = wp_get_attachment_url($imagen_diferente_id);
        } elseif (has_post_thumbnail()) {
            $background_image = get_the_post_thumbnail_url();
        }

        if ($background_image) {
            $clases[] = 'entry__container--image-background';
        }
    }

    if (get_field('cabecera_hero_pantalla_completa')) {
        $clases[] = 'entry__container--full_screen';
    }

    if (get_field('cabecera_claramente_visible')) {
        $clases[] = 'entry__container--visible';
    }

    $color_hero = get_field('cabecera_color_hero');
    if ($color_hero) {
        $clases[] = 'entry__container--color-' . $color_hero;
    }

    $formato_imagen = get_field('imagen_destacada_formato_imagen');
    if ($formato_imagen) {
        $clases[] = 'entry__container--image-' . $formato_imagen;
    }

    return implode(' ', $clases);
}


// Función para obtener la URL de la imagen de fondo
function obtener_estilo_fondo()
{
    $background_image = '';

    if (get_field('cabecera_imagen_de_fondo')) {
        $imagen_diferente_id = get_field('cabecera_imagen_diferente');
        if ($imagen_diferente_id) {
            $background_image = wp_get_attachment_url($imagen_diferente_id);
        } elseif (has_post_thumbnail()) {
            $background_image = get_the_post_thumbnail_url();
        }

        if ($background_image) {
            return 'style="--background-image: url(' . esc_url($background_image) . ');"';
        }
    }

    return '';
}



// Función para calcular el tiempo de lectura aproximado
function calcular_tiempo_lectura($content)
{
    $words_per_minute = 200;
    $word_count = str_word_count(strip_tags($content));
    return ceil($word_count / $words_per_minute);
}

// Función para obtener el tiempo de lectura
// Función para obtener el tiempo de lectura
function obtener_tiempo_lectura($post_id)
{
    // Comprueba si debe mostrarse
    $opciones       = get_field('opciones_paginas', 'option');
    $mostrar_tiempo = $opciones['tiempo_estimado_lectura'] ?? false;

    if (! $mostrar_tiempo) {
        return '';
    }

    // Calcula los minutos
    $content        = get_post_field('post_content', $post_id);
    $tiempo_lectura = calcular_tiempo_lectura($content);

    // Si son 0 minutos, no devolvemos nada
    if ($tiempo_lectura <= 0) {
        return '';
    }

    // Si hay 1+ minutos, construimos el HTML
    return sprintf(
        '<div class="tiempo-lectura">%s minutos de lectura</div>',
        esc_html($tiempo_lectura)
    );
}

// 1) Arrancar el minificador
E360VO_AssetMinifier::init();

// 2) Registrar el style.css
E360VO_AssetMinifier::register(
    '360vo-theme-style',
    THEME_DIR . '/style.css',
    THEME_DIR . '/style.min.css',
    'css'
);

// 3) Registrar el JS principal del tema
E360VO_AssetMinifier::register(
    '360vo-funciones-tema',                                // handle
    THEME_DIR   . '/public/assets/js/funciones_tema.js',    // original
    THEME_DIR   . '/public/assets/js/funciones_tema.min.js', // minificado
    'js'                                                    // tipo
);




E360VO_AssetMinifier::register(
    'icons_plantilla360vo',                                      // handle
    THEME_DIR   . '/public/assets/css/icons_plantilla360vo.css',  // original
    THEME_DIR   . '/public/assets/css/icons_plantilla360vo.min.css', // minificado
    'css'                                                        // tipo
);

E360VO_AssetMinifier::register(
    '360vo-critical',
    THEME_DIR . '/public/assets/css/critical.css',
    THEME_DIR . '/public/assets/css/critical.min.css',
    'css'
);


E360VO_AssetMinifier::register(
    '360vo-pages',
    THEME_DIR . '/public/assets/css/pages.css',
    THEME_DIR . '/public/assets/css/pages.min.css',
    'css'
);



new E360VO_CustomLogin();
new E360VO_Customizer();



/* Quitar párrafos contact form */
add_filter('wpcf7_autop_or_not', '__return_false');


function get_latest_posts($num_posts = 5)
{
    $args = array(
        'numberposts' => $num_posts,
        'post_status' => 'publish'
    );

    return wp_get_recent_posts($args, OBJECT);
}



//Encolar scripts y estilos para el frontñend
new E360VO_EnqueueScripts();






/**
 * Añade defer a los scripts indicados
 */
add_filter('script_loader_tag', function ($tag, $handle) {
    // Lista de handles a los que queremos aplicar defer
    $defer_handles = [
        'funciones_tema',
        '360vo-home',      // si quieres deferir también tu front-page.js
        //  'jquery',       // si quisieras deferir jQuery (¡cuidado con dependencias!)
    ];

    if (in_array($handle, $defer_handles, true)) {
        // Inserta defer justo después de <script
        return str_replace('<script ', '<script defer ', $tag);
    }

    return $tag;
}, 10, 2);




// Quita el comentario de Yoast SEO en el <head>
add_filter('wpseo_debug_markers', '__return_false');






new E360VO_ThemeSetup();


new E360VO_ColorPalette();


//Encolar funciones, scripts y estilos para el admin panel
if (is_admin()) {
    require_once get_template_directory() . '/admin/admin_functions.php';
    require_once get_template_directory() . '/admin/admin_enqueue_scripts.php';
}


new E360VO_Optimizaciones();


// Carga la clase de avatar personalizado
require_once get_template_directory() . '/classes/UserAvatar.php';
new E360VO_UserAvatar();




/*Para quitar el img is sizes auto*/
add_action('init', function () {
    remove_action('wp_head', '_wp_add_sizes_placeholder_css', 1);
});








// Forzar a EWWW a usar binarios del sistema
// MOVER A CLASE
// REvisar, porque está también en wp-config
add_filter( 'ewww_use_server_binaries', '__return_true' );





