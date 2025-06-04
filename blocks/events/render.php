<?php

/**
 * Server-side rendering for Events Block
 *
 * @package Mon-Theme-ACA
 */

// CSS inline de fallback pour s'assurer que les styles s'appliquent correctement
$inline_css = "
<style>
.wp-block-mon-theme-aca-events {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
    background-color: #f0f2f5 !important;
    padding: 20px !important;
}
.wp-block-mon-theme-aca-events .main-container {
    display: flex !important;
    gap: 30px !important;
    background-color: #f0f2f5 !important;
    padding: 20px !important;
    border-radius: 10px !important;
}
.wp-block-mon-theme-aca-events .calendar-container {
    background-color: #ffffff !important;
    padding: 25px !important;
    border-radius: 12px !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
    width: 320px !important;
    height: fit-content !important;
}
.wp-block-mon-theme-aca-events .event-card {
    background-color: #ffffff !important;
    border-radius: 12px !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
    margin-bottom: 20px !important;
    display: flex !important;
    padding: 18px !important;
    align-items: flex-start !important;
}
.wp-block-mon-theme-aca-events .event-date {
    background-color: #4CAF50 !important;
    color: white !important;
    border-radius: 8px !important;
    padding: 8px 0 !important;
    width: 60px !important;
    text-align: center !important;
    margin-right: 18px !important;
    flex-shrink: 0 !important;
}
.wp-block-mon-theme-aca-events .event-date .day {
    font-size: 24px !important;
    font-weight: bold !important;
    display: block !important;
    line-height: 1.1 !important;
    margin: 0 !important;
}
.wp-block-mon-theme-aca-events .event-date .month {
    font-size: 12px !important;
    text-transform: uppercase !important;
    display: block !important;
    font-weight: 500 !important;
    margin: 0 !important;
}
.wp-block-mon-theme-aca-events .event-details h2 {
    font-size: 16px !important;
    font-weight: 600 !important;
    color: #333 !important;
    margin: 0 0 5px 0 !important;
}
.wp-block-mon-theme-aca-events .event-details .time,
.wp-block-mon-theme-aca-events .event-details .location {
    font-size: 13px !important;
    color: #777 !important;
    margin-bottom: 3px !important;
    display: flex !important;
    align-items: center !important;
}
.wp-block-mon-theme-aca-events .event-tag {
    display: inline-block !important;
    background-color: #e6f4e7 !important;
    color: #4CAF50 !important;
    font-size: 11px !important;
    font-weight: 500 !important;
    padding: 4px 10px !important;
    border-radius: 12px !important;
    margin-top: 10px !important;
}
</style>
";

echo $inline_css;

// Vérifier que $attributes existe et est un tableau
if (!isset($attributes) || !is_array($attributes)) {
    $attributes = [];
}

// Vérifier les attributs avec des valeurs par défaut sécurisées
$section_title = isset($attributes['sectionTitle']) && is_string($attributes['sectionTitle'])
    ? $attributes['sectionTitle']
    : __('Événements À Venir', 'mon-theme-aca');

$number_of_events = isset($attributes['numberOfEvents']) && is_numeric($attributes['numberOfEvents'])
    ? intval($attributes['numberOfEvents'])
    : 6;

$show_calendar = isset($attributes['showCalendar']) && is_bool($attributes['showCalendar'])
    ? $attributes['showCalendar']
    : true;

$show_event_type = isset($attributes['showEventType']) && is_bool($attributes['showEventType'])
    ? $attributes['showEventType']
    : true;

$show_location = isset($attributes['showLocation']) && is_bool($attributes['showLocation'])
    ? $attributes['showLocation']
    : true;

$show_time = isset($attributes['showTime']) && is_bool($attributes['showTime'])
    ? $attributes['showTime']
    : true;

$selected_event_types = isset($attributes['selectedEventTypes']) && is_array($attributes['selectedEventTypes'])
    ? $attributes['selectedEventTypes']
    : [];

$order_by = isset($attributes['orderBy']) && is_string($attributes['orderBy'])
    ? $attributes['orderBy']
    : 'event_date';

$order = isset($attributes['order']) && is_string($attributes['order'])
    ? $attributes['order']
    : 'asc';

$calendar_default_date = isset($attributes['calendarDefaultDate']) && is_string($attributes['calendarDefaultDate'])
    ? $attributes['calendarDefaultDate']
    : '';

// S'assurer que les valeurs sont valides
$number_of_events = max(1, min(20, $number_of_events));
$order_by = in_array($order_by, ['event_date', 'date', 'title']) ? $order_by : 'event_date';
$order = in_array($order, ['asc', 'desc']) ? $order : 'asc';

// Construire les arguments de la requête WP_Query
$query_args = [
    'post_type' => 'event',
    'posts_per_page' => $number_of_events,
    'post_status' => 'publish',
    'order' => $order,
    'suppress_filters' => false,
];

// Gérer l'orderby selon le type
if ($order_by === 'event_date') {
    $query_args['meta_key'] = 'event_date';
    $query_args['orderby'] = 'meta_value';
    $query_args['meta_type'] = 'DATE';
} else {
    $query_args['orderby'] = $order_by;
}

// Filtrer par types d'événements si sélectionnés
if (!empty($selected_event_types) && is_array($selected_event_types)) {
    // S'assurer que les IDs sont des entiers
    $valid_event_types = array_filter(array_map('intval', $selected_event_types));
    if (!empty($valid_event_types)) {
        $query_args['tax_query'] = [
            [
                'taxonomy' => 'event_type',
                'field'    => 'term_id',
                'terms'    => $valid_event_types,
            ],
        ];
    }
}

// Exécuter la requête avec gestion d'erreur
try {
    $events_query = new WP_Query($query_args);
} catch (Exception $e) {
    // En cas d'erreur, créer une requête vide
    $events_query = new WP_Query(['post_type' => 'event', 'posts_per_page' => 0]);
}

// Fonction pour générer le calendrier avec gestion d'erreur
if (!function_exists('generate_calendar_php')) {
    function generate_calendar_php($default_date = '')
    {
        try {
            $today = new DateTime();

            // Valider et parser la date par défaut
            if (!empty($default_date) && is_string($default_date)) {
                try {
                    $current_date = new DateTime($default_date);
                } catch (Exception $e) {
                    $current_date = $today;
                }
            } else {
                $current_date = $today;
            }

            $current_month = intval($current_date->format('n')) - 1; // 0-based
            $current_year = intval($current_date->format('Y'));

            $first_day = new DateTime("$current_year-" . ($current_month + 1) . "-01");
            $last_day = new DateTime($first_day->format('Y-m-t'));

            $start_date = clone $first_day;
            $days_back = intval($first_day->format('w')); // 0 = dimanche
            if ($days_back > 0) {
                $start_date->modify("-$days_back days");
            }

            $calendar = [];
            $day_names = ['DIM', 'LUN', 'MAR', 'MER', 'JEU', 'VEN', 'SAM'];

            // Ajouter les noms des jours
            foreach ($day_names as $day) {
                $calendar[] = '<div class="day-name">' . esc_html($day) . '</div>';
            }

            // Générer les jours du mois
            for ($i = 0; $i < 42; $i++) {
                $date = clone $start_date;
                $date->modify("+$i days");

                $is_current_month = intval($date->format('n')) === ($current_month + 1);
                $is_today = $date->format('Y-m-d') === $today->format('Y-m-d');

                $classes = ['day-number'];
                if (!$is_current_month) {
                    $classes[] = 'empty';
                }
                if ($is_today) {
                    $classes[] = 'today';
                }

                $day_content = $is_current_month ? $date->format('j') : '';
                $calendar[] = '<div class="' . esc_attr(implode(' ', $classes)) . '">' . esc_html($day_content) . '</div>';
            }

            return implode('', $calendar);
        } catch (Exception $e) {
            // En cas d'erreur, retourner un calendrier vide
            return '<div class="calendar-error">Erreur lors de la génération du calendrier</div>';
        }
    }
}

// Fonction pour obtenir le nom du mois
if (!function_exists('get_month_name_php')) {
    function get_month_name_php($month_index)
    {
        $months = [
            'Janvier',
            'Février',
            'Mars',
            'Avril',
            'Mai',
            'Juin',
            'Juillet',
            'Août',
            'Septembre',
            'Octobre',
            'Novembre',
            'Décembre'
        ];

        // Valider l'index du mois
        if (!is_numeric($month_index) || $month_index < 0 || $month_index > 11) {
            return 'Mois inconnu';
        }

        return $months[intval($month_index)] ?? 'Mois inconnu';
    }
}

// Initialiser la date par défaut de manière sécurisée
try {
    $current_date = !empty($calendar_default_date) && is_string($calendar_default_date)
        ? new DateTime($calendar_default_date)
        : new DateTime();
} catch (Exception $e) {
    $current_date = new DateTime();
}

// Obtenir les classes du block
$wrapper_attributes = get_block_wrapper_attributes([
    'class' => 'wp-block-mon-theme-aca-events'
]);
?>

<div <?php echo $wrapper_attributes; ?>>
    <section class="events-section-frontend">
        <div class="main-container">
            <?php if ($show_calendar) : ?>
                <div class="calendar-container">
                    <div class="calendar-header">
                        <button class="calendar-nav-btn" data-direction="prev">&lt;</button>
                        <span class="month-year">
                            <?php echo get_month_name_php($current_date->format('n') - 1) . ' ' . $current_date->format('Y'); ?>
                        </span>
                        <button class="calendar-nav-btn" data-direction="next">&gt;</button>
                    </div>
                    <div class="calendar-grid">
                        <?php echo generate_calendar_php($calendar_default_date); ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="events-section">
                <h1><?php echo esc_html($section_title); ?></h1>

                <?php if ($events_query->have_posts()) : ?>
                    <div class="events-list">
                        <?php while ($events_query->have_posts()) :
                            $events_query->the_post();

                            $event_date = get_post_meta(get_the_ID(), 'event_date', true);
                            $event_time = get_post_meta(get_the_ID(), 'event_time', true);
                            $event_location = get_post_meta(get_the_ID(), 'event_location', true);
                            $event_end_date = get_post_meta(get_the_ID(), 'event_end_date', true);

                            if (empty($event_date)) {
                                $event_date = get_the_date('Y-m-d');
                            }

                            try {
                                $date = new DateTime($event_date);
                                $day = $date->format('j');
                                $month = strtoupper($date->format('M'));
                            } catch (Exception $e) {
                                // En cas d'erreur de date, utiliser la date de publication
                                $date = new DateTime(get_the_date('Y-m-d'));
                                $day = $date->format('j');
                                $month = strtoupper($date->format('M'));
                            }

                            // Traduction des mois
                            $month_translations = [
                                'JAN' => 'JAN',
                                'FEB' => 'FÉV',
                                'MAR' => 'MAR',
                                'APR' => 'AVR',
                                'MAY' => 'MAI',
                                'JUN' => 'JUN',
                                'JUL' => 'JUL',
                                'AUG' => 'AOÛT',
                                'SEP' => 'SEP',
                                'OCT' => 'OCT',
                                'NOV' => 'NOV',
                                'DEC' => 'DÉC'
                            ];
                            $month = $month_translations[$month] ?? $month;

                            $event_types = wp_get_post_terms(get_the_ID(), 'event_type');
                        ?>
                            <div class="event-card">
                                <div class="event-date">
                                    <span class="day"><?php echo $day; ?></span>
                                    <span class="month"><?php echo $month; ?></span>
                                </div>
                                <div class="event-details">
                                    <h2><?php the_title(); ?></h2>
                                    <?php if ($show_time && !empty($event_time)) : ?>
                                        <p class="time"><?php echo esc_html($event_time); ?></p>
                                    <?php endif; ?>
                                    <?php if ($show_location && !empty($event_location)) : ?>
                                        <p class="location"><?php echo esc_html($event_location); ?></p>
                                    <?php endif; ?>
                                    <?php if ($show_event_type && !empty($event_types) && !is_wp_error($event_types)) : ?>
                                        <span class="event-tag">
                                            <?php echo esc_html($event_types[0]->name); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else : ?>
                    <div class="no-events-message">
                        <p><?php _e('Aucun événement à afficher pour le moment.', 'mon-theme-aca'); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>

<?php
wp_reset_postdata();
?>