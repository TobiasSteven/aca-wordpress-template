<?php

/**
 * Core Customizer Settings
 * Handles basic WordPress customizer settings like blogname, blogdescription, and selective refresh
 *
 * @package Mon-Theme-ACA
 */

/**
 * Register core customizer settings
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mon_theme_aca_register_core_settings($wp_customize)
{
    // Set transport to postMessage for live preview
    $wp_customize->get_setting('blogname')->transport         = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

    // Add selective refresh support
    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial(
            'blogname',
            array(
                'selector'        => '.site-title a',
                'render_callback' => 'mon_theme_aca_customize_partial_blogname',
            )
        );
        $wp_customize->selective_refresh->add_partial(
            'blogdescription',
            array(
                'selector'        => '.site-description',
                'render_callback' => 'mon_theme_aca_customize_partial_blogdescription',
            )
        );
    }
}
