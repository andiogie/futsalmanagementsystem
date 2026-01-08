@extends('admin.layout')

@section('content')
<div class="p-4">
    <h1 class="text-xl sm:text-2xl font-bold mb-4 text-center">📅 Jadwal Booking</h1>

    <!-- Kalender -->
    <div id="calendar"></div>

    <!-- List booking per tanggal -->
    <div id="booking-list" class="mt-4 hidden bg-white shadow rounded-lg p-4 border">
        <h2 class="text-lg font-semibold mb-2">Booking di tanggal <span id="selected-date"></span></h2>
        <ul id="list-items" class="space-y-2 text-sm"></ul>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var listBox = document.getElementById('booking-list');
    var listItems = document.getElementById('list-items');
    var selectedDateEl = document.getElementById('selected-date');
    var selectedDate = null;

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: '{{ route("admin.api.bookings") }}',
        height: 'auto',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        },

        dayMaxEvents: true, // aktifkan "more"
    views: {
        dayGridMonth: {
            dayMaxEventRows: 3 // maksimal 3 event per kotak
        }
    },

        dateClick: function(info) {
            clearHighlight();
            info.dayEl.classList.add('selected-date-cell');
            selectedDate = info.dateStr;
            updateList(info.dateStr);
        },

        eventClick: function(info) {
            let dateStr = info.event.startStr.split("T")[0]; 
            selectedDate = dateStr;
            updateList(dateStr);
            highlightByDate(dateStr);
        },

        datesSet: function(info) {
            if (selectedDate) {
                highlightByDate(selectedDate);
            }
        }
    });

    calendar.render();

    // Fungsi helper untuk format waktu mulai (HH:MM)
    function formatTimeStart(date) {
        let hours = date.getHours().toString().padStart(2, '0');
        let minutes = date.getMinutes().toString().padStart(2, '0');
        return `${hours}:${minutes}`;
    }

    // Fungsi helper untuk format waktu selesai (HH.MM)
    function formatTimeEnd(date) {
        let hours = date.getHours().toString().padStart(2, '0');
        let minutes = date.getMinutes().toString().padStart(2, '0');
        return `${hours}.${minutes}`;
    }

    // fungsi update list di bawah kalender
    function updateList(dateStr) {
        var events = calendar.getEvents().filter(ev => {
            return ev.startStr.startsWith(dateStr);
        });

        // Urutkan dari pagi ke malam
        events.sort((a, b) => new Date(a.start) - new Date(b.start));

        selectedDateEl.textContent = new Date(dateStr).toLocaleDateString('id-ID', {
            weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'
        });

        listItems.innerHTML = '';

        if (events.length > 0) {
            events.forEach(ev => {
                // Format waktu: jam mulai (HH:MM) sd jam selesai (HH.MM)
                let jamMulai = formatTimeStart(ev.start);
                let jamSelesai = ev.end ? formatTimeEnd(ev.end) : 'XX.XX';
                
                let item = document.createElement('li');
                item.textContent = `${jamMulai} s/d ${jamSelesai} - ${ev.title}`;
                listItems.appendChild(item);
            });
        } else {
            let li = document.createElement('li');
            li.textContent = "Tidak ada booking di tanggal ini.";
            listItems.appendChild(li);
        }

        listBox.classList.remove('hidden');
    }

    // highlight untuk semua view
    function highlightByDate(dateStr) {
        clearHighlight();
        // untuk month view
        document.querySelectorAll(`.fc-daygrid-day[data-date="${dateStr}"]`).forEach(el => {
            el.classList.add('selected-date-cell');
        });
        // untuk week/day view → highlight kolom jam
        document.querySelectorAll(`.fc-timegrid-col[data-date="${dateStr}"]`).forEach(el => {
            el.classList.add('selected-date-col');
        });
    }

    function clearHighlight() {
        document.querySelectorAll('.selected-date-cell, .selected-date-col').forEach(el => {
            el.classList.remove('selected-date-cell','selected-date-col');
        });
    }
});
</script>

<style>
/* highlight tanggal di month view */
.selected-date-cell {
    background-color: #bfdbfe !important; 
    border: 2px solid #2563eb !important;
}

/* highlight kolom di week/day view */
.selected-date-col {
    background-color: #dbeafe !important;
    border-left: 2px solid #2563eb !important;
    border-right: 2px solid #2563eb !important;
}

/* toolbar mobile */
.fc .fc-toolbar.fc-header-toolbar {
    flex-wrap: wrap;
    gap: 0.25rem;
    justify-content: center;
}
.fc .fc-toolbar-title { font-size: 1rem; }
.fc .fc-button {
    padding: 2px 6px;
    font-size: 0.75rem;
    border-radius: 0.375rem;
}

.fc-daygrid-day-events {
    max-height: 4.5em;   /* tinggi maksimal area event */
    overflow: hidden;    /* sembunyikan overflow */
}
.fc-daygrid-more-link {
    display: block;
    margin-top: 2px;
    font-size: 0.75rem;
    color: #2563eb;
    cursor: pointer;
}
</style>


<style>
/* highlight tanggal yang dipilih */
.selected-date-cell {
    background-color: #bfdbfe !important; /* biru muda */
    border: 2px solid #2563eb !important; /* biru */
}

/* Perkecil tombol toolbar di mobile */
.fc .fc-toolbar.fc-header-toolbar {
    flex-wrap: wrap;
    gap: 0.25rem;
    justify-content: center;
}

.fc .fc-toolbar-title {
    font-size: 1rem;
}

.fc .fc-button {
    padding: 2px 6px;
    font-size: 0.75rem;
    border-radius: 0.375rem;
}
</style>
@endsection
