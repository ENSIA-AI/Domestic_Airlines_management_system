document.addEventListener('DOMContentLoaded', () => {
    const table = document.getElementById('bookingTbBody');
    const form = document.getElementById('BookingForm'); 
    const months = {
        'Jan': '01','Feb': '02','Mar': '03','Apr': '04',
        'May': '05','Jun': '06','Jul': '07','Aug': '08',
        'Sep': '09','Oct': '10','Nov': '11','Dec': '12'
    };

    form.addEventListener('submit', (e) => {
        e.preventDefault();

        const firstName = document.getElementById('fn').value.trim();
        const lastName = document.getElementById('ln').value.trim();
        const flight_num = document.getElementById('flight_n').value.trim();
        const dep_data = document.getElementById('date').value.trim();
        const seat = document.getElementById('seat').value.trim();
        const phone_num = document.getElementById('phone').value.trim();
        const status = document.getElementById('status').value.trim();

        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXTZ0123456789';
        let id = '';
        for (let i = 0; i < 6; i++) {
            const r = Math.floor(Math.random() * chars.length);
            id += chars[r];
        }

        const newr = document.createElement('tr');
        newr.innerHTML = `
        <td>${id}</td>
        <td>${firstName} ${lastName}</td>
        <td>${flight_num}</td>
        <td>${simplify(dep_data)}</td>
        <td>${seat}</td>
        <td>${phone_num}</td>
        <td><span class="status ${status}">${capitalize(status)}</span></td>
        <td>
            <div class="options">
            <button class="option"><i class="fa fa-eye"></i></button>
            <button class="option"><i class="fa fa-edit"></i></button>
            <button class="option"><i class="fa fa-trash"></i></button>
            </div>
        </td>`;

        table.appendChild(newr);

        const overlay = document.getElementById('overlay');
        if (overlay) {
            overlay.classList.remove('active');
            form.reset();
        }
    });

    function simplify(d) {
        const [year, month, day] = d.split('-');
        const monthNames = {
        '01':'Jan','02':'Feb','03':'Mar','04':'Apr','05':'May','06':'Jun',
        '07':'Jul','08':'Aug','09':'Sep','10':'Oct','11':'Nov','12':'Dec'
        };
        return `${String(Number(day))}\u00A0${monthNames[month]}\u00A0${year}`;
    }

    function capitalize(s) {
        if (!s) return '';
        return s.charAt(0).toUpperCase() + s.slice(1);
    }

    function view(r) {
        const overlay = document.getElementById('overlay');
        const title = document.getElementById('title');
        const submitBtn = document.getElementById('submit-btn');
        const cancelBtn = document.getElementById('cancel-btn');

        const infos = r.querySelectorAll('td');
        const id = infos[0].textContent.trim();
        const fullName = infos[1].textContent.trim().split(/\s+/);
        const flightnum = infos[2].textContent.trim();
        const date = infos[3].textContent.trim();
        const seat = infos[4].textContent.trim();
        const phone = infos[5].textContent.trim();
        const status = infos[6].querySelector('.status').textContent.trim().toLowerCase();

        title.textContent = `Booking Details ${id}`;

        document.getElementById('fn').value = fullName[0];
        document.getElementById('ln').value = fullName[1];
        document.getElementById('flight_n').value = flightnum;
        document.getElementById('seat').value = seat;
        document.getElementById('phone').value = phone;
        document.getElementById('status').value = status;

        const dateParts = date.split('\u00A0');
        const day = dateParts[0];
        const month = months[dateParts[1]];
        const year = dateParts[2];
        document.getElementById('date').value = `${year}-${month}-${day}`;
        
        const inputs = form.querySelectorAll('input, select');
        inputs.forEach(input => input.setAttribute('disabled', 'disabled'));

        submitBtn.style.display = 'none';
        cancelBtn.textContent = 'Close';
        overlay.classList.add('active');

        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                overlay.classList.remove('active');
                restore();
            }
        }, { once: true });

        function restore() {
        title.textContent = 'Add New Booking';
        inputs.forEach(input => input.removeAttribute('disabled'));
        submitBtn.style.display = 'block';
        cancelBtn.textContent = 'Cancel';
        form.reset();
        overlay.dataset.mode = '';
        }

        cancelBtn.addEventListener('click', () => {
            overlay.classList.remove('active');
            restore();
        }, { once: true });

    }

    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('fa-eye')) {
        const r = e.target.closest('tr');
        view(r);
        }
    });
});
