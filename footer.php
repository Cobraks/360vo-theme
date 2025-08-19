<?php

/**
 * @package 360vo-theme
 */
if (! defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}
















/*Hacer globales en clase separada*/
$email_principal = get_field('correo_y_telefono_correo_principal', 'option');
$telefono_principal = get_field('correo_y_telefono_telefono_principal', 'option');
$telefono_formateado = wordwrap(strrev((string)$telefono_principal), 3, ' ', true);
$telefono_formateado = strrev($telefono_formateado);


$mostrar_direccion = get_field('direccion_del_concesionario_mostrar_direccion', 'option');
$direccion = get_field('direccion_del_concesionario_direccion', 'option');
$codigo_postal = get_field('direccion_del_concesionario_codigo_postal', 'option');
$localidad = get_field('direccion_del_concesionario_localidad', 'option');
$provincia = get_field('direccion_del_concesionario_provincia', 'option');
$direccion = esc_html($direccion);
$codigo_postal = esc_html($codigo_postal);
$localidad = esc_html($localidad);
$provincia = esc_html($provincia);

$nombre_en_maps =
  get_field('direccion_del_concesionario_nombre_en_maps', 'option');
$nombre_en_maps =
  get_field('direccion_del_concesionario_nombre_en_maps', 'option');
$nombre_en_maps = esc_html($nombre_en_maps);

$direccion_completa = $nombre_en_maps . ', ' . $direccion . ', ' . $codigo_postal . ', ' . $localidad . ', ' . $provincia;

$tiene_kit = get_field('kit_digital_tiene_kit', 'option');
$fondo_kit = get_field('kit_digital_fondo_kit', 'option');
$clase_kit = '';
if ($fondo_kit == 'claro') {
  $clase_kit = 'claro';
} elseif ($fondo_kit == 'oscuro') {
  $clase_kit = 'oscuro';
} elseif ($fondo_kit == 'color_tema') {
  $clase_kit = 'color_tema';
}
/*Esto es lo que debería meter en un condicional, y que se carguene en una carpeta light,dark,color,etc:*/
$ruta_logos = get_template_directory_uri() . '/public/assets/images/patrocinadores/';
?>



<?php
// Obtén los valores de los campos personalizados
$horario = get_field('horario', 'option');
$conf_horario = $horario['conf_horario'];
$horario_alt = $conf_horario['horario_alt'];

if (!$horario_alt) {
  // Horario de lunes a viernes
  $lunes_a_viernes = $horario['lunes_a_viernes'];
  $horario_sabado = $horario['horario_sabado'];
  $horario_domingo = $horario['horario_domingo'];

  // Lunes a viernes
  $entrada_lun_vier = $lunes_a_viernes['entrada_lun_vier'];
  $salida_lun_vier = $lunes_a_viernes['salida_lun_vier'];
  $horario_tarde = $lunes_a_viernes['horario_tarde'];
  $entrada_lun_vier_tarde = $lunes_a_viernes['entrada_lun_vier_tarde'];
  $salida_lun_vier_tarde = $lunes_a_viernes['salida_lun_vier_tarde'];

  // Sábado
  $abierto_sabados = $horario_sabado['abierto_sabados'];
  $entrada_sab = $horario_sabado['entrada_sab'];
  $salida_sab = $horario_sabado['salida_sab'];
  $horario_tarde_sab = $horario_sabado['horario_tarde_sab'];
  $entrada_sab_tarde = $horario_sabado['entrada_sab_tarde'];
  $salida_sab_tarde = $horario_sabado['salida_sab_tarde'];

  // Domingo
  $abierto_domingos = $horario_domingo['abierto_domingos'];
  $entrada_dom = $horario_domingo['entrada_dom'];
  $salida_dom = $horario_domingo['salida_dom'];
  $horario_tarde_dom = $horario_domingo['horario_tarde_dom'];
  $entrada_dom_tarde = $horario_domingo['entrada_dom_tarde'];
  $salida_dom_tarde = $horario_domingo['salida_dom_tarde'];

  // Generar horarios

  // Lunes a viernes
  $lunes_viernes_horarios = "<strong>lunes a viernes:</strong> {$entrada_lun_vier} - {$salida_lun_vier}";
  if ($horario_tarde && !empty($entrada_lun_vier_tarde) && !empty($salida_lun_vier_tarde)) {
    $lunes_viernes_horarios .= " y {$entrada_lun_vier_tarde} - {$salida_lun_vier_tarde}";
  }

  // Sábado
  $sabado_horarios = "";
  if ($abierto_sabados) {
    $sabado_horarios = "<strong>sábado:</strong> {$entrada_sab} - {$salida_sab}";
    if ($horario_tarde_sab && !empty($entrada_sab_tarde) && !empty($salida_sab_tarde)) {
      $sabado_horarios .= " y {$entrada_sab_tarde} - {$salida_sab_tarde}";
    }
  } else {
    $sabado_horarios = "<strong>sábado:</strong> cerrado";
  }

  // Domingo
  $domingo_horarios = "";
  if ($abierto_domingos) {
    $domingo_horarios = "<strong>domingo:</strong> {$entrada_dom} - {$salida_dom}";
    if ($horario_tarde_dom && !empty($entrada_dom_tarde) && !empty($salida_dom_tarde)) {
      $domingo_horarios .= " y {$entrada_dom_tarde} - {$salida_dom_tarde}";
    }
  } else {
    $domingo_horarios = "<strong>domingo:</strong> cerrado";
  }

  // Unir horarios
  $horarios_array = array($lunes_viernes_horarios);
  if (!empty($sabado_horarios)) {
    array_push($horarios_array, $sabado_horarios);
  }
  if (!empty($domingo_horarios)) {
    array_push($horarios_array, $domingo_horarios);
  }

  $horario_comercio = '';
  foreach ($horarios_array as $horario_dia) {
    $horario_comercio .= '<p class="horario__dias">' . $horario_dia . '</p>';
  }
} else {
  // Horario alternativo (días y horas por separado)
  // Aquí puedes añadir el código para manejar el horario alternativo
}



//Social
$insta_user = get_field('social_insta', 'option');
$face_user = get_field('social_face', 'option');
$twitter_user = get_field('social_twitter', 'option');
$youtube_user = get_field('social_youtube', 'option');
$tiktok_user = get_field('social_tiktok', 'option');

//Comprobamos si existe alguna red social
$has_social = !empty($insta_user) || !empty($face_user) || !empty($twitter_user) || !empty($youtube_user) || !empty($tiktok_user) || have_rows('add_social', 'option');

// Obtener el grupo de opciones del footer
$opciones_footer = get_field('opciones_footer', 'option');
$mostrar_redes_sociales = $opciones_footer['redes_sociales'];

// Determinar qué bloque mostrar
$mostrar_bloque_social = $mostrar_redes_sociales && $has_social;

//Mapa
// Codifica la dirección para su uso en una URL
$direccion_codificada = urlencode($direccion_completa);

$api_key = 'AIzaSyCOQysJD3-wH0rrttGGc4OXXad1ZXCD0Vs';

// Construye la URL del mapa de Google Maps
$url_mapa = 'https://www.google.com/maps/embed/v1/place?key=' . $api_key . '&q=' . $direccion_codificada  . '&zoom=10';
?>


<div class="footer__claim-wrapper">
  <section class="footer__claim">
    <p class="footer__claim-text">
      <span class="footer__claim-text--hash highlight">#</span>
      <span class="footer__claim-text--word">
        <span class="footer__claim-text--letter">e</span>
        <span class="footer__claim-text--letter">l</span>
      </span>
      <span class="footer__claim-text--word highlight">
        <span class="footer__claim-text--letter">c</span>
        <span class="footer__claim-text--letter">o</span>
        <span class="footer__claim-text--letter">c</span>
        <span class="footer__claim-text--letter">h</span>
        <span class="footer__claim-text--letter">e</span>
      </span>
      <span class="footer__claim-text--word">
        <span class="footer__claim-text--letter">q</span>
        <span class="footer__claim-text--letter">u</span>
        <span class="footer__claim-text--letter">e</span>
      </span>
      <span class="footer__claim-text--word highlight">
        <span class="footer__claim-text--letter">d</span>
        <span class="footer__claim-text--letter">e</span>
        <span class="footer__claim-text--letter">s</span>
        <span class="footer__claim-text--letter">e</span>
        <span class="footer__claim-text--letter">a</span>
        <span class="footer__claim-text--letter">s</span>
      </span>
    </p>
  </section>
</div>





<script>
  document.addEventListener("DOMContentLoaded", function() {
    const claimTextWords = document.querySelectorAll(".footer__claim-text--word");
    let animationTimeout;
    let isAnimating = false;

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting && !isAnimating) {
          isAnimating = true;
          clearTimeout(animationTimeout);

          claimTextWords.forEach((word, wordIndex) => {
            setTimeout(() => {
              const letters = word.querySelectorAll('.footer__claim-text--letter');
              letters.forEach((letter, letterIndex) => {
                setTimeout(() => {
                  letter.classList.add("visible");
                }, letterIndex * 80);
              });
              word.classList.add("visible");
            }, wordIndex * 150);
          });

          // Permitir reiniciar la animación después de un tiempo
          animationTimeout = setTimeout(() => {
            isAnimating = false;
          }, 4000);

        } else if (!entry.isIntersecting) {
          isAnimating = false;
          clearTimeout(animationTimeout);

          claimTextWords.forEach((word) => {
            const letters = word.querySelectorAll('.footer__claim-text--letter');
            letters.forEach((letter) => {
              letter.classList.remove("visible");
            });
            word.classList.remove("visible");
          });
        }
      });
    }, {
      threshold: 0.5,
      rootMargin: "0px 0px -50px 0px"
    });

    observer.observe(document.querySelector(".footer__claim-text"));

  });
</script>


<button id="open-popup" class="boton-telefono" aria-label="Contacta con <?php echo esc_html(get_bloginfo('name')); ?>">
  <?php
  echo E360VO_Icon::get('contacto_centralita', [
    'aria-label'  => 'Contacta con nosotros',
    'width' => 72,
    'height' => 48,
  ]); ?>
</button>
<footer>

  <section class="footer-section <?php echo $mostrar_redes_sociales ? 'footer-section--has-social' : ''; ?>">

    <div class="footer-section__item footer-section__item--horario">
      <h3 class="footer-section__title">
        <?php echo E360VO_Icon::get('reloj'); ?>Horario</h3>
      <?php echo html_entity_decode($horario_comercio); ?>
    </div>

    <div class="footer-section__item footer-section__item--ubicacion">
      <h3 class="footer-section__title"><?php echo E360VO_Icon::get('location'); ?>Dónde estamos</h3>
      <?php
      if ($mostrar_direccion) {
        echo '<div class="footer-section__direccion">';
        echo '<address class="footer__direccion">';

        // Obtener el nombre del sitio web como nombre del negocio
        $nombre_negocio = get_bloginfo('name'); // Para WordPress
        // Si no usas WordPress, asigna directamente el nombre del sitio web:
        // $nombre_negocio = 'NextCar';

        // Añadir el nombre del negocio
        echo '<p><strong>' . htmlspecialchars($nombre_negocio) . '</strong></p>';

        // Mostrar la dirección en una línea separada
        echo '<p>' . htmlspecialchars($direccion) . '</p>';

        // Construir la línea de código postal y localidad
        $linea_cp_localidad = htmlspecialchars($codigo_postal) . ' ' . htmlspecialchars($localidad);

        // Añadir provincia solo si es diferente a la localidad
        if (!empty($provincia) && strtolower($localidad) !== strtolower($provincia)) {
          $linea_cp_localidad .= ', ' . htmlspecialchars($provincia);
        }

        // Mostrar código postal, localidad y provincia
        echo '<p>' . $linea_cp_localidad . '</p>';

        echo '</address>';
        echo '</div>';
      }
      ?>

    </div>


    <div class="footer-section__item footer-section__item--contacto">
      <h3 class="footer-section__title">
        <?php
        echo E360VO_Icon::get('contacto_centralita', [
          'width'  => 24,
          'height' => 24,
        ]); ?>
        Contacto
      </h3>
      <div class="button--footer-wrapper">
        <a class="button button--footer button--telefono" href="<?php echo esc_attr('tel:' . $telefono_principal); ?>" aria-label="Llamar a <?php echo esc_attr(get_bloginfo('name')); ?>"><span class="button--footer__icon"><?php echo E360VO_Icon::get('call'); ?></span><?php echo esc_html($telefono_formateado); ?></a>
        <a class="button button--footer button--correo" href="<?php echo esc_attr('mailto:' . $email_principal); ?>" aria-label="Enviar correo electrónico">
          <span class="button--footer__icon"><?php echo E360VO_Icon::get('email'); ?></span>
          <?php echo esc_html($email_principal); ?>
        </a>
        <a class="button button--footer button--whatsapp" href="https://wa.me/34<?php echo esc_attr($telefono_principal); ?>?text=<?php echo urlencode('Hola ' . get_bloginfo('name')); ?>" target="_blank" class="whatsapp-button" aria-label="Contacta con <?php echo esc_attr(get_bloginfo('name')); ?> a través de WhatsApp" title="Contacta con <?php echo esc_attr(get_bloginfo('name')); ?> a través de WhatsApp" itemprop="potentialAction" itemscope="" itemtype="http://schema.org/CommunicateAction"><span class="button--footer__icon">
            <?php echo E360VO_Icon::get('whatsapp'); ?></span>
          <span class="boton__flotante-whatsapp__texto">Envíanos un WhatsApp</span>
        </a>
      </div>
    </div>



    <?php if ($mostrar_redes_sociales && $has_social) { // Mostrar el bloque con estilo específico 
    ?>
      <div class="footer-section__item footer-section__item--social">
        <h3 class="footer-section__title">¡Síguenos!</h3>
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
            <path
              d="M7.2,11.6V6.4L12,9.1L7.2,11.6z M17.8,5.3c0,0-0.2-1.2-0.7-1.8c-0.7-0.7-1.4-0.7-1.8-0.8C12.8,2.6,9,2.6,9,2.6 s-3.8,0-6.3,0.2c-0.3,0-1.1,0-1.8,0.8C0.4,4.1,0.2,5.3,0.2,5.3S0,6.8,0,8.2v1.5c0,1.5,0.2,2.9,0.2,2.9s0.2,1.2,0.7,1.8 c0.7,0.7,1.6,0.7,2,0.8c1.4,0.1,5.9,0.2,6.1,0.2c0,0,3.8,0,6.3-0.2c0.3,0,1.1,0,1.8-0.8c0.5-0.5,0.7-1.8,0.7-1.8S18,11.2,18,9.8V8.2 C18,6.8,17.8,5.3,17.8,5.3z"></path>
          </svg>
        </a></li>';
          }
          if (!empty($tiktok_user)) {
            echo '<li><a aria-label="TikTok" href="https://www.tiktok.com/' . strtolower($tiktok_user) . '" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" width="20px" height="20px">
            <path d="M41,4H9C6.243,4,4,6.243,4,9v32c0,2.757,2.243,5,5,5h32c2.757,0,5-2.243,5-5V9C46,6.243,43.757,4,41,4z M37.006,22.323 c-0.227,0.021-0.457,0.035-0.69,0.035c-2.623,0-4.928-1.349-6.269-3.388c0,5.349,0,11.435,0,11.537c0,4.709-3.818,8.527-8.527,8.527 s-8.527-3.818-8.527-8.527s3.818-8.527,8.527-8.527c0.178,0,0.352,0.016,0.527,0.027v4.202c-0.175-0.021-0.347-0.053-0.527-0.053 c-2.404,0-4.352,1.948-4.352,4.352s1.948,4.352,4.352,4.352s4.527-1.894,4.527-4.298c0-0.095,0.042-19.594,0.042-19.594h4.016 c0.378,3.591,3.277,6.425,6.901,6.685V22.323z"></path>
          </svg>
          </a></li>';
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
    <?php } ?>



    <div class="footer-section__item footer-section__item--mapa">
      <div class="map-container">
        <div class="map-placeholder">
          <div class="spinner"></div>
        </div>
        <?php
        // Muestra el mapa en el pie de página
        echo '<iframe id="mapFrame" src="' . esc_url($url_mapa) . '" title="Localización de ' . esc_attr(get_bloginfo('name')) . '" width="400" height="300" frameBorder="0" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
        ?>
      </div>
    </div>








  </section>


  <div class="footer-contacto" style="display:none;">
    <div class="footer-contacto__botones-contacto">

      <a class="button button--footer button--telefono" href="<?php echo esc_attr('tel:' . $telefono_principal); ?>" aria-label="Llamar a <?php echo esc_attr(get_bloginfo('name')); ?>"><span class="icon-call"></span><?php echo esc_html($telefono_formateado); ?></a>
      <a class="button button--footer button--correo" href="<?php echo esc_attr('mailto:' . $email_principal); ?>" aria-label="Enviar correo electrónico">
        <span class="icon-email"></span>
        <?php echo esc_html($email_principal); ?>
      </a>
      <a class="button button--footer button--whatsapp" href="https://wa.me/34<?php echo esc_attr($telefono_principal); ?>?text=<?php echo urlencode('Hola ' . get_bloginfo('name')); ?>" target="_blank" class="whatsapp-button" aria-label="Contacta con <?php echo esc_attr(get_bloginfo('name')); ?> a través de WhatsApp" title="Contacta con <?php echo esc_attr(get_bloginfo('name')); ?> a través de WhatsApp" itemprop="potentialAction" itemscope="" itemtype="http://schema.org/CommunicateAction">
        <i class="icon-whatsapp"></i>
        <span class="boton__flotante-whatsapp__texto">Envíanos un WhatsApp</span>
      </a>



    </div>


    <?php
    $custom_logo_id = get_theme_mod('custom_logo');
    $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
    if (has_custom_logo()) {
      echo '<img src="' . esc_url(rtrim($logo[0], '/')) . '" alt="' . get_bloginfo('name') . '" itemprop="logo" width="200" height="70" class="footer-contacto__logo" decoding="async">';
    } else {
      echo '<p class="site-title">' . get_bloginfo('name') . '</p>';
    }  ?>



    <div class="footer-contacto__horario-direccion">
      <div class="footer-contacto__horario">
        <?php echo '<i class="icon-reloj"></i><div class="horario__dias-container">' . html_entity_decode($horario_comercio) . '</div>'; ?>
      </div>



      <?php
      if ($mostrar_direccion) {
        echo '<div class="footer-contacto__direccion">';

        // Muestra la dirección en el pie de página
        echo '<address class="footer__direccion">';
        echo '<p><i class="icon-map"></i>' . $direccion . ', ' . $codigo_postal . ', ' . $localidad . ', ' . $provincia . '</p>';
        echo '</address>';

        echo '</div>';
      } ?>
    </div>

    <div class="footer-contacto__map">
      <?php


      // Muestra el mapa en el pie de página
      echo '<iframe defer src="' . esc_url($url_mapa) . '" title="Localización de ' . esc_attr(get_bloginfo('name')) . '" width="400" height="300" frameBorder="0" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
      ?>
    </div>


  </div>















  <?php
  // Ubicaciones que quieres comprobar
  $menu_ids = array('footer_menu_1', 'footer_menu_2', 'footer_menu_3');

  // Obtenemos todas las localizaciones de menús registradas en el tema
  $locations = get_nav_menu_locations();

  // Variable para saber si hay al menos 1 menú con ítems
  $has_menu_items = false;

  // Recorremos cada ubicación de menú
  foreach ($menu_ids as $menu_id) {
    // Comprobamos si hay un menú asignado a esa ubicación
    if (! empty($locations[$menu_id])) {
      // Obtenemos el objeto del menú
      $menu_obj = wp_get_nav_menu_object($locations[$menu_id]);
      if ($menu_obj) {
        // Obtenemos los ítems (páginas/enlaces) de ese menú
        $menu_items = wp_get_nav_menu_items($menu_obj->term_id);
        // Si hay al menos un ítem en este menú, ya sabemos que hay contenido
        if (! empty($menu_items)) {
          $has_menu_items = true;
          break; // Con uno que tenga ítems, ya no hace falta seguir mirando
        }
      }
    }
  }

  // Si al menos uno de los menús tiene ítems, mostramos la sección
  if ($has_menu_items) :
  ?>
    <section class="footer__top">
      <nav class="footer__paginas">
        <div class="footer__paginas__container">
          <?php
          // Aquí volvemos a recorrer y mostramos los menús realmente
          foreach ($menu_ids as $menu_id) {
            if (! empty($locations[$menu_id])) {
              $menu_obj = wp_get_nav_menu_object($locations[$menu_id]);
              if ($menu_obj) {
                $menu_items = wp_get_nav_menu_items($menu_obj->term_id);
                // Solo imprimimos si tiene ítems
                if (! empty($menu_items)) {
                  echo '<div class="footer__paginas__menu">';
                  echo '<h4>' . esc_html($menu_obj->name) . '</h4>';
                  wp_nav_menu(array(
                    'theme_location' => $menu_id,
                    'menu_class'     => '',
                    'container'      => false,
                    'items_wrap'     => '<ul>%3$s</ul>',
                    // Importante para que no imprima menús "por defecto":
                    'fallback_cb'    => false,
                  ));
                  echo '</div>';
                }
              }
            }
          }
          ?>
        </div>
      </nav>
    </section>
  <?php endif; ?>




  <?php


  if ($tiene_kit) {
  ?>
    <section class="footer__middle <?php echo esc_attr($clase_kit); ?>"> <?php /* Hay que acceder al condicional para saber primero si es un tema claro u oscuro, y aplicarla una nueva clase*/ ?>
      <div class="footer__patrocinadores">
        <div class="patrocinadores__logos">
          <p>Programa Kit digital cofinanciado por los fondos Next Generation (EU) del Mecanismo de Recuperación y Resiliencia.</p>
          <ul>
            <li><img src="<?php echo esc_url($ruta_logos); ?>ue_color_azul.png" alt="Financiado por la Unión Europea" width="275" height="72" loading="lazy" /></li>
            <li><img src="<?php echo esc_url($ruta_logos); ?>kit_digital.png" alt="Kit Digital" width="262" height="72" loading="lazy" /></li>
            <li><img src="<?php echo esc_url($ruta_logos); ?>red.png" alt="Red" width="209" height="72" loading="lazy" /></li>
            <li><img src="<?php echo esc_url($ruta_logos); ?>ptr_color.png" alt="Plan de Recuperación, Transformación y Resiliencia" width="352" height="72" loading="lazy" /></li>
            <li><img src="<?php echo esc_url($ruta_logos); ?>gob_espana.png" alt="Gobierno de España" width="378" height="72" loading="lazy" /></li>
          </ul>
        </div>
      </div>
    </section>
  <?php
  }



  if (!$mostrar_redes_sociales && $has_social) {
    // Mostrar el bloque estándar 
  ?>
    <div class="footer__social">
      <!-- <div class="footer__social__logo">
          <?php /*
          $custom_logo_id = get_theme_mod('custom_logo');
          $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
          if (has_custom_logo()) {
            echo '<img src="' . esc_url(rtrim($logo[0], '/')) . '" alt="' . get_bloginfo('name') . '" itemprop="logo" width="200" height="70" class="custom-logo" decoding="async">';
          } else {
            echo '<p class="site-title">' . get_bloginfo('name') . '</p>';
          } */
          ?>

        </div> -->
      <p class="footer__social__title">Síguenos</p>
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
     
            <path
              d="M7.2,11.6V6.4L12,9.1L7.2,11.6z M17.8,5.3c0,0-0.2-1.2-0.7-1.8c-0.7-0.7-1.4-0.7-1.8-0.8C12.8,2.6,9,2.6,9,2.6 s-3.8,0-6.3,0.2c-0.3,0-1.1,0-1.8,0.8C0.4,4.1,0.2,5.3,0.2,5.3S0,6.8,0,8.2v1.5c0,1.5,0.2,2.9,0.2,2.9s0.2,1.2,0.7,1.8 c0.7,0.7,1.6,0.7,2,0.8c1.4,0.1,5.9,0.2,6.1,0.2c0,0,3.8,0,6.3-0.2c0.3,0,1.1,0,1.8-0.8c0.5-0.5,0.7-1.8,0.7-1.8S18,11.2,18,9.8V8.2 C18,6.8,17.8,5.3,17.8,5.3z"></path>
     
          </svg>
        </a></li>';
        }
        if (!empty($tiktok_user)) {
          echo '<li><a aria-label="TikTok" href="https://www.tiktok.com/' . strtolower($tiktok_user) . '" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" width="20px" height="20px">
            <path d="M41,4H9C6.243,4,4,6.243,4,9v32c0,2.757,2.243,5,5,5h32c2.757,0,5-2.243,5-5V9C46,6.243,43.757,4,41,4z M37.006,22.323 c-0.227,0.021-0.457,0.035-0.69,0.035c-2.623,0-4.928-1.349-6.269-3.388c0,5.349,0,11.435,0,11.537c0,4.709-3.818,8.527-8.527,8.527 s-8.527-3.818-8.527-8.527s3.818-8.527,8.527-8.527c0.178,0,0.352,0.016,0.527,0.027v4.202c-0.175-0.021-0.347-0.053-0.527-0.053 c-2.404,0-4.352,1.948-4.352,4.352s1.948,4.352,4.352,4.352s4.527-1.894,4.527-4.298c0-0.095,0.042-19.594,0.042-19.594h4.016 c0.378,3.591,3.277,6.425,6.901,6.685V22.323z"></path>
          </svg>
          </a></li>';
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
        /*
          <li><a data-analytics="{
                    &quot;category&quot;: &quot;social&quot;,
                    &quot;action&quot;: &quot;follow - footer&quot;,
                    &quot;label&quot;: &quot;Instagram&quot;,
                    &quot;pagePath&quot;: &quot;https://www.instagram.com/google/&quot;
                  }" aria-label="Instagram" href="https://www.instagram.com/google/" target="_blank">
                  <svg aria-hidden="true" class="h-c-icon h-c-icon--24px h-c-icon--social" viewBox="0 0 18 18">
                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/static/blogv2/images/icons.svg#social-instagram"></use>
                  </svg>
                </a></li> 
                Investigar data-analytics y cómo mandarlo a Tag Manager y Google Analytics.
                */ ?>
      </ul>

    </div>



  <?php } ?>



  <section class="footer__bottom">


    <?php
    $menu_name = 'terminos_condiciones';
    if (has_nav_menu($menu_name)) {
      $locations = get_nav_menu_locations();
      $menu = wp_get_nav_menu_object($locations[$menu_name]);
      $menu_items = wp_get_nav_menu_items($menu->term_id);
      if ($menu_items) {
    ?><div class="footer__legal"><?php
                                  wp_nav_menu(array(
                                    'theme_location' => $menu_name,
                                    'container_class' => 'custom-menu-class'
                                  ));
                                  ?></div><?php
                                        }
                                      } else {
                                        if (is_user_logged_in()) {
                                          ?>
        <button style="width:100%;margin-bottom:1.4rem" onclick="window.location.href='<?php echo admin_url('nav-menus.php'); ?>'">Crear menú política de privacidad, cookies y aviso legal</button>
    <?php
                                        } else {
                                          // No hay menú y no está logueado: simplemente no se muestra nada.
                                          // Eliminamos el 'return;' para que el footer continúe renderizándose.
                                        }
                                      }
    ?>


    <div class="footer__copyright">
      <p>
        &copy; <?php echo esc_html(date_i18n(__('Y', 'text-domain'))); ?> <?php echo '<b>' . esc_html(get_bloginfo('name')) . '</b>' ?>
      </p>


      <p class="footer__copyright-developer">Desarrollado por <a href="https://www.360vo.es" target="_blank">360vo</a></p>
    </div>
  </section>
  <div id="popup" class="popup" style="display: none;">
    <div class="popup-content--whatsapp">
      <span id="close-popup" class="close">×</span>
      <h3>¿Estás buscando un coche?</h3>
      <a class="whatsapp-popup" href="https://wa.me/34<?php echo esc_attr($telefono_principal); ?>?text=<?php echo urlencode('Estoy buscando un coche en ' . get_bloginfo('name')); ?>">

        <?php echo E360VO_Icon::get('whatsapp'); ?>
        <span class="phone-contact">Mándanos un WhatsApp</span>

      </a>
      <p>O llámanos por teléfono:</p>
      <a class="whatsapp-popup call-popup" href="<?php echo esc_attr('tel:' . $telefono_principal);
                                                  ?>">

        <?php echo E360VO_Icon::get('call'); ?>
        <span class="phone-contact"><?php echo esc_html($telefono_formateado);
                                    ?></span>

      </a>
    </div>
  </div>
</footer>
<?php wp_footer(); ?>








</body>

</html>