<style>
    .today {
        background-color: rgba(253, 230, 255, 0.32) !important;
    }

    .event {
        background-color: rgba(202, 94, 255, 0.36) !important;
    }
</style>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <button class="btn btn-primary" onclick="previousMonth()">&lt; Vorige maand</button>
                        <h5 class="card-title" id="month-year"></h5>
                        <button class="btn btn-primary" onclick="nextMonth()">Volgende Maand &gt;</button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Sun</th>
                                <th scope="col">Mon</th>
                                <th scope="col">Tue</th>
                                <th scope="col">Wed</th>
                                <th scope="col">Thu</th>
                                <th scope="col">Fri</th>
                                <th scope="col">Sat</th>
                            </tr>
                        </thead>
                        <tbody id="calendar-body">
                            <!-- Calendar content will be dynamically generated here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach ($activities as $activiteit)
    @include('include.activityModal', ['activiteit' => $activiteit])
@endforeach
<script>
    let currentMonth = new Date().getMonth();
    let currentYear = new Date().getFullYear();

    // Example events (start and end dates)
    const events = [
        @foreach ($activities as $activity)
            {
                id: {{ $activity->id }},
                start: new Date("{{ $activity->startDate->toISOString() }}"),
                end: new Date("{{ $activity->endDate->toISOString() }}")
            },
        @endforeach
    ];
    console.log(events);
    document.addEventListener('DOMContentLoaded', function() {
        displayCalendar();
    });

    function displayCalendar() {
        // Display month and year in the card header
        document.getElementById('month-year').innerText = new Intl.DateTimeFormat('en-US', {
            month: 'long',
            year: 'numeric'
        }).format(new Date(currentYear, currentMonth, 1));

        const calendarBody = document.getElementById('calendar-body');
        calendarBody.innerHTML = '';

        // Get the first day of the month and the total number of days in the month
        const firstDay = new Date(currentYear, currentMonth, 1);
        const lastDay = new Date(currentYear, currentMonth + 1, 0);

        let currentDate = new Date(firstDay);

        // Adjust to the correct starting day
        currentDate.setDate(1 - (firstDay.getDay() + 6) % 7 - 1);

        while (currentDate <= lastDay) {
            const row = document.createElement('tr');

            for (let i = 0; i < 7; i++) {
                const cell = document.createElement('td');


                // Highlight the cell if it is the current day
                if (currentDate.toDateString() === new Date().toDateString()) {
                    cell.classList.add('today');
                }

                // Check if the current date is within any events
                let res = isDateInEvents(currentDate, events);
                if (res[0]) {
                    const a = document.createElement('a');
                    a.setAttribute('data-bs-toggle', 'modal')
                    a.setAttribute('data-bs-target', '#showModal' + res[1])
                    a.style.cursor = "pointer";
                    a.textContent = currentDate.getDate();
                    cell.appendChild(a);
                    cell.classList.add('event');
                } else {
                    cell.textContent = currentDate.getDate();
                }


                row.appendChild(cell);
                currentDate.setDate(currentDate.getDate() + 1);
            }

            calendarBody.appendChild(row);
        }
    }

    function isDateInEvents(date, events) {
        let newdate = new Date;

        if (newdate.getMonth() !== currentMonth || newdate.getFullYear() !== currentYear) {
            return false;
        }
        let id = null;
        const result = events.some(event => {

            const startUTC = new Date(event.start);
            const endUTC = new Date(event.end);

            startUTC.setUTCHours(0, 0, 0, 0);
            endUTC.setUTCHours(23, 59, 59, 999);
            newdate.setDate(date.getDate());
            let comparison = newdate.getTime() >= startUTC.getTime() && newdate.getTime() <= endUTC.getTime();
            if (comparison) {
                id = event.id;
            }
            return comparison;
        });

        console.log(`Checking date: ${date.toISOString()}. Result: ${result}`);
        return [result, id];
    }

    function previousMonth() {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        displayCalendar();
    }

    function nextMonth() {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        displayCalendar();
    }
</script>
