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
}
add_action('wp_enqueue_scripts', 'mon_theme_aca_enqueue_block_assets');

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
