<?php

/**
 * The template for displaying comments
 *
 * @package Mon-Theme-ACA
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php
    // You can start editing here -- including this comment!
    if (have_comments()) :
    ?>
        <h2 class="comments-title">
            <?php
            $mon_theme_aca_comment_count = get_comments_number();
            if ('1' === $mon_theme_aca_comment_count) {
                printf(
                    /* translators: 1: title. */
                    esc_html__('Un commentaire sur &ldquo;%1$s&rdquo;', 'mon-theme-aca'),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            } else {
                printf(
                    /* translators: 1: comment count number, 2: title. */
                    esc_html(_nx('%1$s commentaire sur &ldquo;%2$s&rdquo;', '%1$s commentaires sur &ldquo;%2$s&rdquo;', $mon_theme_aca_comment_count, 'comments title', 'mon-theme-aca')),
                    number_format_i18n($mon_theme_aca_comment_count),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            }
            ?>
        </h2><!-- .comments-title -->

        <?php the_comments_navigation(); ?>

        <ol class="comment-list">
            <?php
            wp_list_comments(
                array(
                    'style'      => 'ol',
                    'short_ping' => true,
                )
            );
            ?>
        </ol><!-- .comment-list -->

        <?php
        the_comments_navigation();

        // If comments are closed and there are comments, let's leave a little note, shall we?
        if (!comments_open()) :
        ?>
            <p class="no-comments"><?php esc_html_e('Les commentaires sont fermés.', 'mon-theme-aca'); ?></p>
    <?php
        endif;

    endif; // Check for have_comments().

    comment_form(
        array(
            'title_reply'          => esc_html__('Laisser un commentaire', 'mon-theme-aca'),
            'title_reply_to'       => esc_html__('Répondre à %s', 'mon-theme-aca'),
            'comment_notes_before' => '<p class="comment-notes">' . esc_html__('Votre adresse e-mail ne sera pas publiée. Les champs obligatoires sont indiqués *', 'mon-theme-aca') . '</p>',
            'label_submit'         => esc_html__('Publier le commentaire', 'mon-theme-aca'),
            'cancel_reply_link'    => esc_html__('Annuler la réponse', 'mon-theme-aca'),
        )
    );
    ?>

</div><!-- #comments -->