<?php
// classes/EnqueueScripts.php

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class E360VO_EnqueueScripts
{
    public function __construct()
    {

        add_action('wp_enqueue_scripts',   [$this, 'enqueue_scripts'], 100);
        add_action('wp_footer',            [$this, 'print_icons_media_script']);
    }


    /**
     * Encola hojas de estilo y scripts del tema.
     */
    public function enqueue_scripts()
    {
        // 1) Preconnect y preload de fuentes
        echo '<link rel="preconnect" href="' . esc_url(THEME_URI) . '/public/assets/fonts/">' . "\n";
        echo '<link rel="preload" href="' . esc_url(THEME_URI) . '/public/assets/fonts/icons_plantilla360vo.woff2" as="font" type="font/woff2" crossorigin>' . "\n";

        // 2) Critical CSS (carga lo primero)
        $min_critical = THEME_DIR . '/public/assets/css/critical.min.css';
        if (file_exists($min_critical)) {
            wp_enqueue_style(
                '360vo-critical',
                THEME_URI . '/public/assets/css/critical.min.css',
                [],                            // sin dependencias
                filemtime($min_critical),   // cache busting
                'all'
            );
        }

        // 3) Iconos
        $min_icons = THEME_DIR . '/public/assets/css/icons_plantilla360vo.min.css';
        wp_enqueue_style(
            'icons_plantilla360vo',
            THEME_URI . '/public/assets/css/icons_plantilla360vo.min.css',
            [],
            file_exists($min_icons) ? filemtime($min_icons) : THEME_VERSION,
            'all'
        );

        // 4) JS principal
        $min_js = THEME_DIR . '/public/assets/js/funciones_tema.min.js';
        wp_enqueue_script(
            'funciones_tema',
            THEME_URI . '/public/assets/js/funciones_tema.min.js',
            [],
            file_exists($min_js) ? filemtime($min_js) : THEME_VERSION,
            true
        );

       // 5) CSS global, dependiente de critical
        // $min_css = THEME_DIR . '/style.min.css';
        // wp_enqueue_style(
        //     '360vo-theme',
        //     THEME_URI . '/style.min.css',
        //     ['360vo-critical'],               // así garantizas que se cargue después
        //     file_exists($min_css)
        //         ? filemtime($min_css)
        //         : THEME_VERSION,
        //     'all'
        // );


        // // 5) CSS global cargado de forma async tras el critical
        $min_css_path = THEME_DIR . '/style.min.css';
        $min_css_uri  = THEME_URI  . '/style.min.css';

        if (file_exists($min_css_path)) {
            // 5.a) Preload + onload que convierte en stylesheet
            echo '<link rel="preload" as="style" href="' . esc_url($min_css_uri) .
                '" onload="this.onload=null;this.rel=\'stylesheet\'">' . "\n";

            // 5.b) Fallback para navegadores sin JS
            echo '<noscript><link rel="stylesheet" href="' . esc_url($min_css_uri) .
                '"></noscript>' . "\n";
        }


        // 6) Front page
        if (is_front_page()) {
            wp_enqueue_style(
                '360vo-home',
                THEME_URI . '/public/assets/css/front-page.css',
                [],
                THEME_VERSION,
                'all'
            );
            wp_enqueue_script(
                '360vo-home',
                THEME_URI . '/public/assets/js/front-page.js',
                [],
                THEME_VERSION,
                true
            );
        }

        // 7) 404
        if (is_404()) {
            wp_enqueue_style(
                'custom-404',
                THEME_URI . '/public/assets/css/custom-404.css',
                [],
                THEME_VERSION,
                'all'
            );
        }


        // 8) CSS exclusivo para páginas estáticas, posts y archivos de blog
        if (
            is_page()               // páginas estáticas
            || is_singular('post')  // entradas de blog individuales
            || is_home()            // índice de entradas (Blog home)
            || is_category()        // archivo de categoría
            || is_tag()             // archivo de etiqueta
            || is_author()          // archivo de autor
            || is_date()            // archivo por fecha
        ) {
            $handle   = '360vo-pages';
            $src_uri  = THEME_URI . '/public/assets/css/pages.min.css';
            $src_path = THEME_DIR . '/public/assets/css/pages.min.css';
            wp_enqueue_style(
                $handle,
                $src_uri,
                ['360vo-critical'],                                 // depende del CSS global
                file_exists($src_path) ? filemtime($src_path) : THEME_VERSION,
                'all'
            );
        }
    }


    /**
     * Imprime en el footer el script para ajustar media de iconos.
     */
    public function print_icons_media_script()
    {
?>
        <script>
            window.addEventListener('load', function() {
                var link = document.querySelector('link[href*="icons_plantilla360vo.css"]');
                if (link) {
                    link.media = 'all';
                }
            });
        </script>
<?php
    }
}
