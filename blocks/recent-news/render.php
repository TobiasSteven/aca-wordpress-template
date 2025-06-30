<?php
/**
 * Render template for Recent News block
 *
 * @package Mon-Theme-ACA
 */

// Attributs du bloc avec valeurs par défaut sécurisées
$section_title = $attributes['sectionTitle'] ?? __('Dernières Actualités', 'mon-theme-aca');
$section_subtitle = $attributes['sectionSubtitle'] ?? __('Restez informé des dernières nouvelles et développements de la filière cotonnière africaine', 'mon-theme-aca');
$news_items = $attributes['newsItems'] ?? [];

// Nouveaux attributs pour l'affichage
$show_category = $attributes['showCategory'] ?? true;
$show_date = $attributes['showDate'] ?? true;
$show_read_time = $attributes['showReadTime'] ?? true;
$show_read_more = $attributes['showReadMore'] ?? true;


$wrapper_attributes = get_block_wrapper_attributes([
    'class' => 'wp-block-mon-theme-aca-recent-news'
]);

if (!function_exists('mon_theme_aca_get_category_color_class')) {
    function mon_theme_aca_get_category_color_class($category) {
        switch (strtolower($category)) {
            case 'production': return 'bg-production';
            case 'marché': return 'bg-marche';
            case 'innovation': return 'bg-innovation';
            default: return 'bg-default';
        }
    }
}

$icon_calendar = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-1"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>';
$icon_tag = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-1"><path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"/><path d="M7 7h.01"/></svg>';
$icon_arrow_right = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 ml-1"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>';

?>

<div <?php echo $wrapper_attributes; ?>>
    <section class="recent-news-section">
        <div class="section-header">
            <h2 class="section-title"><?php echo esc_html($section_title); ?></h2>
            <p class="section-subtitle"><?php echo esc_html($section_subtitle); ?></p>
        </div>

        <?php if (!empty($news_items)) : ?>
            <div class="news-grid">
                <?php foreach ($news_items as $item) : ?>
                    <article class="news-article group">
                        <div class="image-container">
                            <a href="<?php echo esc_url($item['link'] ?? '#'); ?>">
                                <?php if (!empty($item['image'])) : ?>
                                    <img src="<?php echo esc_url($item['image']); ?>" alt="<?php echo esc_attr($item['title'] ?? ''); ?>" class="news-image" />
                                <?php else : ?>
                                    <div class="placeholder-image"><span><?php _e('Image non disponible', 'mon-theme-aca'); ?></span></div>
                                <?php endif; ?>
                            </a>
                            
                            <?php if ($show_category && !empty($item['category'])) : ?>
                                <div class="category-badge-wrapper">
                                    <span class="category-badge <?php echo esc_attr(mon_theme_aca_get_category_color_class($item['category'])); ?>">
                                        <?php echo esc_html($item['category']); ?>
                                    </span>
                                </div>
                            <?php endif; ?>

                            <?php if ($show_date && !empty($item['date'])) : ?>
                                <div class="date-badge-wrapper">
                                    <span class="date-badge">
                                        <?php echo $icon_calendar; ?>
                                        <?php echo esc_html($item['date']); ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="content-container">
                            <h3 class="news-title">
                                <a href="<?php echo esc_url($item['link'] ?? '#'); ?>">
                                    <?php echo esc_html($item['title'] ?? ''); ?>
                                </a>
                            </h3>

                            <?php if (!empty($item['excerpt'])) : ?>
                                <p class="news-excerpt"><?php echo esc_html($item['excerpt']); ?></p>
                            <?php endif; ?>
                            
                            <div class="meta-container">
                                <?php if ($show_read_time && !empty($item['readTime'])) : ?>
                                <span class="read-time">
                                    <?php echo $icon_tag; ?>
                                    <?php echo esc_html($item['readTime']); ?> de lecture
                                </span>
                                <?php else: // Ajoute un espace vide pour garder l'alignement si le bouton est seul ?>
                                <span></span>
                                <?php endif; ?>

                                <?php if ($show_read_more) : ?>
                                <a href="<?php echo esc_url($item['link'] ?? '#'); ?>" class="read-more-button">
                                    <?php _e('Lire plus', 'mon-theme-aca'); ?>
                                    <?php echo $icon_arrow_right; ?>
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <div class="view-all-container">
                <a href="<?php echo get_post_type_archive_link('post'); ?>" class="view-all-button">
                    <?php _e('Voir toutes les actualités', 'mon-theme-aca'); ?>
                </a>
            </div>

        <?php else : ?>
            <p class="no-posts"><?php _e('Aucune actualité à afficher.', 'mon-theme-aca'); ?></p>
        <?php endif; ?>
    </section>
</div>