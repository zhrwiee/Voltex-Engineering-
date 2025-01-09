<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Real Calendar</title>
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 14px;
    }

    th, td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: center;
      cursor: pointer;
    }

    th {
      background-color: #f2f2f2;
    }

    .month-year {
      text-align: center;
      font-size: 18px;
      margin-bottom: 10px;
    }

    .prev, .next {
      cursor: pointer;
      font-weight: bold;
      text-decoration: underline;
      margin-right: 10px;
    }

    .time-slots {
      display: none;
      margin-top: 10px;
    }

    .time-slot {
      display: inline-block;
      margin-right: 10px;
      cursor: pointer;
    }

    .selected {
      font-weight: bold;
    }
  </style>
</head>
<body>

  <div class="month-year" id="monthYear">February 2024</div>

  <div>
    <span class="prev" onclick="previousMonth()">Previous</span>
    <button onclick="goToCurrentDate()">Current Date</button>
    <span class="next" onclick="nextMonth()">Next</span>
  </div>

  <table id="calendar">
    <thead>
      <tr>
        <th>Sun</th>
        <th>Mon</th>
        <th>Tue</th>
        <th>Wed</th>
        <th>Thu</th>
        <th>Fri</th>
        <th>Sat</th>
      </tr>
    </thead>
    <tbody>
      <!-- Calendar content will be generated here -->
    </tbody>
  </table>

  <div class="time-slots" id="timeSlots">
    <div class="time-slot" onclick="selectTimeSlot(this, '8am')">8am</div>
    <div class="time-slot" onclick="selectTimeSlot(this, '2pm')">2pm</div>
  </div>

  <script>
    let currentYear = 2024;
    let currentMonth = 1;

    function generateCalendar(year, month) {
      const calendarBody = document.querySelector('#calendar tbody');
      const monthYearElement = document.getElementById('monthYear');
      const currentDate = new Date(year, month - 1, 1);
      const daysInMonth = new Date(year, month, 0).getDate();
      const startingDay = currentDate.getDay();

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
            cell.setAttribute('onclick', `showTimeSlots(${dayCounter})`);
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
    }

    function selectTimeSlot(element, time) {
    const selectedDay = document.getElementById('timeSlots').dataset.selectedDay;

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
    const data = `selectedDate=${currentYear}-${currentMonth}-${selectedDay}&selectedTime=${time}`;
    xhr.send(data);

    // You can perform further actions here, like updating the UI
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

    function goToCurrentDate() {
        const currentDate = new Date();
        currentYear = currentDate.getFullYear();
        currentMonth = currentDate.getMonth() + 1;
        generateCalendar(currentYear, currentMonth);
        hideTimeSlots();
    }
  </script>

</body>
</html>
