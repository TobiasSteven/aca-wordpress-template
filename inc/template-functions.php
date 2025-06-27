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

        // Filter the CSS class to get WordPress default classes like current-menu-item
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));

        // Check if the item is active
        $is_active = in_array('current-menu-item', $classes) || in_array('current_page_item', $classes);
        
        // Build the button class based on active state
        $button_class = 'px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200 ';
        $button_class .= $is_active 
            ? 'bg-[#2D9B8A] text-white' 
            : 'text-white hover:bg-[#A8E6CF] hover:text-[#1F6B5C]';

        // Build HTML
        $output .= '<button onclick="window.location.href=\'' . esc_url($item->url) . '\'"
                       class="' . $button_class . '">'
            . $item->title . '</button>';
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

        // Filter the CSS class to get WordPress default classes like current-menu-item
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));

        // Check if the item is active
        $is_active = in_array('current-menu-item', $classes) || in_array('current_page_item', $classes);
        
        // Build the button class based on active state
        $button_class = 'block w-full text-left px-4 py-2 rounded-md text-sm font-medium transition-colors ';
        $button_class .= $is_active 
            ? 'bg-[#2D9B8A] text-white' 
            : 'text-white hover:bg-[#A8E6CF] hover:text-[#1F6B5C]';

        // Build HTML
        $output .= '<button onclick="window.location.href=\'' . esc_url($item->url) . '\'"
                       class="' . $button_class . '">'
            . $item->title . '</button>';
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

/**
 * Add custom CSS to ensure all hover states use theme green color
 */
function mon_theme_aca_add_hover_styles() {
    ?>
<style>
/* Ensure all hover states use theme green color */
a:hover,
button:hover:not(.bg-[#28A745]),
.nav-link:hover,
.menu-item a:hover,
.footer-link:hover,
.wp-block-button__link:hover,
.lang-dropdown-item:hover,
#mobile-menu button:hover,
#mobile-menu a:hover,
.site-footer a:hover {
    color: #2D9B8A !important;
}

/* Button hover styles */
button:hover,
button:hover,
input[type="button"]:hover,
input[type="reset"]:hover,
input[type="submit"]:hover {
    background-color: #2D9B8A !important;
    color: white !important;
}

/* Special case for buttons with white text on hover */
.bg-[#28A745]:hover,
.member-button:hover,
button.bg-[#28A745]:hover {
    background-color: #1F6B5C !important;
    color: white !important;
}

/* Ensure all hover underlines use theme green color */
.nav-link::before,
.main-navigation a::before,
#primary-menu a::before,
[class*="primary-menu"] a::before,
.menu-item a::before {
    background-color: #2D9B8A !important;
}
</style>
<?php
}
add_action('wp_head', 'mon_theme_aca_add_hover_styles', 100);