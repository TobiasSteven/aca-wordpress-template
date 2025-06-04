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
    <?php wp_head(); ?>
</head>

<body <?php body_class('bg-[#F8F9FA]'); ?>>
    <?php wp_body_open(); ?>
    <div id="page" class="site">
        <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Aller au contenu', 'mon-theme-aca'); ?></a>
        <!-- Barre de navigation -->
        <nav class="bg-white shadow-md mb-8">
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
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="text-[#343A40] hover:text-[#2D9B8A] px-3 py-2 rounded-md text-sm font-medium">Accueil</a>
                        <a href="#" class="text-[#343A40] hover:text-[#2D9B8A] px-3 py-2 rounded-md text-sm font-medium">À Propos</a>
                        <a href="#" class="text-[#343A40] hover:text-[#2D9B8A] px-3 py-2 rounded-md text-sm font-medium">Membres</a>
                        <a href="#" class="text-[#343A40] hover:text-[#2D9B8A] px-3 py-2 rounded-md text-sm font-medium">Actualités</a>
                        <a href="#" class="text-[#343A40] hover:text-[#2D9B8A] px-3 py-2 rounded-md text-sm font-medium">Publications</a>
                        <a href="#" class="text-[#343A40] hover:text-[#2D9B8A] px-3 py-2 rounded-md text-sm font-medium">Contact</a>
                    <?php } ?>
                </div>
                <!-- Section Droite: Langue et Bouton -->
                <div class="flex items-center space-x-4">
                    <!-- Sélecteur de langue -->
                    <div class="lang-dropdown">
                        <button id="lang-menu-button" class="lang-button focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.33 6.332A6.001 6.001 0 0110 4c.77 0 1.502.144 2.171.403A4.001 4.001 0 0010 3a4 4 0 00-3.032 1.228.997.997 0 00-.139.096l-.04.028a.999.999 0 00-.197.187C5.25 4.94 4.623 5.59 4.33 6.332zM15.67 13.668A6.001 6.001 0 0110 16c-.77 0-1.502-.144-2.171-.403A4.001 4.001 0 0010 17a4 4 0 003.032-1.228.997.997 0 00.139-.096l.04-.028a.999.999 0 00.197.187c1.339-.74 1.966-1.39 2.257-2.132zM8.5 7.5a.5.5 0 000 1h3a.5.5 0 000-1h-3zM6 10a.5.5 0 01.5-.5h7a.5.5 0 010 1h-7A.5.5 0 016 10zm2.5 2.5a.5.5 0 000 1h3a.5.5 0 000-1h-3z" clip-rule="evenodd" />
                            </svg>
                            FR
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <!-- Menu déroulant langues -->
                        <div id="lang-menu" class="lang-dropdown-menu">
                            <a href="#" class="lang-dropdown-item">EN</a>
                            <a href="#" class="lang-dropdown-item">ES</a>
                        </div>
                    </div>
                    <!-- Bouton Devenir Membre -->
                    <button class="bg-[#A8E6CF] hover:bg-[#2D9B8A] text-[#343A40] hover:text-white text-sm font-semibold px-4 py-2 rounded-lg shadow">
                        Devenir Membre
                    </button>
                </div>
                <!-- Bouton Burger pour mobile -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-button" class="text-[#343A40] hover:text-[#2D9B8A] hover:bg-[#F8F9FA] p-2 rounded-md transition-all duration-150 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
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
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="block text-[#343A40] hover:text-[#2D9B8A] hover:bg-gray-50 px-4 py-2 text-sm font-medium">Accueil</a>
                    <a href="#" class="block text-[#343A40] hover:text-[#2D9B8A] hover:bg-gray-50 px-4 py-2 text-sm font-medium">À Propos</a>
                    <a href="#" class="block text-[#343A40] hover:text-[#2D9B8A] hover:bg-gray-50 px-4 py-2 text-sm font-medium">Membres</a>
                    <a href="#" class="block text-[#343A40] hover:text-[#2D9B8A] hover:bg-gray-50 px-4 py-2 text-sm font-medium">Actualités</a>
                    <a href="#" class="block text-[#343A40] hover:text-[#2D9B8A] hover:bg-gray-50 px-4 py-2 text-sm font-medium">Publications</a>
                    <a href="#" class="block text-[#343A40] hover:text-[#2D9B8A] hover:bg-gray-50 px-4 py-2 text-sm font-medium">Contact</a>
                <?php } ?>
            </div>
        </nav>
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