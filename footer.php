<?php

/**
 * The template for displaying the footer
 *
 * @package Mon-Theme-ACA
 */

?>

<footer id="colophon" class="site-footer bg-dark text-secondary pt-5 pb-4 <?php echo get_theme_mod('footer_white_logo', false) ? 'white-logo' : ''; ?>">
    <div class="container">
        <div class="row mb-4">
            <!-- Section À Propos -->
            <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                <?php
                $footer_logo_id = get_theme_mod('footer_logo');
                if ($footer_logo_id) :
                ?>
                    <div class="footer-logo mb-3">
                        <?php echo wp_get_attachment_image($footer_logo_id, 'full', false, array(
                            'class' => 'footer-custom-logo',
                            'alt' => esc_attr(get_bloginfo('name'))
                        )); ?>
                    </div>
                <?php endif; ?>

                <h5 class="text-light fw-semibold mb-3"><?php echo esc_html(get_theme_mod('footer_about_title', esc_html__('À Propos de l\'ACA', 'mon-theme-aca'))); ?></h5>

                <p class="small">
                    <?php echo esc_html(get_theme_mod('footer_about_description', esc_html__('L\'Association Africaine du Coton (ACA) œuvre pour le développement durable et la promotion de la filière coton en Afrique.', 'mon-theme-aca'))); ?>
                </p>
            </div>

            <!-- Section Liens Rapides -->
            <div class="col-md-6 col-lg-3 mb-4 mb-lg-0 footer-quick-links">
                <?php
                // Get the selected menu ID from Customizer
                $footer_quick_links_menu_id = get_theme_mod('footer_quick_links_menu_id', 0);

                // Display the section only if a menu is selected
                if ($footer_quick_links_menu_id && $footer_quick_links_menu_id != 0) :
                ?>
                    <h5 class="text-light fw-semibold mb-3"><?php echo esc_html(get_theme_mod('footer_links_title', esc_html__('Liens Rapides', 'mon-theme-aca'))); ?></h5>
                    <?php
                    wp_nav_menu(
                        array(
                            'menu'           => $footer_quick_links_menu_id,
                            'menu_id'        => 'footer-quick-links',
                            'depth'          => 1,
                            'menu_class'     => 'list-unstyled small',
                            'link_class'     => 'text-secondary footer-link',
                            'container'      => false,
                            'fallback_cb'    => false, // Don't show fallback if menu doesn't exist
                        )
                    );
                    ?>
                <?php endif; ?>
            </div>

            <!-- Section Contactez-nous -->
            <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                <h5 class="text-light fw-semibold mb-3"><?php echo esc_html(get_theme_mod('footer_contact_title', esc_html__('Contactez-nous', 'mon-theme-aca'))); ?></h5>
                <address class="small mb-0">
                    <p><?php echo esc_html(get_theme_mod('footer_contact_address', esc_html__('123 Rue du Coton, Cotonou, Bénin', 'mon-theme-aca'))); ?></p>
                    <?php
                    $email = get_theme_mod('footer_contact_email', 'info@aca-coton.org');
                    $phone = get_theme_mod('footer_contact_phone', '+229 12 34 56 78');
                    ?>
                    <p>Email: <a href="mailto:<?php echo esc_attr($email); ?>" class="text-secondary footer-link"><?php echo esc_html($email); ?></a></p>
                    <p>Téléphone: <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>" class="text-secondary footer-link"><?php echo esc_html($phone); ?></a></p>
                </address>
            </div>

            <!-- Section Suivez-nous -->
            <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                <h5 class="text-light fw-semibold mb-3"><?php echo esc_html(get_theme_mod('footer_social_title', esc_html__('Suivez-nous', 'mon-theme-aca'))); ?></h5>
                <div class="d-flex gap-3">
                    <!-- Icône Facebook -->
                    <a href="<?php echo esc_url(get_theme_mod('footer_facebook_url', '#')); ?>" aria-label="Facebook" class="text-secondary footer-link">
                        <i class="bi bi-facebook fs-5"></i>
                    </a>
                    <!-- Icône Twitter -->
                    <a href="<?php echo esc_url(get_theme_mod('footer_twitter_url', '#')); ?>" aria-label="Twitter" class="text-secondary footer-link">
                        <i class="bi bi-twitter-x fs-5"></i>
                    </a>
                    <!-- Icône LinkedIn -->
                    <a href="<?php echo esc_url(get_theme_mod('footer_linkedin_url', '#')); ?>" aria-label="LinkedIn" class="text-secondary footer-link">
                        <i class="bi bi-linkedin fs-5"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Ligne de séparation -->
        <hr class="border-secondary my-4">

        <!-- Copyright -->
        <div class="text-center small">
            <?php
            /* translators: %1$s: Current year. %2$s: Blog name. */
            printf(esc_html__('© %1$s %2$s. Tous droits réservés.', 'mon-theme-aca'), date_i18n('Y'), get_bloginfo('name'));
            ?>
        </div>
    </div>
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>