<?php

/**
 * The header for our theme
 *
 * @package Mon-Theme-ACA
 */
?>
<!DOCTYPE html>
<html lang="fr" <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right');
            bloginfo('name'); ?></title>
    <!-- Inclusion de Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <?php wp_head(); ?>
</head>

<body <?php body_class('bg-[#F8F9FA]'); ?>>
    <?php wp_body_open(); ?>
    <div id="page" class="site">
        <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Aller au contenu', 'mon-theme-aca'); ?></a>
        <!-- Barre de navigation -->
        <nav class="bg-white shadow-md">
            <div class="container mx-auto px-6 py-3 flex items-center justify-between">
                <!-- Section Logo -->
                <div class="flex items-center">
                    <?php echo mon_theme_aca_get_custom_logo(); ?>
                </div>
                <!-- Liens de navigation - Centre -->
                <div class="hidden md:flex items-center space-x-6">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'primary',
                            'menu_id'        => 'primary-menu',
                            'container'      => false,
                            'menu_class'     => 'flex items-center space-x-6',
                            'fallback_cb'    => false,
                            'items_wrap'     => '%3$s',
                            'walker'         => new Mon_Theme_ACA_Nav_Walker(),
                        )
                    );
                    // Fallback if no menu is set
                    if (!has_nav_menu('primary')) {
                    ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="nav-link focus:outline-none">Accueil</a>
                        <a href="#" class="nav-link focus:outline-none">À Propos</a>
                        <a href="#" class="nav-link focus:outline-none">Membres</a>
                        <a href="#" class="nav-link focus:outline-none">Actualités</a>
                        <a href="#" class="nav-link focus:outline-none">Publications</a>
                        <a href="#" class="nav-link focus:outline-none">Contact</a>
                    <?php } ?>
                </div>
                <!-- Section Droite: Langue et Bouton -->
                <div class="flex items-center space-x-4">
                    <!-- Sélecteur de langue -->
                    <div class="lang-dropdown">
                        <button id="lang-menu-button" class="lang-button focus:outline-none">
                            <i class="bi bi-globe mr-1 text-lg"></i>
                            FR
                            <i class="bi bi-chevron-down ml-1 text-sm"></i>
                        </button>
                        <!-- Menu déroulant langues -->
                        <div id="lang-menu" class="lang-dropdown-menu">
                            <a href="#" class="lang-dropdown-item">EN</a>
                            <a href="#" class="lang-dropdown-item">ES</a>
                        </div>
                    </div>
                    <!-- Bouton Devenir Membre -->
                    <button class="member-button bg-[#A8E6CF] hover:bg-[#2D9B8A] text-[#343A40] hover:text-white text-sm font-semibold px-4 py-2 rounded-lg shadow focus:outline-none">
                        Devenir Membre
                    </button>
                </div>
                <!-- Bouton Burger pour mobile -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="text-[#343A40] hover:text-[#2D9B8A] hover:bg-[#F8F9FA] p-2 rounded-md transition-all duration-150 focus:outline-none">
                        <i class="bi bi-list text-2xl"></i>
                    </button>
                </div>
            </div>
            <!-- Menu mobile (caché par défaut) -->
            <div id="mobile-menu" class="md:hidden hidden bg-white shadow-md">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'mobile-primary-menu',
                        'container'      => false,
                        'menu_class'     => '',
                        'fallback_cb'    => false,
                        'items_wrap'     => '%3$s',
                        'walker'         => new Mon_Theme_ACA_Mobile_Nav_Walker(),
                    )
                );
                // Fallback if no menu is set
                if (!has_nav_menu('primary')) {
                ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="block text-[#343A40] hover:text-[#2D9B8A] hover:bg-gray-50 px-4 py-2 text-sm font-medium focus:outline-none">Accueil</a>
                    <a href="#" class="block text-[#343A40] hover:text-[#2D9B8A] hover:bg-gray-50 px-4 py-2 text-sm font-medium focus:outline-none">À Propos</a>
                    <a href="#" class="block text-[#343A40] hover:text-[#2D9B8A] hover:bg-gray-50 px-4 py-2 text-sm font-medium focus:outline-none">Membres</a>
                    <a href="#" class="block text-[#343A40] hover:text-[#2D9B8A] hover:bg-gray-50 px-4 py-2 text-sm font-medium focus:outline-none">Actualités</a>
                    <a href="#" class="block text-[#343A40] hover:text-[#2D9B8A] hover:bg-gray-50 px-4 py-2 text-sm font-medium focus:outline-none">Publications</a>
                    <a href="#" class="block text-[#343A40] hover:text-[#2D9B8A] hover:bg-gray-50 px-4 py-2 text-sm font-medium focus:outline-none">Contact</a>
                <?php } ?>
            </div>
        </nav>
        <?php
        /**
         * Hook pour ajouter du contenu juste après le header
         * Utilisation: add_action('mon_theme_aca_after_header', 'votre_fonction');
         */
        do_action('mon_theme_aca_after_header');
        ?>
        <script>
            // Script pour le menu mobile
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                });
            }
            // Script pour le menu langue (affichage au clic sur mobile)
            const langMenuButton = document.getElementById('lang-menu-button');
            const langMenu = document.getElementById('lang-menu');
            if (langMenuButton && langMenu) {
                langMenuButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    langMenu.classList.toggle('hidden');
                });
                // Fermer le menu si on clique ailleurs
                document.addEventListener('click', function(e) {
                    if (!langMenuButton.contains(e.target) && !langMenu.contains(e.target)) {
                        langMenu.classList.add('hidden');
                    }
                });
            }
        </script>