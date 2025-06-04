<?php

/**
 * Footer Options Settings
 * Handles all footer-related customizer settings including about, contact, social links
 *
 * @package Mon-Theme-ACA
 */

/**
 * Register footer options settings
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function mon_theme_aca_register_footer_options($wp_customize)
{
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
}
