<?php

/**
 * Render template for Recent News block
 */

// Récupérer les attributs du block
$section_title = $attributes['sectionTitle'] ?? __('Actualités Récentes', 'mon-theme-aca');
$number_of_posts = $attributes['numberOfPosts'] ?? 3;
$selected_categories = $attributes['selectedCategories'] ?? [];
$show_date = $attributes['showDate'] ?? true;
$show_excerpt = $attributes['showExcerpt'] ?? true;
$order_by = $attributes['orderBy'] ?? 'date';
$order = $attributes['order'] ?? 'desc';

// Arguments pour la requête WP_Query
$query_args = [
    'post_type' => 'post',
    'posts_per_page' => $number_of_posts,
    'post_status' => 'publish',
    'orderby' => $order_by,
    'order' => $order,
];

// Ajouter les catégories si sélectionnées
if (!empty($selected_categories)) {
    $query_args['category__in'] = $selected_categories;
}

// Effectuer la requête
$recent_posts = new WP_Query($query_args);

// Couleurs pour les dates
$date_colors = ['date-green', 'date-blue', 'date-green'];

// Obtenir les classes du block
$wrapper_attributes = get_block_wrapper_attributes([
    'class' => 'wp-block-mon-theme-aca-recent-news'
]);
?>

<div <?php echo $wrapper_attributes; ?>>
    <section class="recent-news">
        <h2><?php echo esc_html($section_title); ?></h2>

        <?php if ($recent_posts->have_posts()) : ?>
            <div class="news-cards-container">
                <?php
                $post_index = 0;
                while ($recent_posts->have_posts()) :
                    $recent_posts->the_post();
                    $date_color_class = $date_colors[$post_index % count($date_colors)];
                    $post_index++;
                ?>
                    <article class="news-card">
                        <div class="card-image-container">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium', [
                                    'alt' => get_the_title(),
                                    'loading' => 'lazy'
                                ]); ?>
                            <?php else : ?>
                                <div class="placeholder-image">
                                    <?php _e('Pas d\'image', 'mon-theme-aca'); ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($show_date) : ?>
                                <span class="card-date <?php echo esc_attr($date_color_class); ?>">
                                    <?php echo strtoupper(get_the_date('j M Y')); ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="card-content">
                            <h3>
                                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h3>

                            <?php if ($show_excerpt) : ?>
                                <p><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
                            <?php endif; ?>

                            <a href="<?php the_permalink(); ?>" class="read-more" title="<?php the_title_attribute(); ?>">
                                <?php _e('Lire plus', 'mon-theme-aca'); ?> →
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
            <p class="no-posts"><?php _e('Aucun article trouvé avec ces paramètres.', 'mon-theme-aca'); ?></p>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>
    </section>
</div>