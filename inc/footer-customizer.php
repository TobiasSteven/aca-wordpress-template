<?php

/**
 * Footer Customizer Settings
 *
 * @package Mon-Theme-ACA
 */

/**
 * Add Footer options to the Customizer
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mon_theme_aca_footer_customize_register($wp_customize)
{
    // Ajout d'une section pour le footer
    $wp_customize->add_section(
        'mon_theme_aca_footer_options',
        array(
            'title'      => esc_html__('Options du pied de page', 'mon-theme-aca'),
            'priority'   => 140,
        )
    );

    // Logo spécifique pour le footer
    $wp_customize->add_setting(
        'footer_logo',
        array(
            'default'           => '',
            'sanitize_callback' => 'absint',
            'transport'         => 'refresh',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Cropped_Image_Control(
            $wp_customize,
            'footer_logo',
            array(
                'label'         => esc_html__('Logo du footer', 'mon-theme-aca'),
                'description'   => esc_html__('Ce logo sera affiché au-dessus du titre de la section À Propos', 'mon-theme-aca'),
                'section'       => 'mon_theme_aca_footer_options',
                'priority'      => 5, // Pour s'assurer qu'il apparaît avant les autres options
                'width'         => 180,
                'height'        => 60,
                'flex_width'    => true,
                'flex_height'   => true,
            )
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
            'label'    => esc_html__('Titre de la section À Propos', 'mon-theme-aca'),
            'section'  => 'mon_theme_aca_footer_options',
            'type'     => 'text',
        )
    );

    // Description "À Propos"
    $wp_customize->add_setting(
        'footer_about_description',
        array(
            'default'           => esc_html__('L\'Association Africaine du Coton (ACA) œuvre pour le développement durable et la promotion de la filière coton en Afrique.', 'mon-theme-aca'),
            'sanitize_callback' => 'sanitize_textarea_field',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'footer_about_description',
        array(
            'label'    => esc_html__('Description de la section À Propos', 'mon-theme-aca'),
            'section'  => 'mon_theme_aca_footer_options',
            'type'     => 'textarea',
        )
    );

    // Titre "Liens Rapides"
    $wp_customize->add_setting(
        'footer_links_title',
        array(
            'default'           => esc_html__('Liens Rapides', 'mon-theme-aca'),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'footer_links_title',
        array(
            'label'    => esc_html__('Titre de la section Liens Rapides', 'mon-theme-aca'),
            'section'  => 'mon_theme_aca_footer_options',
            'type'     => 'text',
        )
    );

    // Titre "Contactez-nous"
    $wp_customize->add_setting(
        'footer_contact_title',
        array(
            'default'           => esc_html__('Contactez-nous', 'mon-theme-aca'),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'footer_contact_title',
        array(
            'label'    => esc_html__('Titre de la section Contact', 'mon-theme-aca'),
            'section'  => 'mon_theme_aca_footer_options',
            'type'     => 'text',
        )
    );

    // Adresse
    $wp_customize->add_setting(
        'footer_contact_address',
        array(
            'default'           => esc_html__('123 Rue du Coton, Cotonou, Bénin', 'mon-theme-aca'),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'footer_contact_address',
        array(
            'label'    => esc_html__('Adresse', 'mon-theme-aca'),
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
            'label'    => esc_html__('Email', 'mon-theme-aca'),
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
            'label'    => esc_html__('Téléphone', 'mon-theme-aca'),
            'section'  => 'mon_theme_aca_footer_options',
            'type'     => 'text',
        )
    );

    // Titre "Suivez-nous"
    $wp_customize->add_setting(
        'footer_social_title',
        array(
            'default'           => esc_html__('Suivez-nous', 'mon-theme-aca'),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'footer_social_title',
        array(
            'label'    => esc_html__('Titre de la section Réseaux Sociaux', 'mon-theme-aca'),
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
            'label'    => esc_html__('URL Facebook', 'mon-theme-aca'),
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
            'label'    => esc_html__('URL Twitter', 'mon-theme-aca'),
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
            'label'    => esc_html__('URL LinkedIn', 'mon-theme-aca'),
            'section'  => 'mon_theme_aca_footer_options',
            'type'     => 'url',
        )
    );
}
add_action('customize_register', 'mon_theme_aca_footer_customize_register');

// La fonction mon_theme_aca_sanitize_checkbox est déjà définie dans customizer.php
