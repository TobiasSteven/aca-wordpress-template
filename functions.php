<?php

/**
 * Functions and definitions
 *
 * @package Mon-Theme-ACA
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Define constants
 */
define('MON_THEME_ACA_VERSION', '1.0.0');
define('MON_THEME_ACA_DIR', get_template_directory());
define('MON_THEME_ACA_URI', get_template_directory_uri());

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
            'primary' => esc_html__('Menu principal', 'mon-theme-aca'),
            'footer'  => esc_html__('Menu pied de page', 'mon-theme-aca'),
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

/**
 * Register widget area.
 */
function mon_theme_aca_widgets_init()
{
    register_sidebar(
        array(
            'name'          => esc_html__('Barre latérale', 'mon-theme-aca'),
            'id'            => 'sidebar-1',
            'description'   => esc_html__('Ajoutez des widgets ici.', 'mon-theme-aca'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );

    register_sidebar(
        array(
            'name'          => esc_html__('Pied de page', 'mon-theme-aca'),
            'id'            => 'footer-1',
            'description'   => esc_html__('Ajoutez des widgets pour le pied de page ici.', 'mon-theme-aca'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );
}
add_action('widgets_init', 'mon_theme_aca_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function mon_theme_aca_scripts()
{
    // Enqueue theme stylesheet
    wp_enqueue_style('mon-theme-aca-style', get_stylesheet_uri(), array(), MON_THEME_ACA_VERSION);

    // Enqueue header styles
    wp_enqueue_style('mon-theme-aca-header', MON_THEME_ACA_URI . '/assets/css/header-styles.css', array(), MON_THEME_ACA_VERSION);

    // Enqueue footer styles
    wp_enqueue_style('mon-theme-aca-footer', MON_THEME_ACA_URI . '/assets/css/footer-styles.css', array(), MON_THEME_ACA_VERSION);

    // Enqueue Bootstrap CSS
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css', array(), '5.3.2');

    // Enqueue Google Fonts - Inter for the design
    wp_enqueue_style('mon-theme-aca-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap', array(), null);

    // Enqueue Bootstrap JS
    wp_enqueue_script('bootstrap-bundle', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', array(), '5.3.2', true);

    // Enqueue main.js
    wp_enqueue_script('mon-theme-aca-main', MON_THEME_ACA_URI . '/assets/js/main.js', array('jquery'), MON_THEME_ACA_VERSION, true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'mon_theme_aca_scripts');

/**
 * Custom template tags for this theme.
 */
require MON_THEME_ACA_DIR . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require MON_THEME_ACA_DIR . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require MON_THEME_ACA_DIR . '/inc/customizer.php';

/**
 * Add CSS classes to menu items
 */
function mon_theme_aca_add_menu_link_class($atts, $item, $args)
{
    if (property_exists($args, 'link_class')) {
        $atts['class'] = $args->link_class;
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'mon_theme_aca_add_menu_link_class', 1, 3);

/**
 * Includes
 */
require MON_THEME_ACA_DIR . '/inc/footer-customizer.php'; // Ajout de la personnalisation du footer
