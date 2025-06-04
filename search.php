<?php

/**
 * The template for displaying search results pages
 *
 * @package Mon-Theme-ACA
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <div class="content-area">
            <div class="posts-container">
                <?php if (have_posts()) : ?>

                    <header class="page-header">
                        <h1 class="page-title">
                            <?php
                            /* translators: %s: search query. */
                            printf(esc_html__('Résultats de recherche pour : %s', 'mon-theme-aca'), '<span>' . get_search_query() . '</span>');
                            ?>
                        </h1>
                    </header><!-- .page-header -->

                <?php
                    /* Start the Loop */
                    while (have_posts()) :
                        the_post();

                        /**
                         * Run the loop for the search to output the results.
                         * If you want to overload this in a child theme then include a file
                         * called content-search.php and that will be used instead.
                         */
                        get_template_part('template-parts/content', 'search');

                    endwhile;

                    the_posts_pagination(array(
                        'prev_text' => esc_html__('Précédent', 'mon-theme-aca'),
                        'next_text' => esc_html__('Suivant', 'mon-theme-aca'),
                    ));

                else :

                    get_template_part('template-parts/content', 'none');

                endif;
                ?>
            </div>

            <?php get_sidebar(); ?>
        </div>
    </div>
</main><!-- #main -->

<?php
get_footer();
