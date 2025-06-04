<?php

/**
 * Theme Options Settings
 * Handles theme-specific customizer settings like logo, colors, and general theme options
 *
 * @package Mon-Theme-ACA
 */

/**
 * Register theme options settings
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mon_theme_aca_register_theme_options($wp_customize)
{
    // Add section for theme options
    $wp_customize->add_section(
        'mon_theme_aca_theme_options',
        array(
            'title'      => __('Options du thème', 'mon-theme-aca'),
            'priority'   => 130,
        )
    );

    // Add setting for logo
    $wp_customize->add_setting(
        'custom_logo',
        array(
            'default'           => '',
            'sanitize_callback' => 'absint',
            'transport'         => 'refresh',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Cropped_Image_Control(
            $wp_customize,
            'custom_logo',
            array(
                'label'         => __('Logo', 'mon-theme-aca'),
                'section'       => 'mon_theme_aca_theme_options',
                'settings'      => 'custom_logo',
                'width'         => 250,
                'height'        => 80,
                'flex_width'    => true,
                'flex_height'   => true,
            )
        )
    );

    // Add alternative text setting for logo
    $wp_customize->add_setting(
        'logo_alt_text',
        array(
            'default'           => get_bloginfo('name'),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        )
    );

    $wp_customize->add_control(
        'logo_alt_text',
        array(
            'label'       => __('Texte alternatif du logo', 'mon-theme-aca'),
            'description' => __('Texte qui sera affiché si le logo ne peut pas être chargé', 'mon-theme-aca'),
            'section'     => 'mon_theme_aca_theme_options',
            'type'        => 'text',
        )
    );

    // Add fallback text for when no logo is set
    $wp_customize->add_setting(
        'logo_fallback_text',
        array(
            'default'           => 'ACA',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'refresh',
        )
    );

    $wp_customize->add_control(
        'logo_fallback_text',
        array(
            'label'       => __('Texte de substitution du logo', 'mon-theme-aca'),
            'description' => __('Texte qui sera affiché si aucun logo n\'est sélectionné', 'mon-theme-aca'),
            'section'     => 'mon_theme_aca_theme_options',
            'type'        => 'text',
        )
    );

    // Add setting for primary color
    $wp_customize->add_setting(
        'primary_color',
        array(
            'default'           => '#2D9B8A',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'primary_color',
            array(
                'label'    => __('Couleur principale', 'mon-theme-aca'),
                'section'  => 'mon_theme_aca_theme_options',
                'settings' => 'primary_color',
            )
        )
    );

    // Add setting for footer text
    $wp_customize->add_setting(
        'footer_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'footer_text',
        array(
            'type'     => 'textarea',
            'label'    => __('Texte du pied de page', 'mon-theme-aca'),
            'section'  => 'mon_theme_aca_theme_options',
            'settings' => 'footer_text',
        )
    );
}
