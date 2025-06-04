<?php

/**
 * The main template file
 *
 * @package Mon-Theme-ACA
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <div class="content-area">
            <div class="posts-container">
                <?php
                if (have_posts()) :

                    /* Start the Loop */
                    while (have_posts()) :
                        the_post();

                        /*
                         * Include the Post-Type-specific template for the content.
                         * If you want to override this in a child theme, then include a file
                         * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                         */
                        get_template_part('template-parts/content', get_post_type());

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
