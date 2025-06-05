/**
 * JavaScript for Events Block Frontend Interactivity
 */
document.addEventListener('DOMContentLoaded', function () {
    // Initialize all event calendars on the page
    const eventBlocks = document.querySelectorAll('.wp-block-mon-theme-aca-events');

    eventBlocks.forEach(block => {
        initializeEventCalendar(block);
    });
});

function initializeEventCalendar(blockElement) {
    const calendarContainer = blockElement.querySelector('.calendar-container');

    if (!calendarContainer) {
        return;
    }

    let currentDate = new Date();

    const monthYearElement = calendarContainer.querySelector('.month-year');
    const calendarGrid = calendarContainer.querySelector('.calendar-grid');
    const prevButton = calendarContainer.querySelector('[data-direction="prev"]');
    const nextButton = calendarContainer.querySelector('[data-direction="next"]');

    if (!monthYearElement || !calendarGrid || !prevButton || !nextButton) return;

    // Navigation du calendrier
    prevButton.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        updateCalendar();
    });

    nextButton.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        updateCalendar();
    });

    function updateCalendar() {
        const monthNames = [
            'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
            'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
        ];

        // Mettre à jour l'en-tête
        monthYearElement.textContent = `${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}`;

        // Régénérer la grille du calendrier
        generateCalendarGrid();
    }

    function generateCalendarGrid() {
        const monthNames = [
            'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
            'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
        ];

        const today = new Date();
        const currentMonth = currentDate.getMonth();
        const currentYear = currentDate.getFullYear();

        const firstDay = new Date(currentYear, currentMonth, 1);
        const lastDay = new Date(currentYear, currentMonth + 1, 0);
        const startDate = new Date(firstDay);
        startDate.setDate(startDate.getDate() - firstDay.getDay());

        // Vider la grille (garder les en-têtes des jours)
        const dayHeaders = calendarGrid.querySelectorAll('.day-name');
        calendarGrid.innerHTML = '';

        // Remettre les en-têtes des jours
        dayHeaders.forEach(header => {
            calendarGrid.appendChild(header.cloneNode(true));
        });

        // Générer les jours
        for (let i = 0; i < 42; i++) {
            const date = new Date(startDate);
            date.setDate(startDate.getDate() + i);

            const isCurrentMonth = date.getMonth() === currentMonth;
            const isToday = date.toDateString() === today.toDateString();

            const dayElement = document.createElement('div');
            dayElement.className = 'day-number';

            if (!isCurrentMonth) {
                dayElement.classList.add('empty');
            }
            if (isToday) {
                dayElement.classList.add('today');
            }

            dayElement.textContent = isCurrentMonth ? date.getDate() : '';

            // Ajouter un événement de clic pour la sélection de date
            if (isCurrentMonth) {
                dayElement.style.cursor = 'pointer';
                dayElement.setAttribute('tabindex', '0');
                dayElement.setAttribute('role', 'button');
                dayElement.setAttribute('aria-label', `Sélectionner le ${date.getDate()} ${monthNames[currentMonth]} ${currentYear}`);

                dayElement.addEventListener('click', (e) => {
                    e.preventDefault();

                    // Retirer la classe 'selected' de tous les jours
                    calendarGrid.querySelectorAll('.day-number.selected').forEach(day => {
                        day.classList.remove('selected');
                    });

                    // Ajouter la classe 'selected' au jour cliqué
                    dayElement.classList.add('selected');

                    // Filtrer les événements par date sélectionnée
                    filterEventsByDate(date);
                });

                // Support du clavier pour l'accessibilité
                dayElement.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        dayElement.click();
                    }
                });
            }

            calendarGrid.appendChild(dayElement);
        }
    }

    function filterEventsByDate(selectedDate) {
        const eventCards = blockElement.querySelectorAll('.event-card');
        // Essayer plusieurs sélecteurs pour trouver la section des événements
        let eventsSection = blockElement.querySelector('.events-section');
        if (!eventsSection) {
            eventsSection = blockElement.querySelector('.events-section-frontend .events-section');
        }
        if (!eventsSection) {
            eventsSection = blockElement.querySelector('.events-section-frontend');
        }

        const selectedDateStr = selectedDate.toISOString().split('T')[0];

        let visibleEventsCount = 0;
        let hasEventsForDate = false;

        eventCards.forEach(card => {
            // Récupérer la date de l'événement depuis l'attribut data ou le contenu
            let eventDate = card.getAttribute('data-event-date');

            if (!eventDate) {
                // Extraire la date depuis les éléments visuels
                const dayElement = card.querySelector('.event-date .day');
                const monthElement = card.querySelector('.event-date .month');

                if (dayElement && monthElement) {
                    const day = parseInt(dayElement.textContent);
                    const monthText = monthElement.textContent.trim();

                    // Conversion des mois français en numéros
                    const monthMap = {
                        'JAN': 0, 'FÉV': 1, 'MAR': 2, 'AVR': 3, 'MAI': 4, 'JUN': 5,
                        'JUL': 6, 'AOÛT': 7, 'SEP': 8, 'OCT': 9, 'NOV': 10, 'DÉC': 11
                    };

                    const month = monthMap[monthText];
                    if (month !== undefined && !isNaN(day)) {
                        const eventDateObj = new Date(selectedDate.getFullYear(), month, day);
                        eventDate = eventDateObj.toISOString().split('T')[0];
                        // Stocker pour usage futur
                        card.setAttribute('data-event-date', eventDate);
                    }
                }
            }

            // Comparer les dates
            if (eventDate === selectedDateStr) {
                card.style.display = 'flex';
                card.classList.add('highlight-event');
                visibleEventsCount++;
                hasEventsForDate = true;
            } else {
                card.style.display = 'none';
                card.classList.remove('highlight-event');
            }
        });

        // Afficher un message si aucun événement pour cette date
        let noEventsMessage = eventsSection.querySelector('.no-events-for-date');

        if (!hasEventsForDate) {
            if (!noEventsMessage) {
                noEventsMessage = document.createElement('div');
                noEventsMessage.className = 'no-events-for-date';
                eventsSection.appendChild(noEventsMessage);
            }

            const dateStr = selectedDate.toLocaleDateString('fr-FR', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });

            noEventsMessage.innerHTML = `
                <p>Aucun événement programmé pour le <strong>${dateStr}</strong>.</p>
                <button class="show-all-events-btn" type="button">Voir tous les événements</button>
            `;
            noEventsMessage.style.display = 'block';

            // Ajouter l'événement pour le bouton "Voir tous"
            const showAllBtn = noEventsMessage.querySelector('.show-all-events-btn');
            if (showAllBtn) {
                showAllBtn.addEventListener('click', () => {
                    showAllEvents();
                    // Retirer la sélection du calendrier
                    calendarGrid.querySelectorAll('.day-number.selected').forEach(day => {
                        day.classList.remove('selected');
                    });
                });
            }
        } else {
            if (noEventsMessage) {
                noEventsMessage.style.display = 'none';
            }
        }

        // Mettre à jour le titre de la section
        const sectionTitle = eventsSection.querySelector('h1');
        if (sectionTitle && hasEventsForDate) {
            const originalTitle = sectionTitle.getAttribute('data-original-title') || sectionTitle.textContent;
            sectionTitle.setAttribute('data-original-title', originalTitle);

            const dateStr = selectedDate.toLocaleDateString('fr-FR', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
            sectionTitle.textContent = `Événements du ${dateStr}`;
        }
    }

    // Fonction pour afficher tous les événements
    function showAllEvents() {
        const eventCards = blockElement.querySelectorAll('.event-card');
        // Essayer plusieurs sélecteurs pour trouver la section des événements
        let eventsSection = blockElement.querySelector('.events-section');
        if (!eventsSection) {
            eventsSection = blockElement.querySelector('.events-section-frontend .events-section');
        }
        if (!eventsSection) {
            eventsSection = blockElement.querySelector('.events-section-frontend');
        }

        const noEventsMessage = eventsSection ? eventsSection.querySelector('.no-events-for-date') : null;
        const sectionTitle = eventsSection ? eventsSection.querySelector('h1') : null;

        // Afficher tous les événements
        eventCards.forEach(card => {
            card.style.display = 'flex';
            card.classList.remove('highlight-event');
        });

        // Cacher le message "aucun événement"
        if (noEventsMessage) {
            noEventsMessage.style.display = 'none';
        }

        // Restaurer le titre original
        if (sectionTitle) {
            const originalTitle = sectionTitle.getAttribute('data-original-title');
            if (originalTitle) {
                sectionTitle.textContent = originalTitle;
            }
        }
    }

    // Ajouter des styles CSS dynamiquement pour les états sélectionnés
    if (!document.getElementById('events-calendar-dynamic-styles')) {
        const style = document.createElement('style');
        style.id = 'events-calendar-dynamic-styles';
        style.textContent = `
            .wp-block-mon-theme-aca-events .day-number.selected {
                background-color: #1F6B5C !important; /* Dark Teal */
                color: white !important;
                font-weight: bold !important;
                cursor: pointer !important;
            }
            
            .wp-block-mon-theme-aca-events .day-number:not(.empty) {
                cursor: pointer !important;
                transition: background-color 0.2s ease !important;
            }
            
            .wp-block-mon-theme-aca-events .day-number:not(.empty):hover {
                background-color: #A8E6CF !important; /* Light Green */
                color: #1F6B5C !important;
            }
            
            .wp-block-mon-theme-aca-events .calendar-nav-btn:focus {
                outline: 2px solid #2D9B8A;
                outline-offset: 2px;
            }
            
            .wp-block-mon-theme-aca-events .day-number:focus {
                outline: 2px solid #2D9B8A;
                outline-offset: 2px;
            }
            
            .wp-block-mon-theme-aca-events .highlight-event {
                border: 2px solid #2D9B8A !important;
                box-shadow: 0 4px 16px rgba(45, 155, 138, 0.2) !important;
                transform: translateY(-2px) !important;
                transition: all 0.3s ease !important;
            }
            
            .wp-block-mon-theme-aca-events .no-events-for-date {
                background-color: #F8F9FA !important;
                border: 1px solid #E9ECEF !important;
                border-radius: 8px !important;
                padding: 20px !important;
                text-align: center !important;
                margin-top: 20px !important;
            }
            
            .wp-block-mon-theme-aca-events .no-events-for-date p {
                margin: 0 0 15px 0 !important;
                color: #6C757D !important;
                font-size: 16px !important;
            }
            
            .wp-block-mon-theme-aca-events .show-all-events-btn {
                background-color: #2D9B8A !important;
                color: white !important;
                border: none !important;
                padding: 10px 20px !important;
                border-radius: 6px !important;
                cursor: pointer !important;
                font-size: 14px !important;
                font-weight: 500 !important;
                transition: all 0.2s ease !important;
            }
            
            .wp-block-mon-theme-aca-events .show-all-events-btn:hover {
                background-color: #1F6B5C !important;
                transform: translateY(-1px) !important;
            }
            
            .wp-block-mon-theme-aca-events .events-section h1 {
                transition: all 0.3s ease !important;
            }
        `;
        document.head.appendChild(style);
    }

    // Accessibilité : support du clavier
    calendarGrid.addEventListener('keydown', (e) => {
        const focusedDay = calendarGrid.querySelector('.day-number:focus');
        if (!focusedDay) return;

        let newFocus = null;

        switch (e.key) {
            case 'ArrowLeft':
                newFocus = focusedDay.previousElementSibling;
                break;
            case 'ArrowRight':
                newFocus = focusedDay.nextElementSibling;
                break;
            case 'ArrowUp':
                const currentIndex = Array.from(calendarGrid.children).indexOf(focusedDay);
                newFocus = calendarGrid.children[currentIndex - 7];
                break;
            case 'ArrowDown':
                const currentIndexDown = Array.from(calendarGrid.children).indexOf(focusedDay);
                newFocus = calendarGrid.children[currentIndexDown + 7];
                break;
            case 'Enter':
            case ' ':
                focusedDay.click();
                e.preventDefault();
                break;
        }

        if (newFocus && newFocus.classList.contains('day-number') && !newFocus.classList.contains('empty')) {
            newFocus.focus();
            e.preventDefault();
        }
    });

    // Rendre les jours focusables
    calendarGrid.querySelectorAll('.day-number:not(.empty)').forEach(day => {
        day.setAttribute('tabindex', '0');
        day.setAttribute('role', 'button');
        day.setAttribute('aria-label', `Sélectionner le ${day.textContent}`);
    });
}
