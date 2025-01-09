<?php

include ('connect-server.php');

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    echo "<script>alert('You must be logged in to view this page. Go to login page?');</script>";
    echo "<script>setTimeout(function(){ window.location.href = 'log-in.php'; }, 2000);</script>";
    exit;
}

?>

<html>
    <head>
        <link rel="stylesheet" href="book.css">
        <link rel="stylesheet" href="book-tab2.css">
        <link rel="stylesheet" href="book-tab3.css">
        <link rel="stylesheet" href="font.css">
        <script src="https://js.stripe.com/v3/"></script>
        <meta charset="UTF-8">
        <?php include 'header.php'; ?>
    </head>
    <body>
        <div class="div-section">
            <div class="top-heading"> 
                <div class="layer"></div>
                <div class="title">Book With Us</div>
            </div>
            <div class="mid-section">
                <div class="booking-section">
                    <div class="tab-section">
                        <div class="tab-name" data-tab="1">Booking</div>
                        <div class="tab-name" data-tab="2">Details</div>
                        <div class="tab-name" data-tab="3">Payment</div>
                        <div class="tab-name" data-tab="4">Done</div>
                    </div>

                    <div class="tab-container">
                        <div class="tab active" id="tab1"> 
                            <form method="post" action="">
                                <div class="double-col">
                                    <div class="col-1">        
                                        <label for="building-type">Building Type<span class="error" style="color: red;"> *</span></label><br>
                                        <select id="building-type" name="building-type" onchange="updateServiceListDropdown()">
                                            <option value disabled selected>--Select--</option>
                                            <option value="Residential">Residential</option>
                                            <option value="Commercial">Commercial</option>
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <?php
                                            $query = "SELECT * FROM service_price";

                                            $result = mysqli_query($conn, $query);

                                            if ($result) {
                                                echo '<label for="service-list">Service List<span class="error" style="color: red;"> *</span></label><br>';
                                                echo '<select id="service-list" name="service-list">';
                                                echo '<option value disabled selected>--Select--</option>';
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $serviceName = $row['services'];
                                                    echo '<option value="' . $serviceName . '">' . $serviceName . '</option>';
                                                }
                                                echo '</select>';
                                            } else {
                                                echo "Failed to fetch service options.";
                                            }
                                        ?>
                                    </div>
                                </div>
                                
                                <div class="centered">
                                    <div class="calendar-timeslot">
                                        <div class="calendar-section">
                                            <div class="calendar-header">
                                                <div class="prev" onclick="previousMonth()"><img src="img/caret-left-solid.svg"></div>
                                                <div class="current-date" onclick="goToCurrentDate()"><i class="fa-solid fa-calendar-day" style="color: #002992;"></i></div>
                                                <div class="month-year" id="monthYear">January 2024</div>
                                                <div class="next" onclick="nextMonth()"><i class="fa-solid fa-caret-left fa-flip-horizontal fa-lg" style="color: #002992;"></i></div>
                                            </div>
                                            <div class="display-calendar">
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
                                            </div>
                                        </div>
                                        <div class="display-timeslot">
                                            <div class="timeslot-header">Timeslot</div>
                                            <div class="time-slots" id="timeSlots">
                                                <div class="center-timeslot">
                                                    <div class="time-slot" onclick="selectTimeSlot(this, '8am')">8 AM</div>
                                                </div>
                                                <br>
                                                <div class="center-timeslot">
                                                    <div class="time-slot" onclick="selectTimeSlot(this, '2pm')">2 PM</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="selection-summary">
                                            <div>Selected Date<br><span id="displaySelectedDate">None</span></div><br>
                                            <div>Selected Timeslot<br><span id="displaySelectedTimeslot">None</span></div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="button-container">
                                <button class="prev-tab1" onclick="prevTab()">Previous</button>
                                <button onclick="nextTab()">Next</button>
                            </div>
                        </div>

                        <div class="tab" id="tab2"> <!-- details -->
                            <div class="form-2">
                                <form class="form-tab-2" method="post" action="">
                                    <label for="address1">Address Line 1<span class="error" style="color: red;"> *</span></label><br>
                                    <input type="text" name="address1" placeholder="House number, street name">
                                    <br><br>
                                    <label for="address2">Address Line 2<span class="error" style="color: red;"> *</span></label><br>
                                    <input type="text" name="address2" placeholder="City, State">
                                    <br><br>
                                    <div class="triple-col">
                                        <div>        
                                            <label for="postcode">Postcode<span class="error" style="color: red;"> *</span></label><br>
                                            <input type="text" name="postcode">
                                        </div>
                                        <div>
                                            <label for="city">City<span class="error" style="color: red;"> *</span></label><br>
                                            <input type="text" name="city">
                                        </div>
                                        <div>
                                            <label for="state">State<span class="error" style="color: red;"> *</span></label><br>
                                            <input type="text" name="state">
                                        </div>
                                    </div>
                                    <br>
                                    <label for="remarks">Service Remarks</label><br>
                                    <input type="text" name="remarks">
                                </form>
                            </div>
                            <div class="button-container">
                                <button class="prev" onclick="prevTab()">Previous</button>
                                <button onclick="nextTab()">Next</button>
                            </div>
                        </div>

                        <div class="tab" id="tab3">
                            <div class="summary">
                                <h2>Booking Summary</h2>
                                <div id="bookingSummary">
                                    <p><strong>Building Type:</strong> <span id="summaryBuildingType"></span></p>
                                    <p><strong>Service List:</strong> <span id="summaryServiceList"></span></p>
                                    <p><strong>Date:</strong> <span id="summaryDate"></span></p>
                                    <p><strong>Time:</strong> <span id="summaryTime"></span></p>
                                    <p class="price"><strong>Deposit:</strong> RM <span id="summaryPrice"></span></p>
                                </div>
                                <div class="button-container">
                                    <button class="prev" onclick="prevTab()">Previous</button>
                                    <button class="proceed-payment" onclick="nextTab()">Proceed to Payment</button>
                                </div>
                            </div>
                        </div>

                        <div class="tab" id="tab4">
                            <div class="center-content">
                                <div class="content">
                                    <div>
                                        <p>Your booking has been<br> successfully made!</p>
                                        <span><img src="img/accept.png"></span> 
                                        <p class="bold">Thank you for booking with us!</p>
                                        <p>We will provide the best <br>service for your needs.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="button-container">
                                <button onclick="window.location.href = 'index.php';">Done</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </body>
    <script>
        const stripe = Stripe('pk_test_51OZRJYHejhKRUlQpQN77pCLfw5CSQGmqye9mgRaSWkFDt3B3Fuy0Wo7IyzkQbB3xP67GfsL6rrSVDNtnMZBZarkz00HyBfO6BN');
        
        window.onload = function() {
            var urlParams = new URLSearchParams(window.location.search);
            var tabIndex = urlParams.get('tab');

            if (tabIndex) {
                showTab(parseInt(tabIndex));
            } else {
                showTab(currentTab); 
            }

            document.getElementById('displaySelectedDate').textContent = 'None';
            document.getElementById('displaySelectedTimeslot').textContent = 'None';
        };

        let currentTab = 1;

        function showTab(tabIndex) {
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('active');
            });

            document.getElementById(`tab${tabIndex}`).classList.add('active');

            // Highlight the active tab name
            document.querySelectorAll('.tab-name').forEach(name => {
                name.classList.remove('active');
                if (name.getAttribute('data-tab') == tabIndex) {
                name.classList.add('active');
                }
            });

            currentTab = tabIndex;

            if (tabIndex === 3) {
                document.getElementById('summaryBuildingType').textContent = bookingData.buildingType || 'N/A';
                document.getElementById('summaryServiceList').textContent = bookingData.serviceList || 'N/A';
                document.getElementById('summaryDate').textContent = bookingData.selectedDate || 'N/A';
                document.getElementById('summaryTime').textContent = bookingData.selectedTime || 'N/A';
   
                calculatePrice(bookingData, function (price) {

                    console.log('Fetched price:', price);
                    document.getElementById('summaryPrice').textContent = price;
                });
            }
        }

        function calculatePrice(data, callback) {
            if (data.serviceList) {

                const xhr = new XMLHttpRequest();
                xhr.open('GET', `get_price.php?service=${data.serviceList}`, true);

                xhr.onload = function () {
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        const price = response.price || 0; 
                        callback(price);
                    } else {
                        console.error('Failed to fetch price');
                        callback(0); 
                    }
                };
                xhr.send();
            } else {
                callback(0);
            }
        }

        let bookingData = {
            buildingType: null,
            serviceList: null,
            address1: null,
            address2: null,
            postcode: null,
            city: null,
            state: null,
            remarks: null,
            selectedDate: null,
            selectedTime: null,
            user_id: <?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'null'; ?>
        };

        function nextTab() {

            let validationFailed = false;

            if (currentTab === 1) {
                const buildingType = document.getElementById('building-type').value;
                const serviceList = document.getElementById('service-list').value;
                if (!buildingType || !serviceList) { 
                    alert('Please fill in all required fields.');
                    validationFailed = true;
                }

                if (!selectedDateTime || !selectedDateTime.selectedDate || !selectedDateTime.selectedTime) {
                    alert('Make sure date and time slot is selected.');
                    validationFailed = true;
                }

                if (validationFailed) return;
                bookingData.buildingType = document.getElementById('building-type').value;
                bookingData.serviceList = document.getElementById('service-list').value;
                bookingData.selectedDate = selectedDateTime ? selectedDateTime.selectedDate : null;
                bookingData.selectedTime = selectedDateTime ? selectedDateTime.selectedTime : null;
            } else if (currentTab === 2) {
                const address1 = document.querySelector('[name="address1"]').value;
                const address2 = document.querySelector('[name="address2"]').value;
                const postcode = document.querySelector('[name="postcode"]').value;
                const city = document.querySelector('[name="city"]').value;
                const state = document.querySelector('[name="state"]').value;
                if (!address1 || !address2 || !postcode || !city || !state) {
                    alert('Please fill in all required fields.');
                    return; 
                }
                bookingData.address1 = document.querySelector('[name="address1"]').value;
                bookingData.address2 = document.querySelector('[name="address2"]').value;
                bookingData.postcode = document.querySelector('[name="postcode"]').value;
                bookingData.city = document.querySelector('[name="city"]').value;
                bookingData.state = document.querySelector('[name="state"]').value;
                bookingData.remarks = document.querySelector('[name="remarks"]').value;
            }

            if (currentTab === 3) {
                saveDataToDatabase();
                return;
            } else if (currentTab < 4) {
                currentTab++;
                showTab(currentTab);
            }
        }

        function prevTab() {
            if (currentTab > 1) {
                showTab(currentTab - 1);
            }
        }

        showTab(currentTab);


        let currentYear = 2024;
        let currentMonth = 1;

        function generateCalendar(year, month) {
            const calendarBody = document.querySelector('#calendar tbody');
            const monthYearElement = document.getElementById('monthYear');
            const currentDate = new Date(year, month - 1, 1);
            const daysInMonth = new Date(year, month, 0).getDate();
            const startingDay = currentDate.getDay();
            const today = new Date();

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

                        const cellDate = new Date(year, month - 1, dayCounter);
                        if (cellDate < today) {
                            cell.classList.add('past-date');
                            cell.setAttribute('onclick', 'return false;');
                        } else {
                            cell.setAttribute('onclick', `showTimeSlots(${dayCounter})`);
                        }
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

            document.querySelectorAll('#calendar tbody td').forEach(cell => {
                cell.classList.remove('selected-date');
            });

            document.querySelectorAll('.time-slot').forEach(slot => {
                    slot.classList.remove('selected');
                });

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

            if (selectedDateTime) {
                selectedDateTime.selectedTime = null; 
            }

            document.getElementById('displaySelectedTimeslot').textContent = 'None';

            document.querySelectorAll('.time-slot').forEach(slot => {
                slot.classList.remove('selected');
            });

            const displayDate = `${currentYear}-${currentMonth}-${day}`;
            document.getElementById('displaySelectedDate').textContent = displayDate;

            updateAvailableTimeSlots();
        }

        function updateAvailableTimeSlots(bookedSlots) {
            document.querySelectorAll('.time-slot').forEach(slot => {
                slot.classList.remove('selected', 'disabled');
                slot.onclick = function() { selectTimeSlot(this, slot.textContent); };

                if (bookedSlots.includes(slot.textContent)) {
                    slot.classList.add('disabled');
                    slot.onclick = null; 
                }
            });
        }


        let selectedDateTime = null;

        function selectTimeSlot(element, time) {
            const selectedDay = document.getElementById('timeSlots').dataset.selectedDay;

                selectedDateTime = {
                    selectedDate: `${currentYear}-${currentMonth}-${selectedDay}`,
                    selectedTime: time
                };

                document.querySelectorAll('.time-slot').forEach(slot => {
                    slot.classList.remove('selected');
                });
                element.classList.add('selected');

                console.log("Selected Date: " + bookingData.selectedDate);
                console.log("Selected Time: " + bookingData.selectedTime);

                document.getElementById('displaySelectedTimeslot').textContent = time;
            }

        function saveDataToDatabase() {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'save_selection.php', true);
            xhr.setRequestHeader('Content-type', 'application/json');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    initiateStripePayment();
                }
            };
            xhr.send(JSON.stringify(bookingData));
            console.log("Data sent to server: ", JSON.stringify(bookingData));
        }

        function initiateStripePayment() {
            fetch('checkout-session.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({bookingData: bookingData}),
            })
            .then(function(response) {
                return response.json();
            })
            .then(function(session) {
                return stripe.redirectToCheckout({sessionId: session.id});
            })
            .then(function(result) {
                if (result.error) {
                    alert(result.error.message);
                }
            })
            .catch(function(error) {
                console.error('Error:', error);
            });
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

        generateCalendar(currentYear, currentMonth);
        goToCurrentDate();

    </script>
</html>