<?php
// classes/ThemeSetup.php

if (! defined('ABSPATH')) {
    exit;
}

class E360VO_ThemeSetup
{

    public function __construct()
    {
        // Soportes básicos, logos, menús, tamaños, HTML5...
        add_action('after_setup_theme', [$this, 'theme_supports_and_menus']);

        // Rewrites de categorías
        add_action('init', [$this, 'custom_category_rewrites']);

        // Crear o ajustar Home al activar el tema
        add_action('after_switch_theme', [$this, 'create_default_home_page']);

        // Añadir clase current-menu-item personalizada
        add_filter('nav_menu_css_class', [$this, 'add_current_class_to_menu'], 10, 3);

        // Permitir SVG
        add_filter('upload_mimes', [$this, 'allow_svg_uploads']);

        // Capitalizar títulos de menú
        add_filter('wp_nav_menu_objects', [$this, 'capitalize_menu_titles'], 10, 2);

        // Eliminar base /category/
        add_filter('category_link', [$this, 'remove_category_base']);
    }

    public function theme_supports_and_menus()
    {
        // Soporte thumbnails, bloques, html5, título, yoast breadcrumbs...
        add_theme_support('post-thumbnails');
        add_theme_support('wp-block-styles');
        add_theme_support('html5', ['search-form', 'gallery', 'caption', 'script', 'style']);
        add_theme_support('title-tag');
        add_theme_support('yoast-seo-breadcrumbs');
        add_editor_style('style.css');

        // Logo
        add_theme_support('custom-logo', [
            'height'      => 68,
            'width'       => 400,
            'flex-height' => true,
            'flex-width'  => true,
        ]);

        // Tamaños de imagen
        add_image_size('custom-base',    400, 0, false);
        add_image_size('mid-430',        430, 0, false);
        add_image_size('mid-500',        500, 0, false);
        add_image_size('custom-grande',  650, 0, false);
        add_image_size('retina-base',    800, 0, false);
        add_image_size('retina-grande', 1300, 0, false);

        // Menús
        register_nav_menus([
            'primary'               => __('Menú header', '360vo-theme'),
            'terminos_condiciones'  => __('Privacidad / Cookies', '360vo-theme'),
            'footer'                => __('Menú footer', '360vo-theme'),
            'footer_menu_1'         => __('Footer 1', '360vo-theme'),
            'footer_menu_2'         => __('Footer 2', '360vo-theme'),
            'footer_menu_3'         => __('Footer 3', '360vo-theme'),
        ]);
    }

    public function custom_category_rewrites()
    {
        $page_for_posts = get_option('page_for_posts');
        $slug = $page_for_posts
            ? get_post_field('post_name', $page_for_posts)
            : 'blog';

        add_rewrite_rule(
            '^' . preg_quote($slug, '/') . '/([^/]+)/?$',
            'index.php?category_name=$matches[1]',
            'top'
        );
    }

    public function create_default_home_page()
    {
        if ('page' === get_option('show_on_front')) {
            return;
        }
        $home = get_page_by_path('home');
        if ($home) {
            update_post_meta($home->ID, '_wp_page_template', 'front-page.php');
            update_option('page_on_front', $home->ID);
            update_option('show_on_front', 'page');
            return;
        }
        $id = wp_insert_post([
            'post_title'    => 'Home',
            'post_name'     => 'home',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'page_template' => 'front-page.php',
        ]);
        if (! is_wp_error($id)) {
            update_option('page_on_front', $id);
            update_option('show_on_front', 'page');
        }
    }

    public function add_current_class_to_menu($classes, $item, $args)
    {
        if (! in_array($args->theme_location, ['primary', 'terminos_condiciones'], true)) {
            return $classes;
        }
        if (in_array('current-menu-item', $classes, true) || in_array('current_page_item', $classes, true)) {
            $classes[] = 'current-menu-item';
        }
        if (
            (is_tax(['marca', 'carroceria', 'modelo']) || is_singular('coche'))
            && in_array('menu-item-object-coche', $classes, true)
        ) {
            $classes[] = 'current-menu-item';
        }
        return $classes;
    }

    public function allow_svg_uploads($mimes)
    {
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    }

    public function capitalize_menu_titles($items, $args)
    {
        if (in_array($args->theme_location, ['primary', 'terminos_condiciones'], true)) {
            foreach ($items as $item) {
                $item->title = ucfirst($item->title);
            }
        }
        return $items;
    }

    public function remove_category_base($link)
    {
        return str_replace('/category/', '/', $link);
    }
}

// Instancia
//new E360VO_ThemeSetup();
