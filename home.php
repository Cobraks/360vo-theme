<?php

/**
 * @package 360vo-theme
 * home.php (blog)
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

get_header();
?>

<!-- Estilos en línea para pruebas (separar y encolar posteriormente) -->
<style>
    :root {
        --altura-loggin: calc(var(--altura-header) + var(--altura-breadcrumbs) + var(--altura-WpAdminBar));
        --altura: calc(var(--altura-header) + var(--altura-breadcrumbs));
    }

    main.main--blog {
        padding-top: var(--altura);
    }

    .logged-in main.main--blog {
        padding-top: var(--altura-loggin);
    }

    /* Encabezado del Blog */
    .blog-header {
        text-align: center;
        margin-bottom: 40px;
        padding: 20px;
        background-color: #f9f9f9;
    }

    .blog-header__title {
        font-size: 2.5rem;
        margin-bottom: 10px;
    }

    .blog-header__intro {
        font-size: 1.1rem;
        margin-bottom: 20px;
        color: #555;
    }

    .blog-header__categories-list {
        list-style: none;
        padding: 0;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        margin: 0;
    }

    .blog-header__categories-item {
        margin: 0 10px;
    }

    .blog-header__categories-link {
        text-decoration: none;
        color: #0073aa;
        font-size: 1rem;
    }

    .blog-header__categories-link:hover {
        text-decoration: underline;
    }

    /* Contenedor de 3 columnas */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        display: flex;
        flex-wrap: wrap;
    }

    .sidebar {
        flex: 0 0 20%;
        padding: 20px;
        box-sizing: border-box;
    }

    .content {
        flex: 0 0 60%;
        padding: 20px;
        box-sizing: border-box;
    }

    /* Listado de Posts */
    .blog__post {
        border-bottom: 1px solid #e1e1e1;
        padding-bottom: 20px;
        margin-bottom: 40px;
        overflow: auto;
    }

    .blog__post-header {
        margin-bottom: 15px;
        overflow: auto;
    }

    .blog__post-thumbnail {
        float: left;
        width: 30%;
        margin-right: 20px;
    }

    .blog__post-thumbnail img {
        width: 100%;
        height: auto;
    }

    .blog__post-title {
        font-size: 2rem;
        margin: 0 0 10px;
    }

    .blog__post-meta {
        font-size: 0.9rem;
        color: #777;
        margin-bottom: 10px;
    }

    .blog__post-content {
        font-size: 1rem;
        line-height: 1.5;
        color: #333;
    }

    .blog__read-more {
        display: inline-block;
        margin-top: 10px;
        color: #0073aa;
        text-decoration: none;
    }

    .blog__read-more:hover {
        text-decoration: underline;
    }

    /* Paginación */
    .pagination {
        margin-top: 20px;
        text-align: center;
        width: 100%;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .container {
            flex-direction: column;
        }

        .sidebar,
        .content {
            flex: 0 0 100%;
            padding: 10px;
        }

        .blog__post-thumbnail {
            float: none;
            width: 100%;
            margin: 0 0 10px;
        }
    }
</style>

<main class="main main--blog">
    <!-- Encabezado del Blog -->
    <header class="blog-header">
        <h1 class="blog-header__title">Bienvenido a Nuestro Blog</h1>
        <p class="blog-header__intro">Explora artículos, noticias y consejos sobre nuestros temas favoritos. ¡Disfruta y comparte!</p>
        <nav class="blog-header__categories">
            <ul class="blog-header__categories-list">
                <?php
                $categories = get_categories();
                foreach ($categories as $category) {
                    echo '<li class="blog-header__categories-item"><a class="blog-header__categories-link" href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>

    <div class="container">
        <!-- Primera Sidebar (Izquierda) -->
        <aside class="sidebar sidebar--left">
            <?php get_sidebar(); ?>
        </aside>

        <!-- Área principal de contenido -->
        <div class="content">
            <section class="blog">
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <article class="blog__post">
                            <header class="blog__post-header">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="blog__post-thumbnail">
                                        <?php the_post_thumbnail('full'); ?>
                                    </div>
                                <?php endif; ?>
                                <h2 class="blog__post-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                <div class="blog__post-meta">
                                    <span class="blog__post-date"><?php echo get_the_date(); ?></span>
                                    <span class="blog__post-author"><?php the_author(); ?></span>
                                    <span class="blog__post-categories"><?php the_category(', '); ?></span>
                                </div>
                            </header>
                            <div class="blog__post-content">
                                <?php the_excerpt(); ?>
                            </div>
                            <footer class="blog__post-footer">
                                <a class="blog__read-more" href="<?php the_permalink(); ?>">Leer más</a>
                            </footer>
                        </article>
                    <?php endwhile; ?>
                <?php else : ?>
                    <p>No hay publicaciones para mostrar.</p>
                <?php endif; ?>
            </section>

            <!-- Paginación -->
            <nav class="pagination">
                <?php
                the_posts_pagination(array(
                    'prev_text' => __('« Anterior'),
                    'next_text' => __('Siguiente »'),
                ));
                ?>
            </nav>
        </div>

        <!-- Segunda Sidebar (Derecha) -->
        <aside class="sidebar sidebar--right">
            <ul><li>Uno</li><li>dos</li></ul>
        </aside>
    </div>
</main>

<?php get_footer(); ?>