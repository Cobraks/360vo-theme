<?php

/**
 * Mostrar migas de pan (Breadcrumbs)
 *
 * @package 360vo-theme
 */

 /*Mover a template parts*/

if (! defined('ABSPATH')) {
    exit;
}

function theme360_breadcrumbs()
{
    // No mostramos nada en la página de inicio
    if (is_front_page()) {
        return;
    }

    // Datos base
    $stock_name   = get_field('nombre_del_stock', 'option') ?: __('Vehículos', '360vo-theme');
    $archive_link = get_post_type_archive_link('coche');
    $home_url     = home_url();
    $position     = 1;

    // Atributos comunes para cada <li>
    $li_attr = ' itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"';

    // Closure para generar la etiqueta <meta> con la posición
    $position_meta = function () use (&$position) {
        return '<meta itemprop="position" content="' . $position++ . '">';
    };

    echo '<nav class="nav-breadcrumb" aria-label="Navegación de la página">';
    echo '<ol id="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">';

    // --- Home ---
    printf(
        '<li class="to-home"%1$s>' .
            '<a href="%2$s" itemprop="item">' .
            E360VO_Icon::get('home', [
                'class'       => 'bradcrumb__icon-home',
                'aria-hidden' => 'true',
            ]) .
            // '<i class="icon-home" aria-hidden="true"></i>' .
            '<span class="sr-only" itemprop="name">Home</span>' .
            '</a>%3$s' .
            '</li>',
        $li_attr,
        esc_url($home_url),
        $position_meta()
    );

    // --- Página de blog (índice de posts) ---
    if (is_home()) {
        printf(
            '<li%1$s><span itemprop="name">%2$s</span>%3$s</li>',
            $li_attr,
            __('Blog', '360vo-theme'),
            $position_meta()
        );

        // --- Entrada de CPT "coche" ---
    } elseif (is_singular('coche')) {
        // Enlace al archivo de "coche"
        printf(
            '<li%1$s><a href="%2$s" itemprop="item">' .
                '<span itemprop="name">%3$s</span>' .
                '</a>%4$s</li>',
            $li_attr,
            esc_url($archive_link),
            esc_html(ucfirst($stock_name)),
            $position_meta()
        );
        // Marca
        if ($terms = get_the_terms(get_the_ID(), 'marca')) {
            $marca = reset($terms);
            if (! is_wp_error($marca)) {
                printf(
                    '<li%1$s><a href="%2$s" itemprop="item">' .
                        '<span itemprop="name">%3$s</span>' .
                        '</a>%4$s</li>',
                    $li_attr,
                    esc_url(get_term_link($marca)),
                    esc_html($marca->name),
                    $position_meta()
                );
            }
        }
        // Modelo
        if ($terms = get_the_terms(get_the_ID(), 'modelo')) {
            $modelo = reset($terms);
            if (! is_wp_error($modelo)) {
                printf(
                    '<li%1$s><a href="%2$s" itemprop="item">' .
                        '<span itemprop="name">%3$s</span>' .
                        '</a>%4$s</li>',
                    $li_attr,
                    esc_url(get_term_link($modelo)),
                    esc_html($modelo->name),
                    $position_meta()
                );
            }
        }
        // Versión
        if ($version = get_field('datos_generales_version', get_the_ID())) {
            printf(
                '<li%1$s><span itemprop="name">%2$s</span>%3$s</li>',
                $li_attr,
                esc_html($version),
                $position_meta()
            );
        }

        // --- Entrada de blog estándar ---
    } elseif (is_single() && 'post' === get_post_type()) {
        $blog_id   = get_option('page_for_posts');
        $blog_link = $blog_id ? get_permalink($blog_id) : home_url('/blog/');
        // Enlace al blog
        printf(
            '<li%1$s><a href="%2$s" itemprop="item">' .
                '<span itemprop="name">%3$s</span>' .
                '</a>%4$s</li>',
            $li_attr,
            esc_url($blog_link),
            __('Blog', '360vo-theme'),
            $position_meta()
        );
        // Categoría
        if ($cats = get_the_category()) {
            $cat = reset($cats);
            printf(
                '<li%1$s><a href="%2$s" itemprop="item">' .
                    '<span itemprop="name">%3$s</span>' .
                    '</a>%4$s</li>',
                $li_attr,
                esc_url(get_category_link($cat->term_id)),
                esc_html($cat->name),
                $position_meta()
            );
        }
        // Título de la entrada
        printf(
            '<li%1$s><span itemprop="name">%2$s</span>%3$s</li>',
            $li_attr,
            get_the_title(),
            $position_meta()
        );

        // --- Página estática ---
    } elseif (is_page()) {
        $ancestors = get_post_ancestors(get_the_ID());
        if ($ancestors) {
            $ancestors = array_reverse($ancestors);
            foreach ($ancestors as $parent_id) {
                printf(
                    '<li%1$s><a href="%2$s" itemprop="item">' .
                        '<span itemprop="name">%3$s</span>' .
                        '</a>%4$s</li>',
                    $li_attr,
                    esc_url(get_permalink($parent_id)),
                    esc_html(get_the_title($parent_id)),
                    $position_meta()
                );
            }
        }
        // Página actual
        printf(
            '<li%1$s><span itemprop="name">%2$s</span>%3$s</li>',
            $li_attr,
            get_the_title(),
            $position_meta()
        );

        // --- Categoría de posts ---
    } elseif (is_category()) {
        $blog_id   = get_option('page_for_posts');
        $blog_link = $blog_id ? get_permalink($blog_id) : home_url('/blog/');
        printf(
            '<li%1$s><a href="%2$s" itemprop="item">' .
                '<span itemprop="name">%3$s</span>' .
                '</a>%4$s</li>',
            $li_attr,
            esc_url($blog_link),
            __('Blog', '360vo-theme'),
            $position_meta()
        );
        printf(
            '<li%1$s><span itemprop="name">%2$s</span>%3$s</li>',
            $li_attr,
            single_cat_title('', false),
            $position_meta()
        );

        // --- Etiqueta ---
    } elseif (is_tag()) {
        printf(
            '<li%1$s><span itemprop="name">%2$s</span>%3$s</li>',
            $li_attr,
            single_tag_title('', false),
            $position_meta()
        );

        // --- Taxonomías de "coche" (marca o carrocería) ---
    } elseif (is_tax(['marca', 'carroceria'])) {
        printf(
            '<li%1$s><a href="%2$s" itemprop="item">' .
                '<span itemprop="name">%3$s</span>' .
                '</a>%4$s</li>',
            $li_attr,
            esc_url($archive_link),
            esc_html(ucfirst($stock_name)),
            $position_meta()
        );
        printf(
            '<li%1$s><span itemprop="name">%2$s</span>%3$s</li>',
            $li_attr,
            single_term_title('', false),
            $position_meta()
        );

        // --- Taxonomía "modelo" (con padre marca) ---
    } elseif (is_tax('modelo')) {
        $term           = get_queried_object();
        $marca_parent   = get_field('marca_en_modelo', $term);
        if ($marca_parent) {
            $marca = get_term($marca_parent);
            printf(
                '<li%1$s><a href="%2$s" itemprop="item">' .
                    '<span itemprop="name">%3$s</span>' .
                    '</a>%4$s</li>',
                $li_attr,
                esc_url($archive_link),
                esc_html(ucfirst($stock_name)),
                $position_meta()
            );
            printf(
                '<li%1$s><a href="%2$s" itemprop="item">' .
                    '<span itemprop="name">%3$s</span>' .
                    '</a>%4$s</li>',
                $li_attr,
                esc_url(get_term_link($marca)),
                esc_html($marca->name),
                $position_meta()
            );
        }
        printf(
            '<li%1$s><span itemprop="name">%2$s</span>%3$s</li>',
            $li_attr,
            single_term_title('', false),
            $position_meta()
        );

        // --- Archivo CPT "coche" ---
    } elseif (is_post_type_archive('coche')) {
        printf(
            '<li%1$s><span itemprop="name">%2$s</span>%3$s</li>',
            $li_attr,
            esc_html(ucfirst($stock_name)),
            $position_meta()
        );

        // --- Otros archivos genéricos ---
    } elseif (is_archive()) {
        printf(
            '<li%1$s><span itemprop="name">%2$s</span>%3$s</li>',
            $li_attr,
            get_the_archive_title(),
            $position_meta()
        );
    } else {
        // Fallback: título de la página/entrada
        printf(
            '<li%1$s><span itemprop="name">%2$s</span>%3$s</li>',
            $li_attr,
            get_the_title(),
            $position_meta()
        );
    }

    echo '</ol>';

    // Botones de scroll (mantener tu marcado original)
    echo '<div class="btn-container btn-container--right">';
    echo    '<button class="breadcrumb-btn right-btn" aria-label="Desplazarse a la derecha">'. E360VO_Icon::get('foward_arrow'). '</button>';
    echo '</div>';
    echo '<div class="btn-container btn-container--left">';
    echo    '<button class="breadcrumb-btn left-btn" aria-label="Desplazarse a la izquierda">' . E360VO_Icon::get('back_arrow') .'</button>';
    echo '</div>';

    echo '</nav>';
}
