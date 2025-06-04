<?php

/**
 * The template for displaying the footer
 *
 * @package Mon-Theme-ACA
 */

?>

<footer id="colophon" class="site-footer">
    <div class="container">
        <div class="footer-widgets">
            <?php if (is_active_sidebar('footer-1')) : ?>
                <div class="footer-widget-area">
                    <?php dynamic_sidebar('footer-1'); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="site-info">
            <div class="footer-menu">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'footer',
                        'menu_id'        => 'footer-menu',
                        'depth'          => 1,
                    )
                );
                ?>
            </div>

            <div class="copyright">
                <?php
                /* translators: %1$s: Current year. %2$s: Blog name. */
                printf(esc_html__('© %1$s %2$s. Tous droits réservés.', 'mon-theme-aca'), date_i18n('Y'), get_bloginfo('name'));
                ?>
            </div>

            <div class="powered-by">
                <?php
                /* translators: %s: WordPress. */
                printf(esc_html__('Propulsé par %s', 'mon-theme-aca'), '<a href="https://wordpress.org/">WordPress</a>');
                ?>
            </div>
        </div><!-- .site-info -->
    </div>
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>