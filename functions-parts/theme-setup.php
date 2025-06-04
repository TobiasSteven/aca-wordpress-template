<?php

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function mon_theme_aca_setup()
{
    /*
     * Make theme available for translation.
     */
    load_theme_textdomain('mon-theme-aca', MON_THEME_ACA_DIR . '/languages');

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
     * Let WordPress manage the document title.
     */
    add_theme_support('title-tag');

    /*
     * Enable support for Post Thumbnails on posts and pages.
     */
    add_theme_support('post-thumbnails');

    // Set default thumbnail size
    set_post_thumbnail_size(1200, 9999);

    // Register navigation menus
    register_nav_menus(
        array(
            'primary'            => esc_html__('Menu principal', 'mon-theme-aca'),
            'footer'             => esc_html__('Menu pied de page', 'mon-theme-aca'),
            'footer_quick_links' => esc_html__('Liens Rapides du Pied de Page', 'mon-theme-aca'),
        )
    );

    /*
     * Switch default core markup to output valid HTML5.
     */
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    // Add support for Block Styles.
    add_theme_support('wp-block-styles');

    // Add support for full and wide alignment.
    add_theme_support('align-wide');

    // Add support for editor styles.
    add_theme_support('editor-styles');

    // Add support for responsive embedded content.
    add_theme_support('responsive-embeds');

    // Add support for custom line height controls.
    add_theme_support('custom-line-height');

    // Add support for custom units.
    add_theme_support('custom-units');

    // Add support for experimental cover block spacing.
    add_theme_support('custom-spacing');

    // Add support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 80,
        'width'       => 250,
        'flex-height' => true,
        'flex-width'  => true,
    ));
}
add_action('after_setup_theme', 'mon_theme_aca_setup');
