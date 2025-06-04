<?php

/**
 * Register widget area.
 */
function mon_theme_aca_widgets_init()
{
    register_sidebar(
        array(
            'name'          => esc_html__('Barre latérale', 'mon-theme-aca'),
            'id'            => 'sidebar-1',
            'description'   => esc_html__('Ajoutez des widgets ici.', 'mon-theme-aca'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );

    register_sidebar(
        array(
            'name'          => esc_html__('Pied de page', 'mon-theme-aca'),
            'id'            => 'footer-1',
            'description'   => esc_html__('Ajoutez des widgets pour le pied de page ici.', 'mon-theme-aca'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );
}
add_action('widgets_init', 'mon_theme_aca_widgets_init');
