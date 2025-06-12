<?php

/**
 * Render template for Filtered Posts block
 */

/**
 * Fonction helper pour rendre la grille d'articles
 */
if (!function_exists('mon_theme_aca_render_posts_grid')) {
    function mon_theme_aca_render_posts_grid($posts_query)
    {
        if (!$posts_query->have_posts()) {
            return '<p class="no-posts">' . __('Aucun article trouvé.', 'mon-theme-aca') . '</p>';
        }

        $date_colors = ['date-green', 'date-blue', 'date-green'];
        $output = '<div class="news-cards-container">';
        $post_index = 0;

        while ($posts_query->have_posts()) :
            $posts_query->the_post();
            $date_color_class = $date_colors[$post_index % count($date_colors)];
            $post_index++;

            $output .= '<article class="news-card">';
            $output .= '<div class="card-image-container">';

            if (has_post_thumbnail()) {
                $output .= get_the_post_thumbnail(get_the_ID(), 'medium', [
                    'alt' => get_the_title(),
                    'loading' => 'lazy'
                ]);
            } else {
                $output .= '<div class="placeholder-image">' . __('Pas d\'image', 'mon-theme-aca') . '</div>';
            }

            $output .= '<span class="card-date ' . esc_attr($date_color_class) . '">';
            $output .= strtoupper(get_the_date('j M Y'));
            $output .= '</span>';
            $output .= '</div>';

            $output .= '<div class="card-content">';

            // Métadonnées de l'article
            $output .= '<div class="article-meta">';
            $output .= esc_html(get_the_date('j F Y')) . ' • ' .
                esc_html(ceil(str_word_count(strip_tags(get_the_content())) / 200)) . ' min de lecture';
            $output .= '</div>';

            $output .= '<h3><a href="' . get_permalink() . '" title="' . esc_attr(get_the_title()) . '">';
            $output .= get_the_title();
            $output .= '</a></h3>';

            $output .= '<p>' . wp_trim_words(get_the_excerpt(), 20, '...') . '</p>';

            // Tags de l'article
            $post_tags = get_the_tags();
            if (!empty($post_tags)) {
                $output .= '<div class="article-tags">';
                foreach (array_slice($post_tags, 0, 3) as $tag) {
                    $output .= '<span class="tag">#' . esc_html($tag->name) . '</span>';
                }
                $output .= '</div>';
            }

            // Auteur de l'article
            $output .= '<div class="article-author">';
            $output .= sprintf(__('Par: %s', 'mon-theme-aca'), get_the_author());
            $output .= '</div>';

            // Actions de l'article
            $output .= '<div class="article-actions">';
            $output .= '<a href="' . get_permalink() . '" class="read-more" title="' . esc_attr(get_the_title()) . '">';
            $output .= __('Lire plus', 'mon-theme-aca');
            $output .= '</a>';
            $output .= '<div class="action-buttons">';
            $output .= '<button class="action-btn share-btn" title="' . __('Partager', 'mon-theme-aca') . '"></button>';
            $output .= '<button class="action-btn bookmark-btn" title="' . __('Marquer comme favori', 'mon-theme-aca') . '"></button>';
            $output .= '</div>';
            $output .= '</div>';

            $output .= '</div>';
            $output .= '</article>';
        endwhile;

        $output .= '</div>';
        return $output;
    }
}

/**
 * Fonction helper pour rendre la pagination
 */
if (!function_exists('mon_theme_aca_render_pagination')) {
    function mon_theme_aca_render_pagination($posts_query, $pagination_type)
    {
        if ($pagination_type === 'load-more') {
            if ($posts_query->max_num_pages > 1) {
                return '<button class="load-more-btn" data-page="1" data-max-pages="' . $posts_query->max_num_pages . '">' .
                    __('Charger plus d\'articles', 'mon-theme-aca') . '</button>';
            }
            return '';
        }

        // Pagination numérotée
        $pagination = paginate_links([
            'total' => $posts_query->max_num_pages,
            'current' => 1,
            'format' => '?paged=%#%',
            'show_all' => false,
            'end_size' => 1,
            'mid_size' => 2,
            'prev_next' => true,
            'prev_text' => '← ' . __('Précédent', 'mon-theme-aca'),
            'next_text' => __('Suivant', 'mon-theme-aca') . ' →',
            'type' => 'plain',
            'add_args' => false,
        ]);

        return $pagination ? '<nav class="pagination-nav">' . $pagination . '</nav>' : '';
    }
}

// Récupérer les attributs du block
$section_title = $attributes['sectionTitle'] ?? __('Articles', 'mon-theme-aca');
$posts_per_page = $attributes['postsPerPage'] ?? 6;
$show_search_filter = $attributes['showSearchFilter'] ?? true;
$show_category_filter = $attributes['showCategoryFilter'] ?? true;
$show_temporal_filter = $attributes['showTemporalFilter'] ?? true;
$show_geographic_filter = $attributes['showGeographicFilter'] ?? true;
$show_sort_controls = $attributes['showSortControls'] ?? true;
$show_pagination = $attributes['showPagination'] ?? true;
$pagination_type = $attributes['paginationType'] ?? 'numbered';
$default_sort_by = $attributes['defaultSortBy'] ?? 'date';
$default_order = $attributes['defaultOrder'] ?? 'desc';

// Arguments pour la requête WP_Query initiale
$query_args = [
    'post_type' => 'post',
    'posts_per_page' => $posts_per_page,
    'post_status' => 'publish',
    'orderby' => $default_sort_by,
    'order' => $default_order,
    'paged' => 1,
];

// Effectuer la requête initiale
$posts_query = new WP_Query($query_args);

// Récupérer les catégories pour les filtres
$categories = get_categories([
    'hide_empty' => true,
    'orderby' => 'name',
    'order' => 'ASC',
]);

// Récupérer les taxonomies personnalisées si elles existent
$temporal_terms = [];
$geographic_terms = [];

if (taxonomy_exists('filtres_temporels')) {
    $temporal_terms = get_terms([
        'taxonomy' => 'filtres_temporels',
        'hide_empty' => true,
    ]);
}

if (taxonomy_exists('filtres_geographiques')) {
    $geographic_terms = get_terms([
        'taxonomy' => 'filtres_geographiques',
        'hide_empty' => true,
    ]);
}

// Générer un ID unique pour le bloc
$block_id = 'filtered-posts-' . wp_unique_id();

// Obtenir les classes du block
$wrapper_attributes = get_block_wrapper_attributes([
    'class' => 'wp-block-mon-theme-aca-filtered-posts',
    'data-block-id' => $block_id,
    'data-posts-per-page' => $posts_per_page,
    'data-pagination-type' => $pagination_type,
    'data-default-sort' => $default_sort_by,
    'data-default-order' => $default_order,
]);
?>

<div <?php echo $wrapper_attributes; ?>>
    <div class="filtered-posts-container">
        <h2 class="section-title"><?php echo esc_html($section_title); ?></h2>

        <div class="filtered-posts-layout">
            <!-- Barre latérale de filtres -->
            <aside class="filters-sidebar">
                <h3 class="filters-title"><?php _e('Filtres', 'mon-theme-aca'); ?></h3>

                <form class="filters-form" id="<?php echo esc_attr($block_id); ?>-filters">
                    <?php if ($show_search_filter) : ?>
                        <div class="filter-group search-filter">
                            <label for="<?php echo esc_attr($block_id); ?>-search">
                                <?php _e('Recherche', 'mon-theme-aca'); ?>
                            </label>
                            <input type="text"
                                id="<?php echo esc_attr($block_id); ?>-search"
                                name="search"
                                placeholder="<?php esc_attr_e('Rechercher...', 'mon-theme-aca'); ?>"
                                class="search-input">
                        </div>
                    <?php endif; ?>

                    <?php if ($show_category_filter && !empty($categories)) : ?>
                        <div class="filter-group category-filter">
                            <label><?php _e('Catégories', 'mon-theme-aca'); ?></label>
                            <div class="checkbox-group">
                                <?php foreach ($categories as $category) : ?>
                                    <label class="checkbox-label">
                                        <input type="checkbox"
                                            name="categories[]"
                                            value="<?php echo esc_attr($category->term_id); ?>"
                                            class="category-checkbox">
                                        <span><?php echo esc_html($category->name); ?></span>
                                        <small>(<?php echo $category->count; ?>)</small>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($show_temporal_filter && !empty($temporal_terms)) : ?>
                        <div class="filter-group temporal-filter">
                            <label for="<?php echo esc_attr($block_id); ?>-temporal">
                                <?php _e('Filtres Temporels', 'mon-theme-aca'); ?>
                            </label>
                            <select id="<?php echo esc_attr($block_id); ?>-temporal"
                                name="temporal_filter"
                                class="temporal-select">
                                <option value=""><?php _e('Tous', 'mon-theme-aca'); ?></option>
                                <?php foreach ($temporal_terms as $term) : ?>
                                    <option value="<?php echo esc_attr($term->term_id); ?>">
                                        <?php echo esc_html($term->name); ?> (<?php echo $term->count; ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>

                    <?php if ($show_geographic_filter && !empty($geographic_terms)) : ?>
                        <div class="filter-group geographic-filter">
                            <label for="<?php echo esc_attr($block_id); ?>-geographic">
                                <?php _e('Filtres Géographiques', 'mon-theme-aca'); ?>
                            </label>
                            <select id="<?php echo esc_attr($block_id); ?>-geographic"
                                name="geographic_filter"
                                class="geographic-select">
                                <option value=""><?php _e('Tous', 'mon-theme-aca'); ?></option>
                                <?php foreach ($geographic_terms as $term) : ?>
                                    <option value="<?php echo esc_attr($term->term_id); ?>">
                                        <?php echo esc_html($term->name); ?> (<?php echo $term->count; ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>

                    <!-- Section Newsletter -->
                    <div class="newsletter-section">
                        <h3><?php _e('Newsletter', 'mon-theme-aca'); ?></h3>
                        <form class="newsletter-form">
                            <input type="email" placeholder="<?php esc_attr_e('Votre email', 'mon-theme-aca'); ?>" required>
                            <button type="submit" class="subscribe-btn">
                                <?php _e('S\'inscrire', 'mon-theme-aca'); ?>
                            </button>
                        </form>
                    </div>

                    <button type="button" class="reset-filters-btn">
                        <?php _e('Réinitialiser les filtres', 'mon-theme-aca'); ?>
                    </button>
                </form>
            </aside>

            <!-- Zone de contenu principal -->
            <main class="posts-content">
                <?php if ($show_sort_controls) : ?>
                    <div class="posts-controls">
                        <div class="view-controls">
                            <button class="view-btn" data-view="grid" title="<?php _e('Vue en grille', 'mon-theme-aca'); ?>">⊞</button>
                            <button class="view-btn active" data-view="cards" title="<?php _e('Vue en cartes', 'mon-theme-aca'); ?>">☰</button>
                            <button class="view-btn" data-view="list" title="<?php _e('Vue en liste', 'mon-theme-aca'); ?>">▤</button>
                        </div>

                        <div class="sort-controls">
                            <span><?php _e('Trier par:', 'mon-theme-aca'); ?></span>
                            <select id="<?php echo esc_attr($block_id); ?>-sort" class="sort-select">
                                <option value="date" <?php selected($default_sort_by, 'date'); ?>>
                                    <?php _e('Date', 'mon-theme-aca'); ?>
                                </option>
                                <option value="title" <?php selected($default_sort_by, 'title'); ?>>
                                    <?php _e('Titre', 'mon-theme-aca'); ?>
                                </option>
                                <option value="author" <?php selected($default_sort_by, 'author'); ?>>
                                    <?php _e('Auteur', 'mon-theme-aca'); ?>
                                </option>
                            </select>

                            <select id="<?php echo esc_attr($block_id); ?>-order" class="order-select">
                                <option value="desc" <?php selected($default_order, 'desc'); ?>>
                                    <?php _e('Décroissant', 'mon-theme-aca'); ?>
                                </option>
                                <option value="asc" <?php selected($default_order, 'asc'); ?>>
                                    <?php _e('Croissant', 'mon-theme-aca'); ?>
                                </option>
                            </select>
                        </div>

                        <div class="per-page-controls">
                            <span><?php echo $posts_per_page; ?> <?php _e('par page', 'mon-theme-aca'); ?></span>
                            <select id="<?php echo esc_attr($block_id); ?>-per-page" class="per-page-select">
                                <option value="6" <?php selected($posts_per_page, 6); ?>>6</option>
                                <option value="9" <?php selected($posts_per_page, 9); ?>>9</option>
                                <option value="12" <?php selected($posts_per_page, 12); ?>>12</option>
                                <option value="18" <?php selected($posts_per_page, 18); ?>>18</option>
                            </select>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Zone de chargement -->
                <div class="loading-overlay" style="display: none;">
                    <div class="loading-spinner"></div>
                    <p><?php _e('Chargement...', 'mon-theme-aca'); ?></p>
                </div>

                <!-- Grille d'articles -->
                <div class="posts-grid" id="<?php echo esc_attr($block_id); ?>-posts">
                    <?php echo mon_theme_aca_render_posts_grid($posts_query); ?>
                </div>

                <!-- Pagination -->
                <div class="posts-pagination" id="<?php echo esc_attr($block_id); ?>-pagination">
                    <?php if ($show_pagination && $posts_query->max_num_pages > 1) : ?>
                        <?php echo mon_theme_aca_render_pagination_with_current($posts_query, $pagination_type, 1); ?>
                    <?php endif; ?>
                </div>

                <!-- Aucun résultat -->
                <div class="no-posts-found" style="display: none;">
                    <p><?php _e('Aucun article trouvé avec ces critères.', 'mon-theme-aca'); ?></p>
                </div>
            </main>
        </div>
    </div>
</div>

<?php
wp_reset_postdata();
?>