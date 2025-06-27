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
        <a class="skip-link screen-reader-text"
            href="#primary"><?php esc_html_e('Aller au contenu', 'mon-theme-aca'); ?></a>

        <!-- Header principal -->
        <header class="bg-[#2D9B8A] shadow-lg relative z-50">
            <!-- Main Header -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <!-- Logo -->
                    <div class="flex items-center cursor-pointer"
                        onclick="window.location.href='<?php echo esc_url(home_url('/')); ?>'">
                        <div class="bg-white rounded-lg p-2 mr-4">
                            <div class="w-12 h-8 bg-[#2D9B8A] rounded flex items-center justify-center">
                                <span class="text-white font-bold text-sm">
                                    <?php echo esc_html(get_theme_mod('logo_fallback_text', 'ACA')); ?>
                                </span>
                            </div>
                        </div>
                        <div class="text-white">
                            <h1 class="text-xl font-bold"><?php bloginfo('name'); ?></h1>
                            <p class="text-[#A8E6CF] text-sm"><?php bloginfo('description'); ?></p>
                        </div>
                    </div>

                    <!-- Desktop Navigation -->
                    <nav class="hidden lg:flex items-center space-x-1">
                        <div class="bg-[#1F6B5C] rounded-lg px-1 py-1 flex items-center justify-center space-x-1">
                            <?php
                            wp_nav_menu(
                                array(
                                    'theme_location' => 'primary',
                                    'menu_id'        => 'primary-menu',
                                    'container'      => false,
                                    'menu_class'     => 'flex justify-center',
                                    'fallback_cb'    => false,
                                    'items_wrap'     => '<div class="flex justify-center items-center">%3$s</div>',
                                    'walker'         => new Mon_Theme_ACA_Nav_Walker(),
                                )
                            );
                            // Fallback if no menu is set
                            if (!has_nav_menu('primary')) {
                            ?>
                            <div class="flex justify-center items-center">
                                <button onclick="window.location.href='<?php echo esc_url(home_url('/')); ?>'"
                                    class="px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200 <?php echo is_front_page() ? 'bg-[#2D9B8A] text-white' : 'text-white hover:bg-[#A8E6CF] hover:text-[#1F6B5C]'; ?>">
                                    Accueil
                                </button>
                                <button onclick="window.location.href='#'"
                                    class="px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200 text-white hover:bg-[#A8E6CF] hover:text-[#1F6B5C]">
                                    À Propos
                                </button>
                                <button onclick="window.location.href='#'"
                                    class="px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200 text-white hover:bg-[#A8E6CF] hover:text-[#1F6B5C]">
                                    Membres
                                </button>
                                <button onclick="window.location.href='#'"
                                    class="px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200 text-white hover:bg-[#A8E6CF] hover:text-[#1F6B5C]">
                                    Actualités
                                </button>
                                <button onclick="window.location.href='#'"
                                    class="px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200 text-white hover:bg-[#A8E6CF] hover:text-[#1F6B5C]">
                                    Publications
                                </button>
                                <button onclick="window.location.href='#'"
                                    class="px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200 text-white hover:bg-[#A8E6CF] hover:text-[#1F6B5C]">
                                    Contact
                                </button>
                            </div>
                            <?php } ?>
                        </div>

                        <!-- Language Selector -->
                        <div class="relative ml-4">
                            <button id="lang-menu-button"
                                class="flex items-center space-x-1 text-white hover:text-[#A8E6CF] transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="w-4 h-4">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="2" y1="12" x2="22" y2="12"></line>
                                    <path
                                        d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z">
                                    </path>
                                </svg>
                                <span class="text-sm">FR</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="w-4 h-4">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </button>
                            <div id="lang-menu"
                                class="absolute right-0 mt-2 w-24 bg-white rounded-md shadow-lg py-1 z-50 hidden">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">FR</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">EN</a>
                            </div>
                        </div>

                        <!-- CTA Button -->
                        <a href="<?php echo esc_url(get_theme_mod('header_cta_url', '#')); ?>"
                            class="ml-4 bg-[#28A745] text-white px-6 py-2 rounded-lg font-medium hover:bg-green-600 transition-colors header-cta-button">
                            <?php echo esc_html(get_theme_mod('header_cta_text', 'Devenir Membre')); ?>
                        </a>
                    </nav>

                    <!-- Mobile menu button -->
                    <button id="mobile-menu-button" class="lg:hidden text-white hover:text-[#A8E6CF] transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="w-6 h-6" id="menu-icon">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="w-6 h-6 hidden" id="close-icon">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div id="mobile-menu" class="lg:hidden bg-[#1F6B5C] border-t border-[#2D9B8A] hidden">
                <div class="px-4 py-4 space-y-2">
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
                    <button onclick="window.location.href='<?php echo esc_url(home_url('/')); ?>'"
                        class="block w-full text-left px-4 py-2 rounded-md text-sm font-medium transition-colors <?php echo is_front_page() ? 'bg-[#2D9B8A] text-white' : 'text-white hover:bg-[#A8E6CF] hover:text-[#1F6B5C]'; ?>">
                        Accueil
                    </button>
                    <button onclick="window.location.href='#'"
                        class="block w-full text-left px-4 py-2 rounded-md text-sm font-medium transition-colors text-white hover:bg-[#A8E6CF] hover:text-[#1F6B5C]">
                        À Propos
                    </button>
                    <button onclick="window.location.href='#'"
                        class="block w-full text-left px-4 py-2 rounded-md text-sm font-medium transition-colors text-white hover:bg-[#A8E6CF] hover:text-[#1F6B5C]">
                        Membres
                    </button>
                    <button onclick="window.location.href='#'"
                        class="block w-full text-left px-4 py-2 rounded-md text-sm font-medium transition-colors text-white hover:bg-[#A8E6CF] hover:text-[#1F6B5C]">
                        Actualités
                    </button>
                    <button onclick="window.location.href='#'"
                        class="block w-full text-left px-4 py-2 rounded-md text-sm font-medium transition-colors text-white hover:bg-[#A8E6CF] hover:text-[#1F6B5C]">
                        Publications
                    </button>
                    <button onclick="window.location.href='#'"
                        class="block w-full text-left px-4 py-2 rounded-md text-sm font-medium transition-colors text-white hover:bg-[#A8E6CF] hover:text-[#1F6B5C]">
                        Contact
                    </button>
                    <?php } ?>
                    <div class="pt-4 border-t border-[#2D9B8A]">
                        <a href="<?php echo esc_url(get_theme_mod('header_cta_url', '#')); ?>"
                            class="block w-full bg-[#28A745] text-white px-4 py-2 rounded-lg font-medium hover:bg-green-600 transition-colors text-center header-cta-button">
                            <?php echo esc_html(get_theme_mod('header_cta_text', 'Devenir Membre')); ?>
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <?php
        /**
         * Hook pour ajouter du contenu juste après le header
         * Utilisation: add_action('mon_theme_aca_after_header', 'votre_fonction');
         */
        do_action('mon_theme_aca_after_header');
        ?>

        <script>
        // Script pour le menu mobile
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const menuIcon = document.getElementById('menu-icon');
            const closeIcon = document.getElementById('close-icon');

            if (mobileMenuButton && mobileMenu && menuIcon && closeIcon) {
                mobileMenuButton.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                    menuIcon.classList.toggle('hidden');
                    closeIcon.classList.toggle('hidden');
                });
            }

            // Script pour le menu langue
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
        });
        </script>