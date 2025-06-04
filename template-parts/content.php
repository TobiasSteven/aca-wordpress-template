<?php

/**
 * Template part for displaying posts
 *
 * @package Mon-Theme-ACA
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php
        if (is_singular()) :
            the_title('<h1 class="entry-title">', '</h1>');
        else :
            the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
        endif;

        if ('post' === get_post_type()) :
        ?>
            <div class="entry-meta">
                <?php
                mon_theme_aca_posted_on();
                mon_theme_aca_posted_by();
                ?>
            </div><!-- .entry-meta -->
        <?php endif; ?>
    </header><!-- .entry-header -->

    <?php mon_theme_aca_post_thumbnail(); ?>

    <div class="entry-content">
        <?php
        if (is_singular()) :
            the_content(
                sprintf(
                    wp_kses(
                        /* translators: %s: Name of current post. Only visible to screen readers */
                        __('Continuer la lecture<span class="screen-reader-text"> "%s"</span>', 'mon-theme-aca'),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    wp_kses_post(get_the_title())
                )
            );

            wp_link_pages(
                array(
                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'mon-theme-aca'),
                    'after'  => '</div>',
                )
            );
        else :
            the_excerpt();
        ?>
            <a href="<?php echo esc_url(get_permalink()); ?>" class="read-more">
                <?php esc_html_e('Lire la suite', 'mon-theme-aca'); ?>
            </a>
        <?php
        endif;
        ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php mon_theme_aca_entry_footer(); ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->