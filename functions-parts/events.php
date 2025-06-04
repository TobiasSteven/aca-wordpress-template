<?php

/**
 * Custom Post Type and Taxonomy for Events
 *
 * @package Mon-Theme-ACA
 */

/**
 * Register Event Custom Post Type
 */
function mon_theme_aca_register_event_post_type()
{
    $labels = array(
        'name'                  => _x('Événements', 'Post Type General Name', 'mon-theme-aca'),
        'singular_name'         => _x('Événement', 'Post Type Singular Name', 'mon-theme-aca'),
        'menu_name'             => __('Événements', 'mon-theme-aca'),
        'name_admin_bar'        => __('Événement', 'mon-theme-aca'),
        'archives'              => __('Archives des événements', 'mon-theme-aca'),
        'attributes'            => __('Attributs de l\'événement', 'mon-theme-aca'),
        'parent_item_colon'     => __('Événement parent:', 'mon-theme-aca'),
        'all_items'             => __('Tous les événements', 'mon-theme-aca'),
        'add_new_item'          => __('Ajouter un nouvel événement', 'mon-theme-aca'),
        'add_new'               => __('Ajouter nouveau', 'mon-theme-aca'),
        'new_item'              => __('Nouvel événement', 'mon-theme-aca'),
        'edit_item'             => __('Modifier l\'événement', 'mon-theme-aca'),
        'update_item'           => __('Mettre à jour l\'événement', 'mon-theme-aca'),
        'view_item'             => __('Voir l\'événement', 'mon-theme-aca'),
        'view_items'            => __('Voir les événements', 'mon-theme-aca'),
        'search_items'          => __('Rechercher un événement', 'mon-theme-aca'),
        'not_found'             => __('Aucun événement trouvé', 'mon-theme-aca'),
        'not_found_in_trash'    => __('Aucun événement trouvé dans la corbeille', 'mon-theme-aca'),
        'featured_image'        => __('Image de l\'événement', 'mon-theme-aca'),
        'set_featured_image'    => __('Définir l\'image de l\'événement', 'mon-theme-aca'),
        'remove_featured_image' => __('Supprimer l\'image de l\'événement', 'mon-theme-aca'),
        'use_featured_image'    => __('Utiliser comme image de l\'événement', 'mon-theme-aca'),
        'insert_into_item'      => __('Insérer dans l\'événement', 'mon-theme-aca'),
        'uploaded_to_this_item' => __('Téléversé vers cet événement', 'mon-theme-aca'),
        'items_list'            => __('Liste des événements', 'mon-theme-aca'),
        'items_list_navigation' => __('Navigation de la liste des événements', 'mon-theme-aca'),
        'filter_items_list'     => __('Filtrer la liste des événements', 'mon-theme-aca'),
    );

    $args = array(
        'label'                 => __('Événement', 'mon-theme-aca'),
        'description'           => __('Gestion des événements de l\'ACA', 'mon-theme-aca'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'custom-fields'),
        'taxonomies'            => array('event_type'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-calendar-alt',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
        'rest_base'             => 'events',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
    );

    register_post_type('event', $args);
}
add_action('init', 'mon_theme_aca_register_event_post_type', 0);

/**
 * Register Event Type Taxonomy
 */
function mon_theme_aca_register_event_type_taxonomy()
{
    $labels = array(
        'name'                       => _x('Types d\'événements', 'Taxonomy General Name', 'mon-theme-aca'),
        'singular_name'              => _x('Type d\'événement', 'Taxonomy Singular Name', 'mon-theme-aca'),
        'menu_name'                  => __('Types d\'événements', 'mon-theme-aca'),
        'all_items'                  => __('Tous les types', 'mon-theme-aca'),
        'parent_item'                => __('Type parent', 'mon-theme-aca'),
        'parent_item_colon'          => __('Type parent:', 'mon-theme-aca'),
        'new_item_name'              => __('Nouveau nom de type', 'mon-theme-aca'),
        'add_new_item'               => __('Ajouter un nouveau type', 'mon-theme-aca'),
        'edit_item'                  => __('Modifier le type', 'mon-theme-aca'),
        'update_item'                => __('Mettre à jour le type', 'mon-theme-aca'),
        'view_item'                  => __('Voir le type', 'mon-theme-aca'),
        'separate_items_with_commas' => __('Séparer les types avec des virgules', 'mon-theme-aca'),
        'add_or_remove_items'        => __('Ajouter ou supprimer des types', 'mon-theme-aca'),
        'choose_from_most_used'      => __('Choisir parmi les plus utilisés', 'mon-theme-aca'),
        'popular_items'              => __('Types populaires', 'mon-theme-aca'),
        'search_items'               => __('Rechercher des types', 'mon-theme-aca'),
        'not_found'                  => __('Aucun type trouvé', 'mon-theme-aca'),
        'no_terms'                   => __('Aucun type', 'mon-theme-aca'),
        'items_list'                 => __('Liste des types', 'mon-theme-aca'),
        'items_list_navigation'      => __('Navigation de la liste des types', 'mon-theme-aca'),
    );

    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_rest'               => true,
        'rest_base'                  => 'event_types',
        'rest_controller_class'      => 'WP_REST_Terms_Controller',
    );

    register_taxonomy('event_type', array('event'), $args);
}
add_action('init', 'mon_theme_aca_register_event_type_taxonomy', 0);

/**
 * Add Event Meta Boxes
 */
function mon_theme_aca_add_event_meta_boxes()
{
    add_meta_box(
        'event_details',
        __('Détails de l\'événement', 'mon-theme-aca'),
        'mon_theme_aca_event_details_callback',
        'event',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'mon_theme_aca_add_event_meta_boxes');

/**
 * Event Details Meta Box Callback
 */
function mon_theme_aca_event_details_callback($post)
{
    // Add nonce for security
    wp_nonce_field('mon_theme_aca_event_details_nonce', 'event_details_nonce');

    // Get current values
    $event_date = get_post_meta($post->ID, 'event_date', true);
    $event_time = get_post_meta($post->ID, 'event_time', true);
    $event_end_date = get_post_meta($post->ID, 'event_end_date', true);
    $event_end_time = get_post_meta($post->ID, 'event_end_time', true);
    $event_location = get_post_meta($post->ID, 'event_location', true);
    $event_address = get_post_meta($post->ID, 'event_address', true);
    $event_organizer = get_post_meta($post->ID, 'event_organizer', true);
    $event_contact_email = get_post_meta($post->ID, 'event_contact_email', true);
    $event_contact_phone = get_post_meta($post->ID, 'event_contact_phone', true);
    $event_website = get_post_meta($post->ID, 'event_website', true);
    $event_price = get_post_meta($post->ID, 'event_price', true);
    $event_capacity = get_post_meta($post->ID, 'event_capacity', true);

?>
    <style>
        .event-meta-table {
            width: 100%;
            border-collapse: collapse;
        }

        .event-meta-table th,
        .event-meta-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .event-meta-table th {
            background-color: #f5f5f5;
            font-weight: 600;
            width: 200px;
        }

        .event-meta-table input[type="text"],
        .event-meta-table input[type="email"],
        .event-meta-table input[type="url"],
        .event-meta-table input[type="tel"],
        .event-meta-table input[type="date"],
        .event-meta-table input[type="time"],
        .event-meta-table input[type="number"],
        .event-meta-table textarea {
            width: 100%;
        }

        .event-meta-section {
            margin-bottom: 20px;
        }

        .event-meta-section h4 {
            margin: 0 0 15px 0;
            padding: 10px;
            background-color: #2D9B8A;
            color: white;
            border-radius: 4px;
        }
    </style>

    <div class="event-meta-section">
        <h4><?php _e('📅 Date et Heure', 'mon-theme-aca'); ?></h4>
        <table class="event-meta-table">
            <tr>
                <th><label for="event_date"><?php _e('Date de début', 'mon-theme-aca'); ?> *</label></th>
                <td><input type="date" id="event_date" name="event_date" value="<?php echo esc_attr($event_date); ?>" required /></td>
            </tr>
            <tr>
                <th><label for="event_time"><?php _e('Heure de début', 'mon-theme-aca'); ?></label></th>
                <td><input type="time" id="event_time" name="event_time" value="<?php echo esc_attr($event_time); ?>" /></td>
            </tr>
            <tr>
                <th><label for="event_end_date"><?php _e('Date de fin', 'mon-theme-aca'); ?></label></th>
                <td><input type="date" id="event_end_date" name="event_end_date" value="<?php echo esc_attr($event_end_date); ?>" /></td>
            </tr>
            <tr>
                <th><label for="event_end_time"><?php _e('Heure de fin', 'mon-theme-aca'); ?></label></th>
                <td><input type="time" id="event_end_time" name="event_end_time" value="<?php echo esc_attr($event_end_time); ?>" /></td>
            </tr>
        </table>
    </div>

    <div class="event-meta-section">
        <h4><?php _e('📍 Lieu', 'mon-theme-aca'); ?></h4>
        <table class="event-meta-table">
            <tr>
                <th><label for="event_location"><?php _e('Nom du lieu', 'mon-theme-aca'); ?></label></th>
                <td><input type="text" id="event_location" name="event_location" value="<?php echo esc_attr($event_location); ?>" placeholder="<?php _e('Ex: Centre de Conférence ACA', 'mon-theme-aca'); ?>" /></td>
            </tr>
            <tr>
                <th><label for="event_address"><?php _e('Adresse complète', 'mon-theme-aca'); ?></label></th>
                <td><textarea id="event_address" name="event_address" rows="3" placeholder="<?php _e('Ex: 123 Rue du Coton, Cotonou, Bénin', 'mon-theme-aca'); ?>"><?php echo esc_textarea($event_address); ?></textarea></td>
            </tr>
        </table>
    </div>

    <div class="event-meta-section">
        <h4><?php _e('👤 Organisation', 'mon-theme-aca'); ?></h4>
        <table class="event-meta-table">
            <tr>
                <th><label for="event_organizer"><?php _e('Organisateur', 'mon-theme-aca'); ?></label></th>
                <td><input type="text" id="event_organizer" name="event_organizer" value="<?php echo esc_attr($event_organizer); ?>" placeholder="<?php _e('Ex: Association Africaine du Coton', 'mon-theme-aca'); ?>" /></td>
            </tr>
            <tr>
                <th><label for="event_contact_email"><?php _e('Email de contact', 'mon-theme-aca'); ?></label></th>
                <td><input type="email" id="event_contact_email" name="event_contact_email" value="<?php echo esc_attr($event_contact_email); ?>" placeholder="<?php _e('contact@aca-coton.org', 'mon-theme-aca'); ?>" /></td>
            </tr>
            <tr>
                <th><label for="event_contact_phone"><?php _e('Téléphone de contact', 'mon-theme-aca'); ?></label></th>
                <td><input type="tel" id="event_contact_phone" name="event_contact_phone" value="<?php echo esc_attr($event_contact_phone); ?>" placeholder="<?php _e('+229 12 34 56 78', 'mon-theme-aca'); ?>" /></td>
            </tr>
            <tr>
                <th><label for="event_website"><?php _e('Site web', 'mon-theme-aca'); ?></label></th>
                <td><input type="url" id="event_website" name="event_website" value="<?php echo esc_attr($event_website); ?>" placeholder="<?php _e('https://aca-coton.org/evenement', 'mon-theme-aca'); ?>" /></td>
            </tr>
        </table>
    </div>

    <div class="event-meta-section">
        <h4><?php _e('💰 Détails pratiques', 'mon-theme-aca'); ?></h4>
        <table class="event-meta-table">
            <tr>
                <th><label for="event_price"><?php _e('Prix / Tarif', 'mon-theme-aca'); ?></label></th>
                <td><input type="text" id="event_price" name="event_price" value="<?php echo esc_attr($event_price); ?>" placeholder="<?php _e('Ex: Gratuit, 50€, 25000 FCFA', 'mon-theme-aca'); ?>" /></td>
            </tr>
            <tr>
                <th><label for="event_capacity"><?php _e('Capacité maximale', 'mon-theme-aca'); ?></label></th>
                <td><input type="number" id="event_capacity" name="event_capacity" value="<?php echo esc_attr($event_capacity); ?>" placeholder="<?php _e('Ex: 100', 'mon-theme-aca'); ?>" min="1" /></td>
            </tr>
        </table>
    </div>

    <p><strong><?php _e('Note:', 'mon-theme-aca'); ?></strong> <?php _e('Les champs marqués d\'un * sont obligatoires.', 'mon-theme-aca'); ?></p>
<?php
}

/**
 * Save Event Meta Data
 */
function mon_theme_aca_save_event_meta($post_id)
{
    // Check if nonce is set
    if (!isset($_POST['event_details_nonce'])) {
        return;
    }

    // Verify nonce
    if (!wp_verify_nonce($_POST['event_details_nonce'], 'mon_theme_aca_event_details_nonce')) {
        return;
    }

    // Check if user has permission
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Check if this is an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check if this is the correct post type
    if (get_post_type($post_id) !== 'event') {
        return;
    }

    // List of meta fields to save
    $meta_fields = [
        'event_date',
        'event_time',
        'event_end_date',
        'event_end_time',
        'event_location',
        'event_address',
        'event_organizer',
        'event_contact_email',
        'event_contact_phone',
        'event_website',
        'event_price',
        'event_capacity'
    ];

    // Save meta data
    foreach ($meta_fields as $field) {
        if (isset($_POST[$field])) {
            $value = sanitize_text_field($_POST[$field]);

            // Special sanitization for specific fields
            if ($field === 'event_contact_email') {
                $value = sanitize_email($_POST[$field]);
            } elseif ($field === 'event_website') {
                $value = esc_url_raw($_POST[$field]);
            } elseif ($field === 'event_address') {
                $value = sanitize_textarea_field($_POST[$field]);
            }

            update_post_meta($post_id, $field, $value);
        }
    }
}
add_action('save_post', 'mon_theme_aca_save_event_meta');

/**
 * Add custom columns to Events admin list
 */
function mon_theme_aca_event_admin_columns($columns)
{
    // Remove date column and add it back in a different position
    unset($columns['date']);

    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = $columns['title'];
    $new_columns['event_date'] = __('Date de l\'événement', 'mon-theme-aca');
    $new_columns['event_location'] = __('Lieu', 'mon-theme-aca');
    $new_columns['event_type'] = __('Type', 'mon-theme-aca');
    $new_columns['date'] = __('Publié', 'mon-theme-aca');

    return $new_columns;
}
add_filter('manage_event_posts_columns', 'mon_theme_aca_event_admin_columns');

/**
 * Populate custom columns in Events admin list
 */
function mon_theme_aca_event_admin_column_content($column, $post_id)
{
    switch ($column) {
        case 'event_date':
            $event_date = get_post_meta($post_id, 'event_date', true);
            $event_time = get_post_meta($post_id, 'event_time', true);

            if ($event_date) {
                $formatted_date = date_i18n('j F Y', strtotime($event_date));
                echo '<strong>' . $formatted_date . '</strong>';

                if ($event_time) {
                    echo '<br><small>' . $event_time . '</small>';
                }
            } else {
                echo '<span style="color: #999;">Non définie</span>';
            }
            break;

        case 'event_location':
            $location = get_post_meta($post_id, 'event_location', true);
            echo $location ? esc_html($location) : '<span style="color: #999;">Non défini</span>';
            break;

        case 'event_type':
            $terms = wp_get_post_terms($post_id, 'event_type');
            if (!empty($terms) && !is_wp_error($terms)) {
                $term_names = array();
                foreach ($terms as $term) {
                    $term_names[] = $term->name;
                }
                echo implode(', ', $term_names);
            } else {
                echo '<span style="color: #999;">Non défini</span>';
            }
            break;
    }
}
add_action('manage_event_posts_custom_column', 'mon_theme_aca_event_admin_column_content', 10, 2);

/**
 * Make custom columns sortable
 */
function mon_theme_aca_event_sortable_columns($columns)
{
    $columns['event_date'] = 'event_date';
    $columns['event_location'] = 'event_location';
    return $columns;
}
add_filter('manage_edit-event_sortable_columns', 'mon_theme_aca_event_sortable_columns');

/**
 * Handle sorting for custom columns
 */
function mon_theme_aca_event_column_orderby($query)
{
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    $orderby = $query->get('orderby');

    if ($orderby === 'event_date') {
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value');
        $query->set('meta_type', 'DATE');
    } elseif ($orderby === 'event_location') {
        $query->set('meta_key', 'event_location');
        $query->set('orderby', 'meta_value');
    }
}
add_action('pre_get_posts', 'mon_theme_aca_event_column_orderby');

/**
 * Insert default event types on theme activation
 */
function mon_theme_aca_insert_default_event_types()
{
    // Check if we already have event types
    $existing_terms = get_terms(array(
        'taxonomy' => 'event_type',
        'hide_empty' => false,
    ));

    if (empty($existing_terms)) {
        $default_types = array(
            array(
                'name' => __('Conférence', 'mon-theme-aca'),
                'description' => __('Événements de type conférence ou symposium', 'mon-theme-aca'),
            ),
            array(
                'name' => __('Atelier', 'mon-theme-aca'),
                'description' => __('Sessions de formation et ateliers pratiques', 'mon-theme-aca'),
            ),
            array(
                'name' => __('Webinaire', 'mon-theme-aca'),
                'description' => __('Événements en ligne et visioconférences', 'mon-theme-aca'),
            ),
            array(
                'name' => __('Réunion', 'mon-theme-aca'),
                'description' => __('Réunions et assemblées', 'mon-theme-aca'),
            ),
            array(
                'name' => __('Formation', 'mon-theme-aca'),
                'description' => __('Sessions de formation et éducation', 'mon-theme-aca'),
            ),
        );

        foreach ($default_types as $type) {
            wp_insert_term(
                $type['name'],
                'event_type',
                array(
                    'description' => $type['description'],
                )
            );
        }
    }
}
add_action('after_switch_theme', 'mon_theme_aca_insert_default_event_types');

/**
 * Insert sample events on theme activation (for development/demo)
 */
function mon_theme_aca_insert_sample_events()
{
    // Only add sample events if no events exist
    $existing_events = get_posts(array(
        'post_type' => 'event',
        'numberposts' => 1,
        'post_status' => 'any'
    ));

    if (empty($existing_events)) {
        $sample_events = array(
            array(
                'title' => 'Conférence Annuelle de l\'ACA',
                'content' => 'La conférence annuelle de l\'Association Africaine du Coton réunit les producteurs, transformateurs et acteurs de la filière coton pour échanger sur les meilleures pratiques et les innovations du secteur.',
                'excerpt' => 'Rencontre annuelle des acteurs de la filière coton africaine.',
                'event_date' => date('Y-m-d', strtotime('+25 days')),
                'event_time' => '10:00',
                'event_end_date' => date('Y-m-d', strtotime('+25 days')),
                'event_end_time' => '17:00',
                'event_location' => 'Accra, Ghana',
                'event_address' => 'Centre de Conférence International d\'Accra, Airport City, Accra, Ghana',
                'event_organizer' => 'Association Africaine du Coton',
                'event_contact_email' => 'conference@aca-coton.org',
                'event_contact_phone' => '+233 123 456 789',
                'event_website' => 'https://aca-coton.org/conference-2025',
                'event_price' => 'Gratuit pour les membres',
                'event_capacity' => '500',
                'event_type' => 'Conférence'
            ),
            array(
                'title' => 'Atelier sur les Nouvelles Technologies',
                'content' => 'Atelier pratique sur l\'utilisation des nouvelles technologies dans la production cotonnière : drones, capteurs IoT, intelligence artificielle pour l\'optimisation des rendements.',
                'excerpt' => 'Formation pratique sur les technologies modernes en agriculture.',
                'event_date' => date('Y-m-d', strtotime('+41 days')),
                'event_time' => '09:00',
                'event_end_date' => date('Y-m-d', strtotime('+41 days')),
                'event_end_time' => '12:00',
                'event_location' => 'Dakar, Sénégal',
                'event_address' => 'Centre de Formation Agricole, Avenue Bourguiba, Dakar, Sénégal',
                'event_organizer' => 'ACA - Division Technique',
                'event_contact_email' => 'formation@aca-coton.org',
                'event_contact_phone' => '+221 77 123 456',
                'event_website' => 'https://aca-coton.org/formation-tech',
                'event_price' => '25000 FCFA',
                'event_capacity' => '50',
                'event_type' => 'Atelier'
            ),
            array(
                'title' => 'Webinaire sur le Commerce du Coton',
                'content' => 'Session en ligne dédiée aux tendances du marché mondial du coton, aux opportunités d\'export et aux stratégies de commercialisation pour les producteurs africains.',
                'excerpt' => 'Webinaire sur les opportunités commerciales du coton.',
                'event_date' => date('Y-m-d', strtotime('+75 days')),
                'event_time' => '14:00',
                'event_end_date' => date('Y-m-d', strtotime('+75 days')),
                'event_end_time' => '16:00',
                'event_location' => 'En ligne',
                'event_address' => 'Lien Zoom fourni après inscription',
                'event_organizer' => 'ACA Commerce International',
                'event_contact_email' => 'webinaire@aca-coton.org',
                'event_contact_phone' => '+254 712 345 678',
                'event_website' => 'https://aca-coton.org/webinaire-commerce',
                'event_price' => 'Gratuit',
                'event_capacity' => '200',
                'event_type' => 'Webinaire'
            )
        );

        foreach ($sample_events as $sample_event) {
            // Create the event post
            $post_data = array(
                'post_title' => $sample_event['title'],
                'post_content' => $sample_event['content'],
                'post_excerpt' => $sample_event['excerpt'],
                'post_status' => 'publish',
                'post_type' => 'event',
                'post_author' => 1
            );

            $post_id = wp_insert_post($post_data);

            if ($post_id && !is_wp_error($post_id)) {
                // Add event meta data
                $meta_fields = array(
                    'event_date',
                    'event_time',
                    'event_end_date',
                    'event_end_time',
                    'event_location',
                    'event_address',
                    'event_organizer',
                    'event_contact_email',
                    'event_contact_phone',
                    'event_website',
                    'event_price',
                    'event_capacity'
                );

                foreach ($meta_fields as $field) {
                    if (isset($sample_event[$field])) {
                        update_post_meta($post_id, $field, $sample_event[$field]);
                    }
                }

                // Assign event type
                if (isset($sample_event['event_type'])) {
                    $term = get_term_by('name', $sample_event['event_type'], 'event_type');
                    if ($term) {
                        wp_set_post_terms($post_id, array($term->term_id), 'event_type');
                    }
                }
            }
        }
    }
}
add_action('after_switch_theme', 'mon_theme_aca_insert_sample_events');
