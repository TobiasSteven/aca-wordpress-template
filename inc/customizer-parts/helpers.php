<?php

/**
 * Customizer Helper Functions
 * Contains utility functions, sanitization callbacks, and other helpers for the customizer
 *
 * @package Mon-Theme-ACA
 */

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

/**
 * Get available navigation menus for customizer select dropdown
 *
 * @return array Array of menu choices with ID as key and name as value
 */
function mon_theme_aca_get_menu_choices()
{
    $menus = wp_get_nav_menus();
    $choices = array(
        0 => __('— Sélectionner un menu —', 'mon-theme-aca')
    );

    foreach ($menus as $menu) {
        $choices[$menu->term_id] = $menu->name;
    }

    return $choices;
}
