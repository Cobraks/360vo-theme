<?php

/**
 * Front Page
 * @package 360vo-theme
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

get_header();

?>

<main id="main" class="main">
    <!-- Hero Section -->
    <section class="esc-hero">
        <div class="esc-hero__content">
            <?php
            // Solo la etiqueta <img>, sin el <a>
            $logo_id = get_theme_mod('custom_logo');
            if ($logo_id) {
                echo wp_get_attachment_image(
                    $logo_id,
                    'full',
                    false,
                    [
                        'class'    => 'custom-logo-front',
                        'decoding' => 'async',
                        'alt'      => get_bloginfo('name'),
                        'width'    => 400,
                        'height'   => 70,
                    ]
                );
            }
            ?>
            <h1 class="esc-hero__title">
                Tu concesionario en Madrid segunda mano. <span style="            display: none;
            opacity: 0;
            visibility: hidden;">Escarpa Motor</span>
            </h1>

            <p class=" esc-hero__description">
                En Escarpa Motor nos hemos consolidado como el concesionario en Madrid segunda mano de confianza para quienes <strong>buscan calidad</strong>, <strong>variedad</strong> y <strong>un excelente servicio</strong>. Sabemos que comprar un coche de segunda mano en Madrid no es una decisión que se toma a la ligera, y por eso ofrecemos una <strong>experiencia personalizada</strong> para ayudarte a encontrar el vehículo perfecto
            </p>

            <?php $coche_archive_link = get_post_type_archive_link('coche'); ?>
            <a href="<?php echo esc_url($coche_archive_link); ?>" class="esc-hero__cta" title="Stock de coches de Escarpa Motor" aria-label="Stock de coches de Escarpa Motor">Ver todos los coches</a>

        </div>
        <div class=" esc-hero__image">
                <img
                    src="https://www.escarpamotor.es/wp-content/themes/360vo-theme/public/assets/images/IMG_5553_2.webp"
                    alt="Vehículo de segunda mano en Escarpa Motor"
                    loading="lazy">
        </div>

        <div class="button_scroll_home">
            <button id="scrollButton">
                <span class="material-symbols-outlined">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="white">
                        <path d="M440-800v487L216-537l-56 57 320 320 320-320-56-57-224 224v-487h-80Z"></path>
                    </svg></span>
            </button>

        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const heroLogo = document.querySelector(".custom-logo-front");
            const headerLogo = document.querySelector(".custom-logo__image");
            const header = document.querySelector(".site-header");

            if (!heroLogo || !headerLogo) return;

            let clone = null;
            let hasMorphed = false;
            let isAnimating = false;

            function getWrapperPadding() {
                const val = getComputedStyle(document.documentElement).getPropertyValue('--wrapper-padding');
                return parseFloat(val || 0);
            }

            function morphLogo() {
                if (isAnimating || hasMorphed) return;

                const heroRect = heroLogo.getBoundingClientRect();
                const headerRect = headerLogo.getBoundingClientRect();

                clone = heroLogo.cloneNode(true);
                clone.style.position = 'fixed';
                clone.style.left = `${heroRect.left}px`;
                clone.style.top = `${heroRect.top}px`;
                clone.style.width = `${heroRect.width}px`;
                clone.style.height = `${heroRect.height}px`;
                clone.style.transition = 'all 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
                clone.style.zIndex = '9999';
                clone.style.pointerEvents = 'none';
                clone.style.opacity = '1';
                clone.style.transform = 'none';

                document.body.appendChild(clone);

                heroLogo.style.opacity = '0';
                // headerLogo.style.opacity = '0';
                isAnimating = true;

                void clone.offsetWidth; // trigger reflow

                clone.style.left = `${headerRect.left}px`;
                clone.style.top = `${headerRect.top}px`;
                clone.style.width = `${headerRect.width}px`;
                clone.style.height = `${headerRect.height}px`;
                clone.style.opacity = '0';
                clone.style.transform = 'scale(0.98)';

                setTimeout(() => {
                    headerLogo.style.opacity = '1';
                }, 150);

                setTimeout(() => {
                    if (clone) clone.remove();
                    isAnimating = false;
                    hasMorphed = true;
                }, 500);
            }

            function restoreLogo() {
                if (isAnimating || !hasMorphed) return;

                if (clone) {
                    clone.remove();
                    clone = null;
                }

                heroLogo.style.opacity = '1';
                headerLogo.style.opacity = '0';

                hasMorphed = false;
            }

            function checkPosition() {
                const heroRect = heroLogo.getBoundingClientRect();
                const headerRect = header.getBoundingClientRect();

                const heroTouchesHeader = heroRect.top <= headerRect.bottom;

                if (heroTouchesHeader) {
                    morphLogo();
                } else {
                    restoreLogo();
                }
            }

            window.addEventListener('scroll', checkPosition);
            window.addEventListener('resize', checkPosition);
            checkPosition();
        });
    </script>






    <style>
        :root {
            --color-primary: #1a73e8;
            --color-dark: #111;
            --color-light: #fff;
            --font-sans: 'Helvetica Neue', Arial, sans-serif;
        }

        /* Hero Styles */
        .esc-hero {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding-block: 2rem;
            padding-inline: var(--wrapper-padding);
            background: white;
            position: relative;
            padding-top: .5rem;
        }

        .esc-hero__content {
            animation: slide-up 0.8s ease-out;
        }

        .esc-hero__title {
            font-size: clamp(1.75rem, 5vw, 2.5rem);
            margin-bottom: 1rem;
            font-weight: 700;
            color: var(--primary15);
            font-weight: bold;
            text-wrap: balance;
            line-height: initial;
            font-size: 1.5rem;
            text-align: left;
        }

        .esc-hero__title span {
            display: none;
            opacity: 0;
            visibility: hidden;
        }

        .esc-hero__description {
            font-size: clamp(1rem, 2.5vw, 1.125rem);
            margin-bottom: 1.5rem;
            /* margin-inline: auto; */
            max-width: 40rem;

            font-size: .875rem;
            text-align: left;
        }

        .esc-hero__cta {
            display: inline-block;
            background-color: var(--color-primary);
            color: var(--color-light);
            text-decoration: none;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .esc-hero__cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(26, 115, 232, 0.3);
        }

        .esc-hero__image {
            margin-top: 2rem;
            width: 100%;
            max-width: 40rem;
            animation: fade-in 1s ease-in-out;
        }

        .esc-hero__image img {
            width: 100%;
            height: auto;
            display: block;
            border-radius: 0.75rem;
        }


        /* HEADER logo oculto inicialmente */
        body.home .site-header .custom-logo__image {
            opacity: 0;
            transition: opacity 0.5s ease;
            pointer-events: none;
        }

        /* HERO logo sin transición transform, solo para opacidad */
        body.home .custom-logo-front {
            transition: opacity 0.3s ease;
            will-change: opacity;
            z-index: 2;
            position: relative;

            max-width: 400px;
        }



        /* Responsive Layout */

        @media (min-width: 601px) {
            .esc-hero__title {
                font-size: 2rem;
            }

            .esc-hero__description {
                font-size: clamp(1rem, 2.5vw, 1.125rem);
            }
        }

        @media (min-width: 900px) {
            .esc-hero {
                flex-direction: row;
                text-align: left;
                justify-content: space-between;
                padding-block: 4rem;
                padding-top: 2rem;
            }

            .esc-hero__content,
            .esc-hero__image {
                flex: 1;
            }

            .esc-hero__content {
                max-width: 50%;
            }

            .esc-hero__image {
                margin-top: 0;
                max-width: 45%;
            }

            body.home .custom-logo-front {
                max-width: 390px;
            }

            .esc-hero__title {
                font-size: 2.25rem;
            }

            .esc-hero__description {
                font-size: .875rem;
            }
        }

        @media (min-width: 1024px) {
            .esc-hero__description {
                font-size: clamp(1rem, 2.5vw, 1.125rem);
            }

        }

        @media (min-width: 1360px) {
            .esc-hero {
                height: calc(100dvh - var(--altura-header));
            }
        }


        @media (min-width: 1600px) {
            .esc-hero__title {
                font-size: 4rem;
                margin-top: 1rem;
            }

            .esc-hero__description {
                max-width: 54rem;
                font-size: clamp(1rem, 2.5vw, 1.25rem);
            }

            body.home .custom-logo-front {
                max-width: 520px;
            }
        }

        /* Animations */
        @keyframes slide-up {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fade-in {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }
    </style>

    <?php
    // Loop principal de la página (ej. contenido de la home en el editor)
    if (have_posts()) :
        while (have_posts()) : the_post();
            the_content();
        endwhile;
    endif;
    ?>

    <!-- <div class="button_scroll_home">
        <button id="scrollButton">
            <span class="material-symbols-outlined">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="white">
                    <path d="M440-800v487L216-537l-56 57 320 320 320-320-56-57-224 224v-487h-80Z" />
                </svg>
            </span>
        </button>
    </div> -->


    <section class="recent-cars" aria-label="Vehículos recientemente añadidos">
        <div class="recent-cars__container">
            <!-- <h1 class="recent-cars__title">
                <span>Lucky Cars.</span><br>
                Coches de importación garantizados
            </h1>
            <p class="recent-cars__intro">
                Vehículos de importación con alta calidad, certificados, sin siniestros y 1 año de garantía.
                Entrega inmediata de segunda mano, seminuevos o a la carta, procedentes de los principales mercados europeos.
            </p> -->

            <div class="carousel">
                <button class="carousel__button carousel__button--prev" aria-label="Anterior">❮</button>
                <div class="carousel__track-container">
                    <div class="carousel__track">

                        <?php
                        // Loop personalizado para CPT "coche"
                        $args = array(
                            'post_type'      => 'coche',
                            'posts_per_page' => 8,
                            'post_status'    => 'publish',
                            'meta_query'     => array(
                                array(
                                    'key'     => 'visibilidad_del_vehiculo_estado_de_venta',
                                    'value'   => array('disponible', 'reservado', 'vendido_visible'),
                                    'compare' => 'IN',
                                ),
                            ),
                        );

                        $coche_query = new WP_Query($args);

                        if ($coche_query->have_posts()) :
                            while ($coche_query->have_posts()) : $coche_query->the_post();

                                // --- Imagen de portada ---
                                $imagen_field = get_field('otros_datos_portada_coche');
                                if ($imagen_field) {
                                    if (is_array($imagen_field)) {
                                        $imagen_url = $imagen_field['url'];
                                        $alt_text   = ! empty($imagen_field['alt']) ? $imagen_field['alt'] : get_the_title();
                                        $imagen     = '<img src="' . esc_url($imagen_url) . '" alt="' . esc_attr($alt_text) . '" class="car-card__image" loading="lazy">';
                                    } else {
                                        $imagen = wp_get_attachment_image($imagen_field, 'full', false, array(
                                            'class'   => 'car-card__image',
                                            'loading' => 'lazy',
                                            'alt'     => get_post_meta($imagen_field, '_wp_attachment_image_alt', true) ?: get_the_title(),
                                        ));
                                    }
                                } else {
                                    $color_scheme     = get_theme_mod('th360_color_scheme', 'azul');
                                    $default_image_url = GV360_PLUGIN_URL . 'public/assets/images/defaults/presentacion_'
                                        . ('rojo' === $color_scheme ? 'rojo' : 'azul')
                                        . '.png';
                                    $imagen = '<img src="' . esc_url($default_image_url) . '" alt="'
                                        . esc_attr(get_the_title()) . '" class="car-card__image" loading="lazy">';
                                }

                                // --- IVA deducible badge ---
                                $caracteristicas = get_field('grupo_caracteristicas_seleccionar_caracteristicas');
                                if (! is_array($caracteristicas)) {
                                    $caracteristicas = array();
                                }
                                $iva_deducible = in_array('iva_deducible', $caracteristicas, true);

                                // --- Marca y logo ---
                                $marcas = get_the_terms(get_the_ID(), 'marca');
                                if (! empty($marcas) && ! is_wp_error($marcas)) {
                                    $marca_term = array_shift($marcas);
                                    $make       = $marca_term->name;
                                    $logo_id    = get_field('logo_marca', $marca_term);
                                    $logo_url   = $logo_id ? wp_get_attachment_image_url($logo_id, 'full') : '';
                                } else {
                                    $make     = 'Sin marca';
                                    $logo_url = '';
                                }

                                // --- Modelo ---
                                $modelos = get_the_terms(get_the_ID(), 'modelo');
                                $model   = (! empty($modelos) && ! is_wp_error($modelos))
                                    ? array_shift($modelos)->name
                                    : '';

                                // --- Versión ---
                                $version = get_field('datos_generales_version');

                                // --- Specs: año, km, transmisión, combustible ---
                                $year  = get_field('datos_generales_ano');
                                $km    = get_field('especificaciones_tecnicas_kilometros');
                                $km    = $km ? number_format($km, 0, ',', '.') : '';
                                $trans = get_field('especificaciones_tecnicas_cambio');
                                $trans = is_array($trans) && isset($trans['label']) ? $trans['label'] : $trans;
                                $fuel  = get_field('especificaciones_tecnicas_combustible');
                                $fuel  = is_array($fuel) && isset($fuel['label']) ? $fuel['label'] : $fuel;

                                // --- Precios ---
                                $precio    = get_field('precio_y_descuentos_precio');
                                $precio    = $precio ? number_format($precio, 0, ',', '.') : '';
                                $desc_fin  = get_field('precio_y_descuentos_descuento_financiacion');
                                $financiado = ($desc_fin) ? number_format($precio - $desc_fin, 0, ',', '.') : $precio;
                                $cuota     = get_field('financiacion_cuota_minima');
                                $cuota     = $cuota ? number_format($cuota, 0, ',', '.') : '';
                        ?>

                                <article class="carousel__slide" itemscope itemtype="https://schema.org/Car">
                                    <div class="car-card">
                                        <div class="car-card__image-container">
                                            <?php echo $imagen; ?>
                                            <?php if ($iva_deducible) : ?>
                                                <div class="car-card__iva-overlay">IVA deducible</div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="car-card__content">
                                            <div class="car-card__header">
                                                <?php if ($logo_url) : ?>
                                                    <div class="car-card__logo-container">
                                                        <img src="<?php echo esc_url($logo_url); ?>"
                                                            alt="Logo <?php echo esc_attr($make); ?>"
                                                            class="car-card__logo">
                                                    </div>
                                                <?php endif; ?>
                                                <div class="car-card__model-info">
                                                    <div class="car-card__make"><?php echo esc_html("$make $model"); ?></div>
                                                    <div class="car-card__model-name"><?php echo esc_html($version); ?></div>
                                                </div>
                                            </div>
                                            <div class="car-card__specs">
                                                <?php if ($year) : ?>
                                                    <div class="spec-item"><i class="icon-calendar_today"></i><span><?php echo esc_html($year); ?></span></div>
                                                <?php endif; ?>
                                                <?php if ($km) : ?>
                                                    <div class="spec-item"><i class="icon-map"></i><span><?php echo esc_html($km); ?> km</span></div>
                                                <?php endif; ?>
                                                <?php if ($trans) : ?>
                                                    <div class="spec-item"><i class="icon-cambio"></i><span><?php echo esc_html($trans); ?></span></div>
                                                <?php endif; ?>
                                                <?php if ($fuel) : ?>
                                                    <div class="spec-item"><i class="icon-combustible"></i><span><?php echo esc_html($fuel); ?></span></div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="car-card__pricing">
                                                <?php if ($precio) : ?>
                                                    <div class="price__column price__cash">
                                                        <div class="price__label">Al contado</div>
                                                        <div class="price__value"><?php echo esc_html($precio); ?> €</div>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="price__column price__financed">
                                                    <?php if ($desc_fin) : ?>
                                                        <div class="price__label">Financiado: <?php echo esc_html($financiado); ?>€</div>
                                                        <?php if ($cuota) : ?>
                                                            <div class="price__monthly">Desde <?php echo esc_html($cuota); ?>/mes</div>
                                                        <?php endif; ?>
                                                    <?php else : ?>
                                                        <div class="price__label">Financiado</div>
                                                        <div class="price__value"><?php echo esc_html($financiado); ?>€</div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <a href="<?php echo esc_url(get_permalink()); ?>"
                                                class="car-card__cta">Ver detalles</a>
                                        </div>
                                    </div>
                                </article>

                        <?php
                            endwhile;
                            wp_reset_postdata(); // restaura $post global
                        endif;
                        ?>

                    </div>
                </div>
                <button class="carousel__button carousel__button--next" aria-label="Siguiente">❯</button>
            </div>

            <div class="recent-cars__cta" style="text-align: center;">
                <a href="<?php echo esc_url(get_post_type_archive_link('coche')); 
                            ?>" class="hero__cta cta-button">
                    Explorar todos los vehículos
                    <svg class="cta-icon" viewBox="0 0 24 24" width="20" height="20">
                        <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z" />
                    </svg>
                </a>
            </div>

        </div>
    </section>
</main>

<?php get_footer(); ?>