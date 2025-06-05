<?php

/**
 * Custom Blocks Registration
 *
 * @package Mon-Theme-ACA
 */

/**
 * Register custom blocks
 */
function mon_theme_aca_register_blocks()
{
    // Enregistrer le bloc stats-cards
    register_block_type(get_template_directory() . '/blocks/stats-cards');

    // Enregistrer le bloc hero-slider
    register_block_type(get_template_directory() . '/blocks/hero-slider');

    // Enregistrer le bloc recent-news
    register_block_type(get_template_directory() . '/blocks/recent-news');

    // Enregistrer le bloc nos-missions
    register_block_type(get_template_directory() . '/blocks/nos-missions');

    // Enregistrer le bloc events
    register_block_type(get_template_directory() . '/blocks/events');

    // Enregistrer le bloc testimonials
    register_block_type(get_template_directory() . '/blocks/testimonials');

    // Enregistrer le bloc partners
    register_block_type(get_template_directory() . '/blocks/partners');

    // Enregistrer le bloc newsletter
    register_block_type(get_template_directory() . '/blocks/newsletter');
}
add_action('init', 'mon_theme_aca_register_blocks');

/**
 * Enqueue block assets for frontend
 */
function mon_theme_aca_enqueue_block_assets()
{
    // Enqueue FontAwesome pour les icônes
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
        array(),
        '6.5.1'
    );

    // S'assurer que les styles des blocks sont chargés
    if (has_block('mon-theme-aca/recent-news')) {
        wp_enqueue_style(
            'mon-theme-aca-recent-news-style',
            get_template_directory_uri() . '/blocks/recent-news/build/style-index.css',
            array(),
            filemtime(get_template_directory() . '/blocks/recent-news/build/style-index.css')
        );
    }

    // S'assurer que les styles du block newsletter sont chargés
    if (has_block('mon-theme-aca/newsletter')) {
        wp_enqueue_style(
            'mon-theme-aca-newsletter-style',
            get_template_directory_uri() . '/blocks/newsletter/build/style-index.css',
            array(),
            filemtime(get_template_directory() . '/blocks/newsletter/build/style-index.css')
        );
    }
}
add_action('wp_enqueue_scripts', 'mon_theme_aca_enqueue_block_assets');

/**
 * Force l'enqueue des styles de blocks même si has_block ne fonctionne pas
 */
function mon_theme_aca_force_block_styles()
{
    // Enqueue forcé des styles du block recent-news
    wp_enqueue_style(
        'mon-theme-aca-recent-news-frontend',
        get_template_directory_uri() . '/blocks/recent-news/build/style-index.css',
        array(),
        filemtime(get_template_directory() . '/blocks/recent-news/build/style-index.css')
    );

    // Enqueue forcé des styles du block events
    if (file_exists(get_template_directory() . '/blocks/events/build/style-index.css')) {
        wp_enqueue_style(
            'mon-theme-aca-events-frontend',
            get_template_directory_uri() . '/blocks/events/build/style-index.css',
            array(),
            filemtime(get_template_directory() . '/blocks/events/build/style-index.css')
        );
    }

    // Enqueue forcé des styles du block testimonials
    if (file_exists(get_template_directory() . '/blocks/testimonials/style-index.css')) {
        wp_enqueue_style(
            'mon-theme-aca-testimonials-frontend',
            get_template_directory_uri() . '/blocks/testimonials/style-index.css',
            array(),
            filemtime(get_template_directory() . '/blocks/testimonials/style-index.css')
        );
    }

    // Enqueue forcé des styles du block newsletter
    if (file_exists(get_template_directory() . '/blocks/newsletter/build/style-index.css')) {
        wp_enqueue_style(
            'mon-theme-aca-newsletter-frontend',
            get_template_directory_uri() . '/blocks/newsletter/build/style-index.css',
            array(),
            filemtime(get_template_directory() . '/blocks/newsletter/build/style-index.css')
        );
    }
}
add_action('wp_enqueue_scripts', 'mon_theme_aca_force_block_styles', 20);

/**
 * Enqueue block editor assets
 */
function mon_theme_aca_enqueue_block_editor_assets()
{
    // Enqueue FontAwesome pour l'éditeur Gutenberg avec priorité élevée
    wp_enqueue_style(
        'font-awesome-editor',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
        array(),
        '6.5.1'
    );

    // Ajouter CSS personnalisé pour forcer l'affichage des icônes dans l'éditeur
    $custom_css = '
        .wp-block-mon-theme-aca-stats-cards .stat-icon-editor i {
            font-family: "Font Awesome 6 Free", "Font Awesome 6 Pro", "Font Awesome 6 Brands", "FontAwesome" !important;
            font-weight: 900 !important;
            font-style: normal !important;
            font-variant: normal !important;
            text-rendering: auto !important;
            line-height: 1 !important;
            -webkit-font-smoothing: antialiased !important;
            -moz-osx-font-smoothing: grayscale !important;
        }
        
        .components-panel__body .stat-icon-preview i {
            font-family: "Font Awesome 6 Free", "Font Awesome 6 Pro", "Font Awesome 6 Brands", "FontAwesome" !important;
            font-weight: 900 !important;
            font-style: normal !important;
            font-variant: normal !important;
            text-rendering: auto !important;
            line-height: 1 !important;
            -webkit-font-smoothing: antialiased !important;
            -moz-osx-font-smoothing: grayscale !important;
        }
    ';

    wp_add_inline_style('font-awesome-editor', $custom_css);
}
add_action('enqueue_block_editor_assets', 'mon_theme_aca_enqueue_block_editor_assets', 5);

/**
 * Add block category for theme blocks
 */
function mon_theme_aca_block_categories($categories, $post)
{
    return array_merge(
        $categories,
        array(
            array(
                'slug'  => 'mon-theme-aca',
                'title' => __('Mon Thème ACA', 'mon-theme-aca'),
                'icon'  => 'chart-bar',
            ),
        )
    );
}
add_filter('block_categories_all', 'mon_theme_aca_block_categories', 10, 2);
