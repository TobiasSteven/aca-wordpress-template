<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @package Mon-Theme-ACA
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <div class="content-area">
            <div class="error-404 not-found">
                <header class="page-header">
                    <h1 class="page-title"><?php esc_html_e('Oups! Cette page est introuvable.', 'mon-theme-aca'); ?></h1>
                </header><!-- .page-header -->

                <div class="page-content">
                    <p><?php esc_html_e('Il semble que rien n\'a été trouvé à cet endroit. Essayez peut-être une recherche?', 'mon-theme-aca'); ?></p>

                    <?php get_search_form(); ?>

                    <div class="error-suggestion">
                        <h2><?php esc_html_e('Articles récents', 'mon-theme-aca'); ?></h2>
                        <ul>
                            <?php
                            wp_get_archives(array(
                                'type'  => 'postbypost',
                                'limit' => 5,
                            ));
                            ?>
                        </ul>
                    </div>

                    <div class="error-categories">
                        <h2><?php esc_html_e('Catégories populaires', 'mon-theme-aca'); ?></h2>
                        <ul>
                            <?php
                            wp_list_categories(array(
                                'orderby'    => 'count',
                                'order'      => 'DESC',
                                'show_count' => 1,
                                'title_li'   => '',
                                'number'     => 5,
                            ));
                            ?>
                        </ul>
                    </div>
                </div><!-- .page-content -->
            </div>
        </div>
    </div>
</main><!-- #main -->

<?php
get_footer();
