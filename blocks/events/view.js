document.addEventListener('DOMContentLoaded', function () {
    const calendarElements = document.querySelectorAll('.calendar-component');

    calendarElements.forEach(calendarEl => {
        let currentMonth = new Date();
        const eventDates = JSON.parse(calendarEl.dataset.eventDates || '[]');
        
        const monthYearTitle = calendarEl.querySelector('.calendar-month-year-title');
        const gridHeader = calendarEl.querySelector('.calendar-grid-header');
        const gridBody = calendarEl.querySelector('.calendar-grid-body');
        const prevBtn = calendarEl.querySelector('[data-direction="prev"]');
        const nextBtn = calendarEl.querySelector('[data-direction="next"]');

        function renderCalendar() {
            gridHeader.innerHTML = '';
            gridBody.innerHTML = '';
            
            monthYearTitle.textContent = currentMonth.toLocaleDateString('fr-FR', {
                month: 'long',
                year: 'numeric'
            });

            const month = currentMonth.getMonth();
            const year = currentMonth.getFullYear();
            const today = new Date();
            today.setHours(0, 0, 0, 0); // Pour comparer les dates sans tenir compte de l'heure

            const firstDayOfMonth = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            
            ['L', 'M', 'M', 'J', 'V', 'S', 'D'].forEach(day => {
                const dayNameEl = document.createElement('div');
                dayNameEl.className = 'day-name';
                dayNameEl.textContent = day;
                gridHeader.appendChild(dayNameEl);
            });

            const startDay = firstDayOfMonth === 0 ? 6 : firstDayOfMonth - 1;
            for (let i = 0; i < startDay; i++) {
                const emptyCell = document.createElement('div');
                emptyCell.className = 'day-cell other-month';
                gridBody.appendChild(emptyCell);
            }

            for (let day = 1; day <= daysInMonth; day++) {
                const cell = document.createElement('div');
                cell.className = 'day-cell';
                cell.textContent = day;

                const thisDate = new Date(year, month, day);
                thisDate.setHours(0, 0, 0, 0);

                const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                
                if (eventDates.includes(dateStr)) {
                    cell.classList.add('has-event');
                }

                if (thisDate.getTime() === today.getTime()) {
                    cell.classList.add('is-today');
                }

                gridBody.appendChild(cell);
            }
        }

        prevBtn.addEventListener('click', () => {
            currentMonth.setMonth(currentMonth.getMonth() - 1);
            renderCalendar();
        });

        nextBtn.addEventListener('click', () => {
            currentMonth.setMonth(currentMonth.getMonth() + 1);
            renderCalendar();
        });

        renderCalendar();
    });
});