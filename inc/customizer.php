<?php

/**
 * Mon-Theme-ACA Theme Customizer
 *
 * @package Mon-Theme-ACA
 */

// Include customizer parts
require_once get_template_directory() . '/inc/customizer-parts/helpers.php';
require_once get_template_directory() . '/inc/customizer-parts/core-settings.php';
require_once get_template_directory() . '/inc/customizer-parts/theme-options.php';
require_once get_template_directory() . '/inc/customizer-parts/footer-options.php';

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mon_theme_aca_customize_register($wp_customize)
{
    // Register core settings (blogname, blogdescription, selective refresh)
    mon_theme_aca_register_core_settings($wp_customize);

    // Register theme options (logo, colors, footer text)
    mon_theme_aca_register_theme_options($wp_customize);

    // Register footer options (about, contact, social links)
    mon_theme_aca_register_footer_options($wp_customize);
}
add_action('customize_register', 'mon_theme_aca_customize_register');

// Hook for customizer preview JavaScript
add_action('customize_preview_init', 'mon_theme_aca_customize_preview_js');

// Hook for customizer CSS output
add_action('wp_head', 'mon_theme_aca_customizer_css');
