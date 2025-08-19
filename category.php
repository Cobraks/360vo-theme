<?php

/**
 * @package 360vo-theme
 * Category.php
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
get_header(); ?>

<main>
    <section>
        <div class="container">
            <?php
            if (have_posts()) :
                while (have_posts()) : the_post();
                    get_template_part('template-parts/content', get_post_type());
                endwhile;
            else :
                get_template_part('template-parts/content', 'none');
            endif;
            ?>
        </div>
    </section>
</main>








<?php get_footer(); ?>