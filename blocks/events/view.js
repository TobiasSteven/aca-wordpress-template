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

    if (!calendarContainer) return;

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
                dayElement.addEventListener('click', () => {
                    // Retirer la classe 'selected' de tous les jours
                    calendarGrid.querySelectorAll('.day-number.selected').forEach(day => {
                        day.classList.remove('selected');
                    });

                    // Ajouter la classe 'selected' au jour cliqué
                    dayElement.classList.add('selected');

                    // Optionnel : filtrer les événements par date sélectionnée
                    filterEventsByDate(date);
                });
            }

            calendarGrid.appendChild(dayElement);
        }
    }

    function filterEventsByDate(selectedDate) {
        const eventCards = blockElement.querySelectorAll('.event-card');
        const selectedDateStr = selectedDate.toISOString().split('T')[0];

        eventCards.forEach(card => {
            const eventDateElement = card.querySelector('.event-date');
            if (!eventDateElement) return;

            // Cette fonctionnalité nécessiterait des données supplémentaires
            // Pour l'instant, on peut juste ajouter un effet visuel
            card.style.opacity = '0.5';
            setTimeout(() => {
                card.style.opacity = '1';
            }, 200);
        });
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
            }
            
            .wp-block-mon-theme-aca-events .calendar-nav-btn:focus {
                outline: 2px solid #2D9B8A;
                outline-offset: 2px;
            }
            
            .wp-block-mon-theme-aca-events .day-number:focus {
                outline: 2px solid #2D9B8A;
                outline-offset: 2px;
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
