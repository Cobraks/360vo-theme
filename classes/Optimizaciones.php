<?php
// classes/Optimizaciones.php

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class E360VO_Optimizaciones
{

    public function __construct()
    {
        // Limpieza de cabeceras y assets
        add_action('init', [$this, 'optimize_head']);
        // Eliminar versión de WP
        add_filter('the_generator', [$this, 'remove_wp_version']);
        // Filtrar assets de FacetWP
        add_filter('facetwp_assets', [$this, 'filter_facetwp_assets']);


        // NUEVAS:
        add_action('init',                     [$this, 'disable_xmlrpc']);
        add_action('wp_head',                 [$this, 'remove_rest_api_links'], 0);
        add_action('wp_head',                 [$this, 'remove_adjacent_posts_links'], 1);
        add_action('wp_enqueue_scripts',      [$this, 'deregister_block_library_css'], 100);
        add_action('wp_footer',               [$this, 'deregister_wp_embed' ] );
    }

    /**
     * Quita scripts, estilos y enlaces innecesarios del head
     */
    public function optimize_head()
    {
        // Eliminar emojis
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_styles', 'print_emoji_styles');

        // Eliminar feeds RSS
        remove_action('wp_head', 'feed_links_extra', 3);
        remove_action('wp_head', 'feed_links', 2);

        // Eliminar wlwmanifest y RSD
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'rsd_link');

        // Eliminar shortlink
        remove_action('wp_head', 'wp_shortlink_wp_head');

        // Eliminar oEmbed discovery links y host JS
        remove_action('wp_head', 'wp_oembed_add_discovery_links');
        remove_action('wp_head', 'wp_oembed_add_host_js');

        // Filtrar estilos globales en CPT coche/marca/carroceria
        add_filter('print_styles_array', [$this, 'filter_print_styles_array']);
    }

    /**
     * Callback para filtrar el array de estilos
     */
    public function filter_print_styles_array($styles)
    {
        if (is_post_type_archive('coche') || is_tax(['marca', 'carroceria'])) {
            $key = array_search('global-styles', $styles, true);
            if (false !== $key) {
                unset($styles[$key]);
            }
        }
        return $styles;
    }

    /**
     * Elimina la versión de WordPress
     */
    public function remove_wp_version()
    {
        return '';
    }

    /**
     * Elimina el CSS frontal de FacetWP
     */
    public function filter_facetwp_assets($assets)
    {
        if (isset($assets['front.css'])) {
            unset($assets['front.css']);
        }
        return $assets;
    }




    /*Nuevas:*/
    /**
     * Desactiva XML-RPC completamente
     */
    public function disable_xmlrpc()
    {
        add_filter('xmlrpc_enabled', '__return_false');
    }

    /**
     * Elimina los enlaces del REST API del head
     */
    public function remove_rest_api_links()
    {
        remove_action('wp_head', 'rest_output_link_wp_head', 10);
        remove_action('template_redirect', 'rest_output_link_header', 11);
    }

    /**
     * Elimina los enlaces a posts adyacentes
     */
    public function remove_adjacent_posts_links()
    {
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
    }

    /**
     * Desregistrar la hoja de estilos de Gutenberg (bloques)
     */
    public function deregister_block_library_css()
    {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
    }

    /**
     * Desregistrar el script wp-embed.js
     */
    public function deregister_wp_embed()
    {
        wp_deregister_script('wp-embed');
    }
}


