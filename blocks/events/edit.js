import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import {
    PanelBody,
    TextControl,
    Button,
    ToggleControl,
    DatePicker,
    SelectControl,
    BaseControl
} from '@wordpress/components';
import { useState } from '@wordpress/element';
import './editor.scss';

// --- Fonctions d'aide pour le rendu de l'aperçu ---
const Icon = ({ type }) => {
    const icons = {
        map: <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>,
        clock: <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>,
        users: <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/></svg>,
    };
    return <span className="icon-preview">{icons[type]}</span>;
}

const CalendarPreview = ({ events }) => {
    const [currentMonth, setCurrentMonth] = useState(new Date());
    // ... (Le reste du composant CalendarPreview reste identique)
    const renderCalendar = () => {
        const month = currentMonth.getMonth();
        const year = currentMonth.getFullYear();
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        const firstDayOfMonth = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        
        const eventDatesInMonth = events
            .map(e => new Date(e.date))
            .filter(d => d.getFullYear() === year && d.getMonth() === month)
            .map(d => d.getDate());

        const dayNames = ['L', 'M', 'M', 'J', 'V', 'S', 'D'].map(day => <div className="day-name">{day}</div>);
        
        const emptyCells = Array.from({ length: firstDayOfMonth === 0 ? 6 : firstDayOfMonth - 1 }, (_, i) => <div key={`empty-${i}`} className="day-cell other-month"></div>);
        
        const dayCells = Array.from({ length: daysInMonth }, (_, i) => {
            const day = i + 1;
            const thisDate = new Date(year, month, day);
            let classes = 'day-cell';
            if (eventDatesInMonth.includes(day)) classes += ' has-event';
            if (thisDate.setHours(0,0,0,0) === today.getTime()) classes += ' is-today';
            return <div key={day} className={classes}>{day}</div>;
        });

        return [...dayNames, ...emptyCells, ...dayCells];
    };

     return (
        <div className="calendar-component">
            <div className="calendar-header-controls">
                <h3 className="calendar-month-year-title">
                    {currentMonth.toLocaleDateString('fr-FR', { month: 'long', year: 'numeric' })}
                </h3>
                <div className="calendar-nav">
                    <Button onClick={() => setCurrentMonth(new Date(currentMonth.setMonth(currentMonth.getMonth() - 1)))}>{'<'}</Button>
                    <Button onClick={() => setCurrentMonth(new Date(currentMonth.setMonth(currentMonth.getMonth() + 1)))}>{'>'}</Button>
                </div>
            </div>
            <div className="calendar-grid">
                {renderCalendar()}
            </div>
        </div>
    );
};


export default function Edit({ attributes, setAttributes }) {
    const { sectionTitle, sectionSubtitle, showCalendar, eventItems, showEventType, showTime, showLocation, showParticipants } = attributes;
    const blockProps = useBlockProps();
    const [currentItemIndex, setCurrentItemIndex] = useState(0);

    const updateItem = (index, field, value) => {
        const newItems = [...eventItems];
        newItems[index][field] = value;
        setAttributes({ eventItems: newItems });
    };

    const addItem = () => {
        const newItem = {
            id: new Date().getTime(),
            date: new Date().toISOString().split('T')[0],
            title: __('Nouvel événement', 'mon-theme-aca'),
            location: 'Lieu',
            time: '10:00 - 12:00',
            participants: '0',
            type: 'Conférence',
            link: '#'
        };
        const newItems = [...eventItems, newItem];
        setAttributes({ eventItems: newItems });
        setCurrentItemIndex(newItems.length - 1);
    };

    const removeItem = (index) => {
        const newItems = eventItems.filter((_, i) => i !== index);
        if (index <= currentItemIndex) {
            setCurrentItemIndex(Math.max(0, currentItemIndex - 1));
        }
        setAttributes({ eventItems: newItems });
    };

    const goToNextItem = () => setCurrentItemIndex((prev) => (prev + 1) % eventItems.length);
    const goToPrevItem = () => setCurrentItemIndex((prev) => (prev - 1 + eventItems.length) % eventItems.length);

    const currentItem = eventItems[currentItemIndex] || null;

    const getEventTypeColorClass = (type) => {
        switch (String(type).toLowerCase()) {
            case 'conférence': return 'bg-conference';
            case 'atelier': return 'bg-atelier';
            case 'assemblée': return 'bg-assemblee';
            default: return 'bg-default';
        }
    };

    return (
        <>
            <InspectorControls>
                <PanelBody title={__('Paramètres Généraux', 'mon-theme-aca')}>
                    <TextControl label={__('Titre de la section', 'mon-theme-aca')} value={sectionTitle} onChange={(val) => setAttributes({ sectionTitle: val })} />
                    <TextControl label={__('Sous-titre', 'mon-theme-aca')} value={sectionSubtitle} onChange={(val) => setAttributes({ sectionSubtitle: val })} />
                </PanelBody>

                <PanelBody title={__('Options d\'Affichage', 'mon-theme-aca')}>
                    <ToggleControl label={__('Afficher le calendrier', 'mon-theme-aca')} checked={showCalendar} onChange={(val) => setAttributes({ showCalendar: val })} />
                    <ToggleControl label={__('Afficher le type d\'événement', 'mon-theme-aca')} checked={showEventType} onChange={(val) => setAttributes({ showEventType: val })} />
                    <ToggleControl label={__('Afficher l\'heure', 'mon-theme-aca')} checked={showTime} onChange={(val) => setAttributes({ showTime: val })} />
                    <ToggleControl label={__('Afficher le lieu', 'mon-theme-aca')} checked={showLocation} onChange={(val) => setAttributes({ showLocation: val })} />
                    <ToggleControl label={__('Afficher les participants', 'mon-theme-aca')} checked={showParticipants} onChange={(val) => setAttributes({ showParticipants: val })} />
                </PanelBody>

                <PanelBody title={__('Gestion des Événements', 'mon-theme-aca')}>
                    <Button variant="primary" onClick={addItem} style={{ marginBottom: '1rem' }}>{__('Ajouter un événement', 'mon-theme-aca')}</Button>
                    
                    {eventItems.length > 0 && currentItem && (
                        <>
                            <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', marginBottom: '1rem', borderTop: '1px solid #ddd', paddingTop: '1rem' }}>
                                <Button onClick={goToPrevItem} disabled={eventItems.length <= 1}>{'<'}</Button>
                                <strong>{`Événement ${currentItemIndex + 1}`}</strong>
                                <Button onClick={goToNextItem} disabled={eventItems.length <= 1}>{'>'}</Button>
                            </div>

                            <div>
                                <TextControl label={__('Titre', 'mon-theme-aca')} value={currentItem.title} onChange={(val) => updateItem(currentItemIndex, 'title', val)} />
                                <BaseControl label={__('Date', 'mon-theme-aca')} id={`event-date-picker-${currentItem.id}`}>
                                    <DatePicker currentDate={currentItem.date} onChange={(newDate) => updateItem(currentItemIndex, 'date', newDate.split('T')[0])} />
                                </BaseControl>
                                <TextControl label={__('Lieu', 'mon-theme-aca')} value={currentItem.location} onChange={(val) => updateItem(currentItemIndex, 'location', val)} />
                                <TextControl label={__('Heure', 'mon-theme-aca')} value={currentItem.time} onChange={(val) => updateItem(currentItemIndex, 'time', val)} />
                                <TextControl label={__('Participants', 'mon-theme-aca')} value={currentItem.participants} onChange={(val) => updateItem(currentItemIndex, 'participants', val)} />
                                <SelectControl
                                    label={__('Type', 'mon-theme-aca')}
                                    value={currentItem.type}
                                    options={[ { label: 'Conférence', value: 'Conférence' }, { label: 'Atelier', value: 'Atelier' }, { label: 'Assemblée', value: 'Assemblée' }, { label: 'Autre', value: 'Autre' }]}
                                    onChange={(val) => updateItem(currentItemIndex, 'type', val)} />
                                <TextControl label={__('Lien', 'mon-theme-aca')} value={currentItem.link} onChange={(val) => updateItem(currentItemIndex, 'link', val)} />
                                
                                <Button isDestructive style={{ marginTop: '1rem' }} onClick={() => removeItem(currentItemIndex)}>{__('Supprimer', 'mon-theme-aca')}</Button>
                            </div>
                        </>
                    )}
                </PanelBody>
            </InspectorControls>

            <div {...blockProps}>
                <section className="events-container">
                    <div className="section-header">
                        <h2 className="section-title">{sectionTitle}</h2>
                        <p className="section-subtitle">{sectionSubtitle}</p>
                    </div>
                    <div className="events-layout">
                        {showCalendar && (
                            <div className="calendar-wrapper">
                                <CalendarPreview events={eventItems} />
                            </div>
                        )}
                        <div className="events-list-wrapper">
                            {eventItems.map(event => {
                                const dateObj = new Date(event.date);
                                return (
                                    <div className="event-card" key={event.id}>
                                        <div className="event-card-date">
                                            <div className="day">{dateObj.getDate() || '??'}</div>
                                            <div className="month">{dateObj.toLocaleDateString('fr-FR', { month: 'short' }) || '???'}</div>
                                        </div>
                                        <div className="event-card-details">
                                            <div className="event-header">
                                                <h3 className="event-title">{event.title}</h3>
                                                {showEventType && <span className={`event-type-badge ${getEventTypeColorClass(event.type)}`}>{event.type}</span>}
                                            </div>
                                            <div className="event-meta">
                                                {showLocation && <div className="meta-item"><Icon type="map" /><span>{event.location}</span></div>}
                                                {showTime && <div className="meta-item"><Icon type="clock" /><span>{event.time}</span></div>}
                                                {showParticipants && <div className="meta-item"><Icon type="users" /><span>{`${event.participants} participants attendus`}</span></div>}
                                            </div>
                                            <div className="event-actions">
                                                <Button isPrimary>{__("S'inscrire", 'mon-theme-aca')}</Button>
                                                <Button isSecondary>{__('Voir détails', 'mon-theme-aca')}</Button>
                                            </div>
                                        </div>
                                    </div>
                                );
                            })}
                        </div>
                    </div>
                </section>
            </div>
        </>
    );
}