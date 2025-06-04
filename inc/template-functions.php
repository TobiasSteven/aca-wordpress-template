<?php

/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Mon-Theme-ACA
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function mon_theme_aca_body_classes($classes)
{
    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if (!is_active_sidebar('sidebar-1')) {
        $classes[] = 'no-sidebar';
    }

    // Add a class if is the front page.
    if (is_front_page()) {
        $classes[] = 'front-page';
    }

    return $classes;
}
add_filter('body_class', 'mon_theme_aca_body_classes');

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function mon_theme_aca_pingback_header()
{
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('wp_head', 'mon_theme_aca_pingback_header');

/**
 * Get the custom logo or display a fallback
 */
function mon_theme_aca_get_custom_logo()
{
    $html = '';
    $custom_logo_id = get_theme_mod('custom_logo');
    $logo_alt_text = get_theme_mod('logo_alt_text', get_bloginfo('name'));
    $logo_fallback_text = get_theme_mod('logo_fallback_text', 'ACA');

    if ($custom_logo_id) {
        $logo_img = wp_get_attachment_image($custom_logo_id, 'full', false, array(
            'class' => 'custom-logo',
            'alt' => esc_attr($logo_alt_text),
        ));

        $html = sprintf(
            '<a href="%1$s" class="custom-logo-link" rel="home">%2$s</a>',
            esc_url(home_url('/')),
            $logo_img
        );
    } else {
        // Fallback to the logo HTML structure in the original header
        $html = '
        <div class="flex items-center">
            <div class="logo-aca-square">
                <span class="text-xs leading-none">ACME<br>CORP</span>
            </div>
            <span class="logo-text-main ml-2">' . esc_html($logo_fallback_text) . '</span>
        </div>';
    }

    return $html;
}

/**
 * Custom Navigation Walker for Desktop Menu
 */
class Mon_Theme_ACA_Nav_Walker extends Walker_Nav_Menu
{
    /**
     * Starts the element output.
     */
    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $classes = empty($item->classes) ? array() : (array) $item->classes;

        // Add classes for styling
        $classes[] = 'menu-item-' . $item->ID;

        // Filter the CSS class
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        // Build HTML
        $output .= '<a href="' . esc_url($item->url) . '" 
                       class="nav-link">'
            . $item->title . '</a>';
    }
}

/**
 * Custom Navigation Walker for Mobile Menu
 */
class Mon_Theme_ACA_Mobile_Nav_Walker extends Walker_Nav_Menu
{
    /**
     * Starts the element output.
     */
    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $classes = empty($item->classes) ? array() : (array) $item->classes;

        // Add classes for styling
        $classes[] = 'menu-item-' . $item->ID;

        // Filter the CSS class
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        // Build HTML
        $output .= '<a href="' . esc_url($item->url) . '" 
                       class="mobile-menu-item">'
            . $item->title . '</a>';
    }
}

/**
 * Change excerpt length
 */
function mon_theme_aca_excerpt_length($length)
{
    return 25;
}
add_filter('excerpt_length', 'mon_theme_aca_excerpt_length');

/**
 * Change excerpt more string
 */
function mon_theme_aca_excerpt_more($more)
{
    return '...';
}
add_filter('excerpt_more', 'mon_theme_aca_excerpt_more');

/**
 * Add responsive container to embeds
 */
function mon_theme_aca_embed_html($html)
{
    return '<div class="responsive-embed">' . $html . '</div>';
}
add_filter('embed_oembed_html', 'mon_theme_aca_embed_html', 10, 3);
