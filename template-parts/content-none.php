<?php

/**
 * Template part for displaying a message that posts cannot be found
 *
 * @package Mon-Theme-ACA
 */

?>

<section class="no-results not-found">
    <header class="page-header">
        <h1 class="page-title"><?php esc_html_e('Rien trouvé', 'mon-theme-aca'); ?></h1>
    </header><!-- .page-header -->

    <div class="page-content">
        <?php
        if (is_home() && current_user_can('publish_posts')) :

            printf(
                '<p>' . wp_kses(
                    /* translators: 1: link to WP admin new post page. */
                    __('Prêt à publier votre premier article? <a href="%1$s">Commencez ici</a>.', 'mon-theme-aca'),
                    array(
                        'a' => array(
                            'href' => array(),
                        ),
                    )
                ) . '</p>',
                esc_url(admin_url('post-new.php'))
            );

        elseif (is_search()) :
        ?>

            <p><?php esc_html_e('Désolé, mais rien ne correspond à vos termes de recherche. Veuillez réessayer avec des mots-clés différents.', 'mon-theme-aca'); ?></p>
        <?php
            get_search_form();

        else :
        ?>

            <p><?php esc_html_e('Il semble que nous ne pouvons pas trouver ce que vous cherchez. Peut-être que la recherche peut aider.', 'mon-theme-aca'); ?></p>
        <?php
            get_search_form();

        endif;
        ?>
    </div><!-- .page-content -->
</section><!-- .no-results -->