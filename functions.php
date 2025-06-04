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
require_once MON_THEME_ACA_DIR . '/functions-parts/theme-includes.php';
