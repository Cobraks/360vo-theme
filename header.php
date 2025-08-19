<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <?php
    //Variables header
    $email_principal = get_field('correo_y_telefono_correo_principal', 'option');
    $telefono_principal = get_field('correo_y_telefono_telefono_principal', 'option');
    if (is_tax('marca')) {
        $current_term_obj = get_queried_object();
        if ($current_term_obj) {
            $yoast_title = get_term_meta($current_term_obj->term_id, '_yoast_wpseo_title', true);
        }
    } ?>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
    <meta name="google-site-verification" content="bHqzDXo5rHTOkdNFprxwghH5vMoQJoBISsIMSWT4q0M" />
</head>

<body <?php body_class(); ?>>
    <div class="backdrop" style="display:none !important"></div>
    <?php
    // Lógica para determinar la clase del header según el logo
    $custom_logo_id = get_theme_mod('custom_logo');
    $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
    $logo_shape = get_theme_mod('th360_logo_shape', 'square');
    $header_logo_class = ' site-header--logo-' . $logo_shape;
    ?>
    <header class="site-header<?php echo esc_attr($header_logo_class); ?>">
        <?php
        echo '<!-- additional_header_class = ' . esc_html($header_logo_class) . ' -->';
        ?>
        <div class="wrapper-header">
            <button class="menu-button" title="Menú principal">
                <span class="menu-button-line"></span>
                <span class="menu-button-line"></span>
                <span class="menu-button-line"></span>
            </button>

            <div class="custom-logo">
                <?php
                if (has_custom_logo()) {
                    echo '<a href="' . esc_url(home_url('/')) . '"  class="custom-logo-link" rel="home"><img src="' . esc_url(rtrim($logo[0], '/')) . '" alt="' . get_bloginfo('name') . '"  width="400" height="70" class="custom-logo__image" decoding="async"></a>';
                } else {
                    echo '<p class="site-title">' . get_bloginfo('name') . '</p>';
                }
                ?>
            </div>


            <?php

            wp_nav_menu(
                array(
                    'theme_location' => 'primary',
                    'container'      => 'nav',
                    'container_class' => 'site-navigation',
                    'link_before'    => '<div class="item-navegacion__container"><span class="item-navegacion">',
                    'link_after'     => '</span></div>'
                )
            );

            ?>
            <div class="site-header__contact-buttons">
                <a class="site-header__contact-button site-header__contact-button--email" href="<?php echo esc_attr('mailto:' . $email_principal); ?>" aria-label="Enviar correo electrónico">
                    <span class="site-header__contact-button-icon site-header__contact-button-icon--email"><?php echo E360VO_Icon::get('email'); ?></span>
                    <span class="site-header__contact-button-text"><?php echo esc_html($email_principal); ?></span>
                </a>

                <a class="site-header__contact-button site-header__contact-button--phone" href="<?php echo esc_attr('tel:' . $telefono_principal); ?>" aria-label="Llamar a <?php echo esc_attr(get_bloginfo('name')); ?>">
                    <span class="site-header__contact-button-icon site-header__contact-button-icon--phone"><?php echo E360VO_Icon::get('call'); ?></span>
                    <span class="site-header__contact-button-text"><?php echo esc_html($telefono_principal); ?></span>
                </a>
            </div>

        </div>
    </header>


    <nav class="mobile-nav initially-hidden">
        <div class="mobile-nav-header wrapper-padding">
            <button class="close-button" title="Cerrar menú">
                <span class="close-button-line"></span>
                <span class="close-button-line"></span>
                <span class="close-button-line"></span>
            </button>
        </div>
        <div class="mobile-nav-content wrapper-padding">
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'items_wrap'     => '<ul>%3$s</ul>',

                )
            );
            ?>
        </div>
        <div class="mobile-nav-footer wrapper-padding">





            <?php
            $insta_user = get_field('social_insta', 'option');
            $face_user = get_field('social_face', 'option');
            $twitter_user = get_field('social_twitter', 'option');
            $youtube_user = get_field('social_youtube', 'option');
            $tiktok_user = get_field('social_tiktok', 'option');

            // Comprobamos si existe alguna red social
            $has_social = !empty($insta_user) || !empty($face_user) || !empty($twitter_user) || !empty($youtube_user) || !empty($tiktok_user) || have_rows('add_social', 'option');

            if ($has_social) {


            ?>


                <div class="mobile-nav-footer wrapper-padding">

                    <?php
                    $custom_logo_id = get_theme_mod('custom_logo');
                    $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                    if (has_custom_logo()) {
                        echo '<img src="' . esc_url(rtrim($logo[0], '/')) . '" alt="' . get_bloginfo('name') . '"  width="400" height="70" class="custom-logo" decoding="async">';
                    } else {
                        echo '<p class="site-title">' . get_bloginfo('name') . '</p>';
                    }
                    ?>

                    <ul class="footer__social__list">
                        <?php
                        if (!empty($insta_user)) {
                            echo '<li><a aria-label="Instagram" href="https://www.instagram.com/' . strtolower($insta_user) . '" target="_blank"><i class="icon-instagram"></i></a></li>';
                        }
                        if (!empty($face_user)) {
                            echo '<li><a aria-label="Facebook" href="https://www.facebook.com/' . strtolower($face_user) . '" target="_blank"><i class="icon-facebook"></i></a></li>';
                        }
                        if (!empty($twitter_user)) {
                            echo '<li><a aria-label="Twitter" href="https://www.twitter.com/' . strtolower($twitter_user) . '" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512">
            <path opacity="1" fill="#1E3050" d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"></path>
          </svg></a></li>';
                        }
                        if (!empty($youtube_user)) {
                            echo '<li><a aria-label="Youtube" href="https://www.youtube.com/' . strtolower($youtube_user) . '" target="_blank"> <svg aria-hidden="true" height="16" width="16" viewBox="0 0 18 18">
            <path d="M7.2,11.6V6.4L12,9.1L7.2,11.6z M17.8,5.3c0,0-0.2-1.2-0.7-1.8c-0.7-0.7-1.4-0.7-1.8-0.8C12.8,2.6,9,2.6,9,2.6s-3.8,0-6.3,0.2c-0.3,0-1.1,0-1.8,0.8C0.4,4.1,0.2,5.3,0.2,5.3S0,6.8,0,8.2v1.5c0,1.5,0.2,2.9,0.2,2.9s0.2,1.2,0.7,1.8c0.7,0.7,1.6,0.7,2,0.8c1.4,0.1,5.9,0.2,6.1,0.2c0,0,3.8,0,6.3-0.2c0.3,0,1.1,0,1.8-0.8c0.5-0.5,0.7-1.8,0.7-1.8S18,11.2,18,9.8V8.2C18,6.8,17.8,5.3,17.8,5.3z"></path>
          </svg></a></li>';
                        }
                        if (!empty($tiktok_user)) {
                            echo '<li><a aria-label="TikTok" href="https://www.tiktok.com/' . strtolower($tiktok_user) . '" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" width="20px" height="20px">
            <path d="M41,4H9C6.243,4,4,6.243,4,9v32c0,2.757,2.243,5,5,5h32c2.757,0,5-2.243,5-5V9C46,6.243,43.757,4,41,4z M37.006,22.323 c-0.227,0.021-0.457,0.035-0.69,0.035c-2.623,0-4.928-1.349-6.269-3.388c0,5.349,0,11.435,0,11.537c0,4.709-3.818,8.527-8.527,8.527 s-8.527-3.818-8.527-8.527s3.818-8.527,8.527-8.527c0.178,0,0.352,0.016,0.527,0.027v4.202c-0.175-0.021-0.347-0.053-0.527-0.053 c-2.404,0-4.352,1.948-4.352,4.352s1.948,4.352,4.352,4.352s4.527-1.894,4.527-4.298c0-0.095,0.042-19.594,0.042-19.594h4.016 c0.378,3.591,3.277,6.425,6.901,6.685V22.323z"></path>
          </svg></a></li>';
                        }

                        // Para las redes sociales adicionales
                        if (have_rows('social_add_social', 'option')) {
                            while (have_rows('social_add_social', 'option')) {
                                the_row();
                                $social_network_name = get_sub_field('nombre_rs');
                                $social_network_link = get_sub_field('link_red_social');
                                $social_network_icon = get_sub_field('icono_red_social');
                                if (!empty($social_network_icon)) {
                                    echo '<li><a href="' . $social_network_link . '"><img src="' . $social_network_icon . '" alt="' . $social_network_name . '" width="18" height="18"></a></li>';
                                } else {
                                    echo '<li><a href="' . $social_network_link . '">' . $social_network_name . '</a></li>';
                                }
                            }
                        }
                        ?>
                    </ul>
                </div>
            <?php
            }
            ?>

        </div>
    </nav>





    <?php get_template_part('includes/breadcrumbs');
    theme360_breadcrumbs();
    ?>