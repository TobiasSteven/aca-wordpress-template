<?php

/**
 * Functions and definitions
 *
 * @package Mon-Theme-ACA
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Include theme parts
 */
require_once get_template_directory() . '/functions-parts/constants.php';
require_once MON_THEME_ACA_DIR . '/functions-parts/theme-setup.php';
require_once MON_THEME_ACA_DIR . '/functions-parts/widgets.php';
require_once MON_THEME_ACA_DIR . '/functions-parts/enqueue.php';
require_once MON_THEME_ACA_DIR . '/functions-parts/menu-filters.php';
require_once MON_THEME_ACA_DIR . '/functions-parts/events.php';
require_once MON_THEME_ACA_DIR . '/functions-parts/blocks.php';
require_once MON_THEME_ACA_DIR . '/functions-parts/theme-includes.php';

/**
 * Ensure threaded comments are enabled
 */
function mon_theme_aca_enable_threaded_comments()
{
    if (!get_option('thread_comments')) {
        update_option('thread_comments', 1);
    }

    // Set maximum comment depth to 5 if not already set
    if (get_option('thread_comments_depth') < 3) {
        update_option('thread_comments_depth', 5);
    }
}
add_action('after_setup_theme', 'mon_theme_aca_enable_threaded_comments');
