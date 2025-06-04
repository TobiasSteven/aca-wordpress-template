import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import {
    PanelBody,
    RangeControl,
    SelectControl,
    ToggleControl,
    CheckboxControl,
    TextControl
} from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { useEntityRecords } from '@wordpress/core-data';
import './editor.scss';

export default function Edit({ attributes, setAttributes }) {
    const {
        sectionTitle,
        numberOfEvents,
        showCalendar,
        showEventType,
        showLocation,
        showTime,
        selectedEventTypes,
        orderBy,
        order,
        calendarDefaultDate
    } = attributes;

    // Récupérer les types d'événements (taxonomie personnalisée)
    const { records: eventTypes, isResolving: isLoadingEventTypes } = useEntityRecords('taxonomy', 'event_type', {
        per_page: -1,
        hide_empty: true,
    });

    // Récupérer les événements selon les paramètres
    const queryArgs = {
        per_page: numberOfEvents,
        _embed: true,
        order: order,
        orderby: orderBy,
        meta_key: orderBy === 'event_date' ? 'event_date' : undefined,
    };

    if (selectedEventTypes.length > 0) {
        queryArgs.event_type = selectedEventTypes;
    }

    const { records: events, isResolving: isLoadingEvents } = useEntityRecords('postType', 'event', queryArgs);

    const blockProps = useBlockProps();

    const onEventTypeChange = (eventTypeId, checked) => {
        let newEventTypes = [...selectedEventTypes];
        if (checked) {
            newEventTypes.push(eventTypeId);
        } else {
            newEventTypes = newEventTypes.filter(id => id !== eventTypeId);
        }
        setAttributes({ selectedEventTypes: newEventTypes });
    };

    // Fonction pour générer le calendrier
    const generateCalendar = () => {
        const today = new Date();
        const currentDate = calendarDefaultDate ? new Date(calendarDefaultDate) : today;
        const currentMonth = currentDate.getMonth();
        const currentYear = currentDate.getFullYear();

        const firstDay = new Date(currentYear, currentMonth, 1);
        const lastDay = new Date(currentYear, currentMonth + 1, 0);
        const startDate = new Date(firstDay);
        startDate.setDate(startDate.getDate() - firstDay.getDay());

        const calendar = [];
        const dayNames = ['DIM', 'LUN', 'MAR', 'MER', 'JEU', 'VEN', 'SAM'];

        // Ajouter les noms des jours
        dayNames.forEach(day => {
            calendar.push(<div key={day} className="day-name">{day}</div>);
        });

        // Générer les jours du mois
        for (let i = 0; i < 42; i++) {
            const date = new Date(startDate);
            date.setDate(startDate.getDate() + i);

            const isCurrentMonth = date.getMonth() === currentMonth;
            const isToday = date.toDateString() === today.toDateString();

            calendar.push(
                <div
                    key={`day-${i}`}
                    className={`day-number ${!isCurrentMonth ? 'empty' : ''} ${isToday ? 'today' : ''}`}
                >
                    {isCurrentMonth ? date.getDate() : ''}
                </div>
            );
        }

        return calendar;
    };

    // Fonction pour formater les mois
    const getMonthName = (monthIndex) => {
        const months = [
            'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
            'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
        ];
        return months[monthIndex];
    };

    const currentDate = calendarDefaultDate ? new Date(calendarDefaultDate) : new Date();

    return (
        <>
            <InspectorControls>
                <PanelBody title={__('Paramètres généraux', 'mon-theme-aca')} initialOpen={true}>
                    <TextControl
                        label={__('Titre de la section', 'mon-theme-aca')}
                        value={sectionTitle}
                        onChange={(value) => setAttributes({ sectionTitle: value })}
                    />
                    <RangeControl
                        label={__('Nombre d\'événements', 'mon-theme-aca')}
                        value={numberOfEvents}
                        onChange={(value) => setAttributes({ numberOfEvents: value })}
                        min={1}
                        max={20}
                    />
                    <SelectControl
                        label={__('Trier par', 'mon-theme-aca')}
                        value={orderBy}
                        options={[
                            { label: __('Date de l\'événement', 'mon-theme-aca'), value: 'event_date' },
                            { label: __('Date de création', 'mon-theme-aca'), value: 'date' },
                            { label: __('Titre', 'mon-theme-aca'), value: 'title' },
                        ]}
                        onChange={(value) => setAttributes({ orderBy: value })}
                    />
                    <SelectControl
                        label={__('Ordre', 'mon-theme-aca')}
                        value={order}
                        options={[
                            { label: __('Croissant', 'mon-theme-aca'), value: 'asc' },
                            { label: __('Décroissant', 'mon-theme-aca'), value: 'desc' },
                        ]}
                        onChange={(value) => setAttributes({ order: value })}
                    />
                </PanelBody>

                <PanelBody title={__('Options d\'affichage', 'mon-theme-aca')} initialOpen={false}>
                    <ToggleControl
                        label={__('Afficher le calendrier', 'mon-theme-aca')}
                        checked={showCalendar}
                        onChange={(value) => setAttributes({ showCalendar: value })}
                    />
                    <ToggleControl
                        label={__('Afficher le type d\'événement', 'mon-theme-aca')}
                        checked={showEventType}
                        onChange={(value) => setAttributes({ showEventType: value })}
                    />
                    <ToggleControl
                        label={__('Afficher l\'heure', 'mon-theme-aca')}
                        checked={showTime}
                        onChange={(value) => setAttributes({ showTime: value })}
                    />
                    <ToggleControl
                        label={__('Afficher le lieu', 'mon-theme-aca')}
                        checked={showLocation}
                        onChange={(value) => setAttributes({ showLocation: value })}
                    />
                </PanelBody>

                <PanelBody title={__('Types d\'événements', 'mon-theme-aca')} initialOpen={false}>
                    {isLoadingEventTypes && <p>{__('Chargement des types d\'événements...', 'mon-theme-aca')}</p>}
                    {eventTypes && eventTypes.map((eventType) => (
                        <CheckboxControl
                            key={eventType.id}
                            label={eventType.name}
                            checked={selectedEventTypes.includes(eventType.id)}
                            onChange={(checked) => onEventTypeChange(eventType.id, checked)}
                        />
                    ))}
                    {!isLoadingEventTypes && (!eventTypes || eventTypes.length === 0) && (
                        <p>{__('Aucun type d\'événement trouvé. Veuillez d\'abord créer des types d\'événements.', 'mon-theme-aca')}</p>
                    )}
                </PanelBody>
            </InspectorControls>

            <div {...blockProps}>
                <div className="events-editor">
                    <div className="main-container">
                        {showCalendar && (
                            <div className="calendar-container">
                                <div className="calendar-header">
                                    <button>&lt;</button>
                                    <span className="month-year">
                                        {getMonthName(currentDate.getMonth())} {currentDate.getFullYear()}
                                    </span>
                                    <button>&gt;</button>
                                </div>
                                <div className="calendar-grid">
                                    {generateCalendar()}
                                </div>
                            </div>
                        )}

                        <div className="events-section">
                            <h1>{sectionTitle || __('Événements À Venir', 'mon-theme-aca')}</h1>

                            {isLoadingEvents && (
                                <p>{__('Chargement des événements...', 'mon-theme-aca')}</p>
                            )}

                            {events && events.length === 0 && (
                                <p>{__('Aucun événement trouvé avec ces paramètres.', 'mon-theme-aca')}</p>
                            )}

                            {events && events.length > 0 && (
                                <div className="events-list">
                                    {events.map((event, index) => {
                                        const eventDate = event.meta?.event_date || event.date;
                                        const eventTime = event.meta?.event_time || '';
                                        const eventLocation = event.meta?.event_location || '';
                                        const eventEndDate = event.meta?.event_end_date || '';

                                        const date = new Date(eventDate);
                                        const day = date.getDate();
                                        const month = date.toLocaleDateString('fr-FR', { month: 'short' }).toUpperCase();

                                        return (
                                            <div key={event.id} className="event-card">
                                                <div className="event-date">
                                                    <span className="day">{day}</span>
                                                    <span className="month">{month}</span>
                                                </div>
                                                <div className="event-details">
                                                    <h2 dangerouslySetInnerHTML={{ __html: event.title.rendered }} />
                                                    {showTime && eventTime && (
                                                        <p className="time">{eventTime}</p>
                                                    )}
                                                    {showLocation && eventLocation && (
                                                        <p className="location">{eventLocation}</p>
                                                    )}
                                                    {showEventType && event._embedded && event._embedded['wp:term'] && (
                                                        <span className="event-tag">
                                                            {event._embedded['wp:term'][0]?.[0]?.name || __('Événement', 'mon-theme-aca')}
                                                        </span>
                                                    )}
                                                </div>
                                            </div>
                                        );
                                    })}
                                </div>
                            )}

                            {!isLoadingEvents && (!events || events.length === 0) && (
                                <div className="no-events-message">
                                    <p>{__('Aucun événement à afficher pour le moment.', 'mon-theme-aca')}</p>
                                    <p><small>{__('Ajoutez des événements depuis l\'administration WordPress.', 'mon-theme-aca')}</small></p>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
