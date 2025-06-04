<?php

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

    // Enqueue navigation animations
    wp_enqueue_style('mon-theme-aca-nav-animations', MON_THEME_ACA_URI . '/assets/css/navigation-animations.css', array(), MON_THEME_ACA_VERSION);

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
