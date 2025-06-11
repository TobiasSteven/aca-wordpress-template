<?php

/**
 * Render template for Featured Post block
 */

// Récupérer les attributs du block
$filter_type = $attributes['filterType'] ?? 'category';
$selected_category = $attributes['selectedCategory'] ?? 0;
$selected_tag = $attributes['selectedTag'] ?? 0;

// Arguments pour la requête WP_Query
$query_args = [
    'post_type' => 'post',
    'posts_per_page' => 1,
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'desc',
];

// Ajouter le filtre selon le type sélectionné
if ($filter_type === 'category' && $selected_category > 0) {
    $query_args['category__in'] = [$selected_category];
} elseif ($filter_type === 'tag' && $selected_tag > 0) {
    $query_args['tag__in'] = [$selected_tag];
}

// Effectuer la requête
$featured_post_query = new WP_Query($query_args);

// Obtenir les classes du block avec alignement par défaut
$wrapper_attributes = get_block_wrapper_attributes([
    'class' => 'wp-block-mon-theme-aca-featured-post alignfull'
]);

// Si l'attribut align existe et n'est pas "full", on ajuste la classe
if (isset($attributes['align']) && $attributes['align'] !== 'full') {
    $wrapper_attributes = get_block_wrapper_attributes([
        'class' => 'wp-block-mon-theme-aca-featured-post align' . $attributes['align']
    ]);
} else {
    // Par défaut, on met en pleine largeur
    $wrapper_attributes = get_block_wrapper_attributes([
        'class' => 'wp-block-mon-theme-aca-featured-post alignfull'
    ]);
}

// Fonction pour obtenir l'extrait personnalisé
if (!function_exists('get_custom_excerpt')) {
    function get_custom_excerpt($post_id, $length = 150)
    {
        $post = get_post($post_id);
        $excerpt = '';

        if ($post->post_excerpt) {
            $excerpt = $post->post_excerpt;
        } else {
            $excerpt = wp_strip_all_tags($post->post_content);
        }

        if (strlen($excerpt) > $length) {
            $excerpt = substr($excerpt, 0, $length) . '...';
        }

        return $excerpt;
    }
}
?>

<div <?php echo $wrapper_attributes; ?>>
    <?php if ($featured_post_query->have_posts()) : ?>
        <?php while ($featured_post_query->have_posts()) : $featured_post_query->the_post(); ?>
            <section class="hero-section">
                <div class="container">
                    <div class="content-wrapper">
                        <div class="text-content">
                            <span class="featured-badge"><?php _e('FEATURED', 'mon-theme-aca'); ?></span>
                            <h1 class="main-title"><?php the_title(); ?></h1>
                            <p class="subtitle"><?php echo esc_html(get_custom_excerpt(get_the_ID())); ?></p>
                            <p class="author-info">
                                <?php _e('Par', 'mon-theme-aca'); ?> <?php the_author(); ?> | <?php echo get_the_date('j F Y'); ?>
                            </p>
                            <a href="<?php the_permalink(); ?>" class="cta-button"><?php _e('Lire l\'article', 'mon-theme-aca'); ?></a>
                        </div>
                        <div class="image-section">
                            <?php if (has_post_thumbnail()) : ?>
                                <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>" alt="<?php the_title_attribute(); ?>" class="hero-image">
                            <?php else : ?>
                                <img src="https://picsum.photos/seed/cotton/600/500" alt="<?php the_title_attribute(); ?>" class="hero-image">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </section>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
    <?php else : ?>
        <section class="hero-section">
            <div class="container">
                <div class="content-wrapper">
                    <div class="text-content">
                        <p><?php _e('Aucun article en vedette trouvé.', 'mon-theme-aca'); ?></p>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
</div>