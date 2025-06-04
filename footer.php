<?php

/**
 * The template for displaying the footer
 *
 * @package Mon-Theme-ACA
 */

?>

<footer id="colophon" class="site-footer bg-dark text-secondary pt-5 pb-4">
    <div class="container">
        <div class="row mb-4">
            <!-- Section À Propos -->
            <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                <h5 class="text-light fw-semibold mb-3">À Propos de l'ACA</h5>
                <p class="small">
                    L'Association Africaine du Coton (ACA) œuvre pour le développement durable
                    et la promotion de la filière coton en Afrique.
                </p>
            </div>

            <!-- Section Liens Rapides -->
            <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                <h5 class="text-light fw-semibold mb-3">Liens Rapides</h5>
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'footer',
                        'menu_id'        => 'footer-quick-links',
                        'depth'          => 1,
                        'menu_class'     => 'list-unstyled small',
                        'link_class'     => 'text-secondary footer-link',
                        'container'      => false,
                    )
                );
                ?>
            </div>

            <!-- Section Contactez-nous -->
            <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                <h5 class="text-light fw-semibold mb-3">Contactez-nous</h5>
                <address class="small mb-0">
                    <p>123 Rue du Coton, Cotonou, Bénin</p>
                    <p>Email: <a href="mailto:info@aca-coton.org" class="text-secondary footer-link">info@aca-coton.org</a></p>
                    <p>Téléphone: <a href="tel:+22912345678" class="text-secondary footer-link">+229 12 34 56 78</a></p>
                </address>
            </div>

            <!-- Section Suivez-nous -->
            <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                <h5 class="text-light fw-semibold mb-3">Suivez-nous</h5>
                <div class="d-flex gap-3">
                    <!-- Icône Facebook -->
                    <a href="#" aria-label="Facebook" class="text-secondary footer-link">
                        <i class="bi bi-facebook fs-5"></i>
                    </a>
                    <!-- Icône Twitter -->
                    <a href="#" aria-label="Twitter" class="text-secondary footer-link">
                        <i class="bi bi-twitter-x fs-5"></i>
                    </a>
                    <!-- Icône LinkedIn -->
                    <a href="#" aria-label="LinkedIn" class="text-secondary footer-link">
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