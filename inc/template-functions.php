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
