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
}
add_action('init', 'mon_theme_aca_register_blocks');

/**
 * Enqueue block assets
 */
function mon_theme_aca_enqueue_block_assets()
{
    // Enqueue FontAwesome pour les icônes
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css',
        array(),
        '6.0.0'
    );
}
add_action('wp_enqueue_scripts', 'mon_theme_aca_enqueue_block_assets');
add_action('enqueue_block_editor_assets', 'mon_theme_aca_enqueue_block_assets');

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
