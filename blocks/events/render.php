<?php
/**
 * Server-side rendering for Events Block (Configurable)
 *
 * @package Mon-Theme-ACA
 */

// Attributs du bloc
$attributes = $attributes ?? [];
$section_title = $attributes['sectionTitle'] ?? __('Événements à Venir', 'mon-theme-aca');
$section_subtitle = $attributes['sectionSubtitle'] ?? __("Participez aux événements qui façonnent l'avenir de la filière cotonnière africaine", 'mon-theme-aca');
$show_calendar = $attributes['showCalendar'] ?? true;
$event_items = $attributes['eventItems'] ?? [];

// Nouveaux attributs pour l'affichage
$show_event_type = $attributes['showEventType'] ?? true;
$show_time = $attributes['showTime'] ?? true;
$show_location = $attributes['showLocation'] ?? true;
$show_participants = $attributes['showParticipants'] ?? true;

// Récupérer uniquement les dates pour le calendrier
$all_event_dates = array_column($event_items, 'date');

// Fonctions helpers
if (!function_exists('mon_theme_aca_get_event_type_color')) {
    function mon_theme_aca_get_event_type_color($type) {
        switch (strtolower($type)) {
            case 'conférence': return 'bg-conference';
            case 'atelier': return 'bg-atelier';
            case 'assemblée': return 'bg-assemblee';
            default: return 'bg-default';
        }
    }
}

// Icônes SVG
$icon_map_pin = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>';
$icon_clock = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>';
$icon_users = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 mr-2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>';

?>

<div <?php echo get_block_wrapper_attributes(['class' => 'wp-block-mon-theme-aca-events']); ?>>
    <section class="container">
        <div class="section-header">
            <h2 class="section-title"><?php echo esc_html($section_title); ?></h2>
            <p class="section-subtitle"><?php echo esc_html($section_subtitle); ?></p>
        </div>

        <div class="events-layout">
            <?php if ($show_calendar) : ?>
                <div class="calendar-wrapper">
                    <div class="calendar-component" data-event-dates='<?php echo json_encode($all_event_dates); ?>'>
                        <div class="calendar-header-controls">
                            <h3 class="calendar-month-year-title"></h3>
                            <div class="calendar-nav">
                                <button class="calendar-nav-btn" data-direction="prev" aria-label="<?php esc_attr_e('Mois précédent', 'mon-theme-aca'); ?>">‹</button>
                                <button class="calendar-nav-btn" data-direction="next" aria-label="<?php esc_attr_e('Mois suivant', 'mon-theme-aca'); ?>">›</button>
                            </div>
                        </div>
                        <div class="calendar-grid-header"></div>
                        <div class="calendar-grid-body"></div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="events-list-wrapper">
                <?php if (!empty($event_items)) : ?>
                    <?php foreach ($event_items as $event) :
                        $date_obj = new DateTime($event['date'] ?? 'now');
                    ?>
                        <div class="event-card">
                            <div class="event-card-date">
                                <div class="day"><?php echo esc_html($date_obj->format('d')); ?></div>
                                <div class="month"><?php echo esc_html(ucfirst($date_obj->format('M'))); ?></div>
                            </div>
                            <div class="event-card-details">
                                <div class="event-header">
                                    <h3 class="event-title"><?php echo esc_html($event['title'] ?? ''); ?></h3>
                                    <?php if ($show_event_type && !empty($event['type'])) : ?>
                                        <span class="event-type-badge <?php echo esc_attr(mon_theme_aca_get_event_type_color($event['type'])); ?>">
                                            <?php echo esc_html($event['type']); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="event-meta">
                                    <?php if ($show_location && !empty($event['location'])) : ?>
                                        <div class="meta-item"><?php echo $icon_map_pin; ?><span><?php echo esc_html($event['location']); ?></span></div>
                                    <?php endif; ?>
                                    <?php if ($show_time && !empty($event['time'])) : ?>
                                        <div class="meta-item"><?php echo $icon_clock; ?><span><?php echo esc_html($event['time']); ?></span></div>
                                    <?php endif; ?>
                                    <?php if ($show_participants && !empty($event['participants'])) : ?>
                                        <div class="meta-item"><?php echo $icon_users; ?><span><?php echo esc_html($event['participants']); ?> participants attendus</span></div>
                                    <?php endif; ?>
                                </div>
                                <div class="event-actions">
                                    <a href="#" class="btn btn-primary"><?php _e("S'inscrire", 'mon-theme-aca'); ?></a>
                                    <a href="<?php echo esc_url($event['link'] ?? '#'); ?>" class="btn btn-secondary"><?php _e('Voir détails', 'mon-theme-aca'); ?></a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p><?php _e("Il n'y a pas d'événements à venir pour le moment.", 'mon-theme-aca'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>