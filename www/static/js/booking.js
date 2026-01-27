document.addEventListener('DOMContentLoaded', function() {
    updateTable();
    const addBtn = document.getElementById('add-booking-btn');
    const cancelBtn = document.getElementById('cancel-btn');
    const submitBtn = document.getElementById('submit-btn');
    const closeBtn = document.getElementById('close-view-btn');
    const view = document.getElementById('view-modal');
    const form = document.getElementById('AddForm');       
    const overlay = document.getElementById('overlay');     

    addBtn.addEventListener('click', () => {
        document.getElementById('form-title').textContent = 'Add New Booking';
        document.getElementById('submit-btn').textContent = 'Add Booking';
        document.getElementById('form-type').value = 'ADD';
        document.getElementById('booking_id').value = '';
        form.reset();
        overlay.classList.add('active');
    });

    cancelBtn.addEventListener('click', () => {
        overlay.classList.remove('active');
        form.reset();
    });

    submitBtn.addEventListener('click', () => {
        setTableToLoading();
        const formData = new FormData(form);

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "backend/bookings.php", true);

        xhr.onload = function () {
            if (this.status === 200) { 
                updateTable();
                overlay.classList.remove('active');
                form.reset();
            } else {
                alert(this.responseText); 
                updateTable();
            }
        };
        
        xhr.onerror = function () {
            alert('Erreur de connexion. Veuillez réessayer.');
            updateTable();
        };
        
        xhr.send(formData);
    });

    view.addEventListener('click', function(e) {
        if (e.target === this) {
            closeview();
        }
    });

    closeBtn.addEventListener('click', function (e) {
        closeview();
    });
});

function display(str) {
    if (!str) return '';
    return str.replace(/_/g, ' ').toLowerCase().replace(/\b\w/g, l => l.toUpperCase());
}

function setTableToLoading() {
    document.getElementsByClassName("table-container")[0].innerHTML = `
        <table class="dams-table" id="search-table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Passenger</th>
                    <th>Flight Number</th>
                    <th>Date</th>
                    <th>Class</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Options</th>
                </tr>
            </thead>
        </table>
        <div class="spinner-container">
            <div class="spinner"></div>
            Loading...
        </div>`;
}

function updateTable() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onload = function() {
        if (this.status == 200) {
            document.getElementsByClassName("table-container")[0].innerHTML = this.responseText;
        }
    }
    xmlhttp.open("GET", "backend/bookings.php", true);
    xmlhttp.send();
}

function deleteBooking(id) {
    if (!confirm(`Do you really want to delete booking ${id}?`)) {
        return;
    }
    setTableToLoading();
    const formData = new FormData();
    formData.append('type', 'DEL');
    formData.append('booking_id', id);
    
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "backend/bookings.php", true);
    xhr.onload = function () {
        updateTable();
    };
    xhr.onerror = function () {
        alert('Erreur lors de la suppression. Veuillez réessayer.');
        updateTable();
    };
    xhr.send(formData);
}

function viewBooking(booking, displayDatetime) {
    document.getElementById('view-booking-id').textContent = booking.BOOKING_ID || '';
    document.getElementById('view-passenger').textContent = (booking.FIRST_NAME || '') + ' ' + (booking.LAST_NAME || '');
    document.getElementById('view-flight').textContent = booking.FLIGHT_NUMBER || '';
    document.getElementById('view-departure').textContent = displayDatetime || '';
    document.getElementById('view-class').textContent = display(booking.CLASS);
    document.getElementById('view-phone').textContent = booking.PHONE || '';
    document.getElementById('view-status').textContent = display(booking.STATUS);
    document.getElementById('view-modal').classList.add('active');
}

function closeview() {
    document.getElementById('view-modal').classList.remove('active');
}

function editBooking(booking) {
    document.getElementById('form-title').textContent = 'Edit Booking';
    document.getElementById('submit-btn').textContent = 'Update Booking';
    document.getElementById('form-type').value = 'UPDATE';
    document.getElementById('booking_id').value = booking.BOOKING_ID;
    document.getElementById('passenger').value = booking.PASSENGER_NUM;

    const flight = booking.FLIGHT_NUMBER + '|' + booking.DEPARTURE_TIME;
    document.getElementById('flight').value = flight;
    document.getElementById('class').value = booking.CLASS;
    document.getElementById('status').value = booking.STATUS;
    document.getElementById('overlay').classList.add('active');
}