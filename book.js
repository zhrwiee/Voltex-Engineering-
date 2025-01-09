let currentTab = 1;

        function showTab(tabIndex) {
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('active');
            });

            document.getElementById(`tab${tabIndex}`).classList.add('active');

            document.querySelectorAll('.tab-name').forEach(name => {
                name.classList.remove('active');
                if (name.getAttribute('data-tab') == tabIndex) {
                name.classList.add('active');
                }
            });

            currentTab = tabIndex;
        }

        function nextTab() {
            if (currentTab < 4) {
                showTab(currentTab + 1);
            }
        }

        function prevTab() {
            if (currentTab > 1) {
                showTab(currentTab - 1);
            }
        }

        // Show the initial tab
        showTab(currentTab);



        let currentYear = 2024;
        let currentMonth = 1;

        function generateCalendar(year, month) {
            const calendarBody = document.querySelector('#calendar tbody');
            const monthYearElement = document.getElementById('monthYear');
            const currentDate = new Date(year, month - 1, 1);
            const daysInMonth = new Date(year, month, 0).getDate();
            const startingDay = currentDate.getDay();
            const today = new Date(); // Get the current date

            monthYearElement.textContent = new Intl.DateTimeFormat('en-US', { year: 'numeric', month: 'long' }).format(currentDate);

            calendarBody.innerHTML = '';

            let dayCounter = 1;

            for (let i = 0; i < 6; i++) {
                const row = document.createElement('tr');

                for (let j = 0; j < 7; j++) {
                    const cell = document.createElement('td');

                    if (i === 0 && j < startingDay) {
                        cell.textContent = '';
                    } else if (dayCounter > daysInMonth) {
                        cell.textContent = '';
                    } else {
                        cell.textContent = dayCounter;
                        cell.setAttribute('data-day', dayCounter);

                        // Check if the date is in the past
                        const cellDate = new Date(year, month - 1, dayCounter);
                        if (cellDate < today) {
                            cell.classList.add('past-date');
                            cell.setAttribute('onclick', 'return false;'); // Disable click for past dates
                        } else {
                            cell.setAttribute('onclick', `showTimeSlots(${dayCounter})`);
                        }

                        // Add a class for today's date
                        if (today.getFullYear() === currentYear && today.getMonth() === (currentMonth - 1) && today.getDate() === dayCounter) {
                            cell.classList.add('today');
                        }
                        dayCounter++;
                    }
                    row.appendChild(cell);
                }
                calendarBody.appendChild(row);
            }
        }

        function showTimeSlots(day) {
            const timeSlotsElement = document.getElementById('timeSlots');
            timeSlotsElement.style.display = 'block';
            timeSlotsElement.dataset.selectedDay = day;

            // Remove the selected-date class from all date cells
            document.querySelectorAll('#calendar tbody td').forEach(cell => {
                cell.classList.remove('selected-date');
            });

            document.querySelectorAll('.time-slot').forEach(slot => {
                    slot.classList.remove('selected');
                });

            // Highlight the clicked date cell
            const selectedDateCell = document.querySelector(`#calendar tbody td[data-day="${day}"]`);
            if (selectedDateCell) {
                selectedDateCell.classList.add('selected-date');
            }

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'get_time_slots.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    updateAvailableTimeSlots(JSON.parse(xhr.responseText));
                }
            };
            const data = `selectedDate=${currentYear}-${currentMonth}-${day}`;
            xhr.send(data);
        }

        function updateAvailableTimeSlots(bookedSlots) {
            document.querySelectorAll('.time-slot').forEach(slot => {
                slot.classList.remove('selected', 'disabled');
                slot.onclick = function() { selectTimeSlot(this, slot.textContent); };

                // If the slot is booked, disable it
                if (bookedSlots.includes(slot.textContent)) {
                    slot.classList.add('disabled');
                    slot.onclick = null; // Remove click event for booked slots
                }
            });
        }


        let selectedDateTime = null;

        function selectTimeSlot(element, time) {
            const selectedDay = document.getElementById('timeSlots').dataset.selectedDay;

            // Store the selected date and time
            selectedDateTime = {
                selectedDate: `${currentYear}-${currentMonth}-${selectedDay}`,
                selectedTime: time
            };

            // Highlight the selected time slot
            document.querySelectorAll('.time-slot').forEach(slot => {
                slot.classList.remove('selected');
            });
            element.classList.add('selected');
        }

        function saveDataToDatabase() {
            const selectedDay = document.getElementById('timeSlots').dataset.selectedDay;

            // Get the selected time slot
            const selectedTimeElement = document.querySelector('.time-slot.selected');
            const selectedTime = selectedTimeElement ? selectedTimeElement.textContent : '';

            if (selectedDay && selectedTime) {
                // Send data to the server using AJAX
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'save_selection.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // Handle the response from the server if needed
                        alert(xhr.responseText);
                    }
                };
                const data = `selectedDate=${currentYear}-${currentMonth}-${selectedDay}&selectedTime=${selectedTime}`;
                xhr.send(data);
            } else {
                alert('Please select a date and time before proceeding.');
            }

            nextTab(); // Move to the next tab after saving data 
        }

        function goToCurrentDate() {
            const currentDate = new Date();
            currentYear = currentDate.getFullYear();
            currentMonth = currentDate.getMonth() + 1;
            generateCalendar(currentYear, currentMonth);
            
            hideTimeSlots();
        }

        function nextMonth() {
            currentMonth++;
            if (currentMonth > 12) {
                currentMonth = 1;
                currentYear++;
            }
            generateCalendar(currentYear, currentMonth);
            hideTimeSlots();
        }

        function previousMonth() {
            currentMonth--;
            if (currentMonth < 1) {
                currentMonth = 12;
                currentYear--;
            }
            generateCalendar(currentYear, currentMonth);
            hideTimeSlots();
        }

        function hideTimeSlots() {
            const timeSlotsElement = document.getElementById('timeSlots');
            timeSlotsElement.style.display = 'none';
        }

        // Initial calendar display for January 2024
        generateCalendar(currentYear, currentMonth);
        goToCurrentDate();