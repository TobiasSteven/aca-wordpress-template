<?php

/**
 * Mon-Theme-ACA Theme Customizer
 *
 * @package Mon-Theme-ACA
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mon_theme_aca_customize_register($wp_customize)
{
    $wp_customize->get_setting('blogname')->transport         = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

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
            'default'           => '#007bff',
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
add_action('customize_register', 'mon_theme_aca_customize_register');

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function mon_theme_aca_customize_partial_blogname()
{
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function mon_theme_aca_customize_partial_blogdescription()
{
    bloginfo('description');
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function mon_theme_aca_customize_preview_js()
{
    wp_enqueue_script('mon-theme-aca-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array('customize-preview'), MON_THEME_ACA_VERSION, true);
}
add_action('customize_preview_init', 'mon_theme_aca_customize_preview_js');

/**
 * Generate CSS for the theme customizer options
 */
function mon_theme_aca_customizer_css()
{
    $primary_color = get_theme_mod('primary_color', '#007bff');
?>
    <style type="text/css">
        a {
            color: <?php echo esc_attr($primary_color); ?>;
        }

        a:hover {
            color: <?php echo esc_attr(mon_theme_aca_adjust_brightness($primary_color, -30)); ?>;
        }

        .button,
        button,
        input[type="button"],
        input[type="reset"],
        input[type="submit"] {
            background-color: <?php echo esc_attr($primary_color); ?>;
        }

        .button:hover,
        button:hover,
        input[type="button"]:hover,
        input[type="reset"]:hover,
        input[type="submit"]:hover {
            background-color: <?php echo esc_attr(mon_theme_aca_adjust_brightness($primary_color, -15)); ?>;
        }
    </style>
<?php
}
add_action('wp_head', 'mon_theme_aca_customizer_css');

/**
 * Helper function to adjust color brightness
 */
function mon_theme_aca_adjust_brightness($hex, $steps)
{
    // Steps should be between -255 and 255. Negative = darker, positive = lighter
    $steps = max(-255, min(255, $steps));

    // Format the hex color string
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex, 0, 1), 2) . str_repeat(substr($hex, 1, 1), 2) . str_repeat(substr($hex, 2, 1), 2);
    }

    // Get decimal values
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));

    // Adjust brightness
    $r = max(0, min(255, $r + $steps));
    $g = max(0, min(255, $g + $steps));
    $b = max(0, min(255, $b + $steps));

    // Convert back to hex
    $r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
    $g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
    $b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

    return '#' . $r_hex . $g_hex . $b_hex;
}
