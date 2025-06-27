<?php

/**
 * Header Options Settings
 * Handles header-related customizer settings including logo, navigation, and CTA button
 *
 * @package Mon-Theme-ACA
 */

/**
 * Register header options settings
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mon_theme_aca_register_header_options($wp_customize)
{
    // Add section for header options
    $wp_customize->add_section(
        'mon_theme_aca_header_options',
        array(
            'title'      => esc_html__('Options de l\'en-tête', 'mon-theme-aca'),
            'priority'   => 120,
        )
    );

    // Header Background Color
    $wp_customize->add_setting(
        'header_background_color',
        array(
            'default'           => '#2D9B8A',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'header_background_color',
            array(
                'label'    => esc_html__('Couleur de fond de l\'en-tête', 'mon-theme-aca'),
                'section'  => 'mon_theme_aca_header_options',
            )
        )
    );

    // Navigation Background Color
    $wp_customize->add_setting(
        'nav_background_color',
        array(
            'default'           => '#1F6B5C',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'nav_background_color',
            array(
                'label'    => esc_html__('Couleur de fond de la navigation', 'mon-theme-aca'),
                'section'  => 'mon_theme_aca_header_options',
            )
        )
    );

    // CTA Button Text
    $wp_customize->add_setting(
        'header_cta_text',
        array(
            'default'           => esc_html__('Devenir Membre', 'mon-theme-aca'),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'header_cta_text',
        array(
            'label'    => esc_html__('Texte du bouton d\'action', 'mon-theme-aca'),
            'section'  => 'mon_theme_aca_header_options',
            'type'     => 'text',
        )
    );

    // CTA Button URL
    $wp_customize->add_setting(
        'header_cta_url',
        array(
            'default'           => '#',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'header_cta_url',
        array(
            'label'    => esc_html__('URL du bouton d\'action', 'mon-theme-aca'),
            'section'  => 'mon_theme_aca_header_options',
            'type'     => 'url',
        )
    );

    // CTA Button Color
    $wp_customize->add_setting(
        'header_cta_color',
        array(
            'default'           => '#28A745',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'header_cta_color',
            array(
                'label'    => esc_html__('Couleur du bouton d\'action', 'mon-theme-aca'),
                'section'  => 'mon_theme_aca_header_options',
            )
        )
    );

    // Show Language Selector
    $wp_customize->add_setting(
        'show_language_selector',
        array(
            'default'           => true,
            'sanitize_callback' => 'mon_theme_aca_sanitize_checkbox',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'show_language_selector',
        array(
            'label'    => esc_html__('Afficher le sélecteur de langue', 'mon-theme-aca'),
            'section'  => 'mon_theme_aca_header_options',
            'type'     => 'checkbox',
        )
    );

    // Add selective refresh for header elements
    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial(
            'header_cta_text',
            array(
                'selector'        => '.header-cta-button',
                'render_callback' => 'mon_theme_aca_customize_partial_header_cta',
            )
        );
    }
}
add_action('customize_register', 'mon_theme_aca_register_header_options');

/**
 * Render the header CTA button for the selective refresh partial.
 *
 * @return void
 */
function mon_theme_aca_customize_partial_header_cta()
{
    echo esc_html(get_theme_mod('header_cta_text', 'Devenir Membre'));
}

/**
 * Output custom CSS for header customizations
 */
function mon_theme_aca_header_customizer_css()
{
    $header_bg_color = get_theme_mod('header_background_color', '#2D9B8A');
    $nav_bg_color = get_theme_mod('nav_background_color', '#1F6B5C');
    $cta_color = get_theme_mod('header_cta_color', '#28A745');
?>
<style type="text/css">
/* Header customizations */
header.bg-\[\#2D9B8A\] {
    background-color: <?php echo esc_attr($header_bg_color);
    ?> !important;
}

.bg-\[\#1F6B5C\] {
    background-color: <?php echo esc_attr($nav_bg_color);
    ?> !important;
}

.bg-\[\#28A745\] {
    background-color: <?php echo esc_attr($cta_color);
    ?> !important;
}

/* Mobile menu */
#mobile-menu {
    background-color: <?php echo esc_attr($nav_bg_color);
    ?> !important;
}
</style>
<?php
}
add_action('wp_head', 'mon_theme_aca_header_customizer_css');