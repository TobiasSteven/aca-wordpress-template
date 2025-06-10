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

<div id="comments" class="comments-area theme-comments-area">

    <?php
    // You can start editing here -- including this comment!
    if (have_comments()) :
    ?>
        <h2 class="comments-title theme-comments-title">
            Commentaires (<?php echo get_comments_number(); ?>)
        </h2><!-- .comments-title -->

        <?php the_comments_navigation(); ?>

        <ol class="comment-list theme-comment-list">
            <?php
            wp_list_comments(
                array(
                    'style'       => 'ol',
                    'short_ping'  => true,
                    'avatar_size' => 40,
                    'format'      => 'html5',
                    'callback'    => 'mon_theme_aca_comment_callback',
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
            'comment_notes_before' => '<p class="comment-notes">' . esc_html__('Votre adresse e-mail ne sera pas publiée. Les champs obligatoires sont indiqués avec *', 'mon-theme-aca') . '</p>',
            'label_submit'         => esc_html__('Publier le commentaire', 'mon-theme-aca'),
            'cancel_reply_link'    => esc_html__('Annuler la réponse', 'mon-theme-aca'),
            'class_form'           => 'theme-comment-form',
            'class_submit'         => 'btn btn-success-green',
            'submit_button'        => '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />',
        )
    );
    ?>

</div><!-- #comments -->