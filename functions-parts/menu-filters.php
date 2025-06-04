<?php

/**
 * Add CSS classes to menu items
 */
function mon_theme_aca_add_menu_link_class($atts, $item, $args)
{
    if (property_exists($args, 'link_class')) {
        $atts['class'] = $args->link_class;
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'mon_theme_aca_add_menu_link_class', 1, 3);
