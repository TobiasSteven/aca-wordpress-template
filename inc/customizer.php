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

    // Ajout d'une section pour le footer
    $wp_customize->add_section(
        'mon_theme_aca_footer_options',
        array(
            'title'      => esc_html__('Options du pied de page', 'mon-theme-aca'),
            'priority'   => 140,
        )
    );

    // Texte "À Propos"
    $wp_customize->add_setting(
        'footer_about_title',
        array(
            'default'           => esc_html__('À Propos de l\'ACA', 'mon-theme-aca'),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'footer_about_title',
        array(
            'label'    => __('Titre de la section À Propos', 'mon-theme-aca'),
            'section'  => 'mon_theme_aca_footer_options',
            'type'     => 'text',
        )
    );

    // Description "À Propos"
    $wp_customize->add_setting(
        'footer_about_description',
        array(
            'default'           => __('L\'Association Africaine du Coton (ACA) œuvre pour le développement durable et la promotion de la filière coton en Afrique.', 'mon-theme-aca'),
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'footer_about_description',
        array(
            'label'    => __('Description de la section À Propos', 'mon-theme-aca'),
            'section'  => 'mon_theme_aca_footer_options',
            'type'     => 'textarea',
        )
    );

    // Afficher le logo dans la section À Propos
    $wp_customize->add_setting(
        'footer_display_logo',
        array(
            'default'           => false,
            'sanitize_callback' => 'mon_theme_aca_sanitize_checkbox',
            'transport'         => 'refresh',
        )
    );

    $wp_customize->add_control(
        'footer_display_logo',
        array(
            'label'    => __('Afficher le logo dans la section À Propos', 'mon-theme-aca'),
            'section'  => 'mon_theme_aca_footer_options',
            'type'     => 'checkbox',
        )
    );

    // Titre "Liens Rapides"
    $wp_customize->add_setting(
        'footer_links_title',
        array(
            'default'           => __('Liens Rapides', 'mon-theme-aca'),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'footer_links_title',
        array(
            'label'    => __('Titre de la section Liens Rapides', 'mon-theme-aca'),
            'section'  => 'mon_theme_aca_footer_options',
            'type'     => 'text',
        )
    );

    // Titre "Contactez-nous"
    $wp_customize->add_setting(
        'footer_contact_title',
        array(
            'default'           => __('Contactez-nous', 'mon-theme-aca'),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'footer_contact_title',
        array(
            'label'    => __('Titre de la section Contact', 'mon-theme-aca'),
            'section'  => 'mon_theme_aca_footer_options',
            'type'     => 'text',
        )
    );

    // Adresse
    $wp_customize->add_setting(
        'footer_contact_address',
        array(
            'default'           => __('123 Rue du Coton, Cotonou, Bénin', 'mon-theme-aca'),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'footer_contact_address',
        array(
            'label'    => __('Adresse', 'mon-theme-aca'),
            'section'  => 'mon_theme_aca_footer_options',
            'type'     => 'text',
        )
    );

    // Email
    $wp_customize->add_setting(
        'footer_contact_email',
        array(
            'default'           => 'info@aca-coton.org',
            'sanitize_callback' => 'sanitize_email',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'footer_contact_email',
        array(
            'label'    => __('Email', 'mon-theme-aca'),
            'section'  => 'mon_theme_aca_footer_options',
            'type'     => 'email',
        )
    );

    // Téléphone
    $wp_customize->add_setting(
        'footer_contact_phone',
        array(
            'default'           => '+229 12 34 56 78',
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'footer_contact_phone',
        array(
            'label'    => __('Téléphone', 'mon-theme-aca'),
            'section'  => 'mon_theme_aca_footer_options',
            'type'     => 'text',
        )
    );

    // Titre "Suivez-nous"
    $wp_customize->add_setting(
        'footer_social_title',
        array(
            'default'           => __('Suivez-nous', 'mon-theme-aca'),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'footer_social_title',
        array(
            'label'    => __('Titre de la section Réseaux Sociaux', 'mon-theme-aca'),
            'section'  => 'mon_theme_aca_footer_options',
            'type'     => 'text',
        )
    );

    // URL Facebook
    $wp_customize->add_setting(
        'footer_facebook_url',
        array(
            'default'           => '#',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        )
    );

    $wp_customize->add_control(
        'footer_facebook_url',
        array(
            'label'    => __('URL Facebook', 'mon-theme-aca'),
            'section'  => 'mon_theme_aca_footer_options',
            'type'     => 'url',
        )
    );

    // URL Twitter
    $wp_customize->add_setting(
        'footer_twitter_url',
        array(
            'default'           => '#',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        )
    );

    $wp_customize->add_control(
        'footer_twitter_url',
        array(
            'label'    => __('URL Twitter', 'mon-theme-aca'),
            'section'  => 'mon_theme_aca_footer_options',
            'type'     => 'url',
        )
    );

    // URL LinkedIn
    $wp_customize->add_setting(
        'footer_linkedin_url',
        array(
            'default'           => '#',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        )
    );

    $wp_customize->add_control(
        'footer_linkedin_url',
        array(
            'label'    => __('URL LinkedIn', 'mon-theme-aca'),
            'section'  => 'mon_theme_aca_footer_options',
            'type'     => 'url',
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
 * Sanitize checkbox settings
 */
if (!function_exists('mon_theme_aca_sanitize_checkbox')) {
    function mon_theme_aca_sanitize_checkbox($checked)
    {
        return ((isset($checked) && true == $checked) ? true : false);
    }
}

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
