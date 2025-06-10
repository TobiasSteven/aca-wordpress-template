<?php

/**
 * Custom template tags for this theme.
 */
require MON_THEME_ACA_DIR . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require MON_THEME_ACA_DIR . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require MON_THEME_ACA_DIR . '/inc/customizer.php';

/**
 * Includes
 */
require MON_THEME_ACA_DIR . '/inc/footer-customizer.php'; // Ajout de la personnalisation du footer

/**
 * Custom comment callback for modern design
 */
function mon_theme_aca_comment_callback($comment, $args, $depth)
{
    if ('div' === $args['style']) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }

    $classes = ' class="comment"';
?>
    <<?php echo $tag; ?><?php echo $classes; ?> id="comment-<?php comment_ID(); ?>">

        <div class="comment-header">
            <?php if ($args['avatar_size'] != 0) : ?>
                <?php echo get_avatar($comment, $args['avatar_size'], '', '', array('class' => 'avatar')); ?>
            <?php endif; ?>

            <div class="comment-author-info">
                <div class="comment-author vcard">
                    <?php
                    $author_name = get_comment_author();
                    if (!empty($comment->comment_author_url)) {
                        printf('<a class="fn" href="%s" rel="external nofollow" class="url">%s</a>', $comment->comment_author_url, $author_name);
                    } else {
                        printf('<span class="fn">%s</span>', $author_name);
                    }
                    ?>
                </div>

                <div class="comment-metadata">
                    <time datetime="<?php comment_time('c'); ?>">
                        <?php
                        printf('%s', get_comment_date('j F Y'));
                        ?>
                    </time>
                    <?php edit_comment_link(__('Modifier', 'mon-theme-aca'), '  ', ''); ?>
                </div>
            </div>
        </div>

        <div class="comment-content">
            <?php if ($comment->comment_approved == '0') : ?>
                <em class="comment-awaiting-moderation"><?php _e('Votre commentaire est en attente de modération.', 'mon-theme-aca'); ?></em>
                <br />
            <?php endif; ?>
            <?php comment_text(); ?>
        </div>

        <div class="reply">
            <?php
            comment_reply_link(
                array_merge(
                    $args,
                    array(
                        'add_below' => $add_below,
                        'depth'     => $depth,
                        'max_depth' => $args['max_depth'],
                        'reply_text' => __('Répondre', 'mon-theme-aca'),
                    )
                )
            );
            ?>
        </div>
    <?php
}
