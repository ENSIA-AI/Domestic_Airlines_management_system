document.addEventListener('DOMContentLoaded', () => {
    let isEdit = false;
    let editRow = null;

    const table = document.getElementById('tablebody');
    const form = document.getElementById('BookingForm');
    const overlay = document.getElementById('overlay');
    const title = document.getElementById('title');
    const submitBtn = document.getElementById('submit-btn');
    const cancelBtn = document.getElementById('cancel-btn');

    const numToMonth = {
        '01':'Jan','02':'Feb','03':'Mar','04':'Apr','05':'May','06':'Jun',
        '07':'Jul','08':'Aug','09':'Sep','10':'Oct','11':'Nov','12':'Dec'
    };

    const monthToNum = {
        'Jan':'01','Feb':'02','Mar':'03','Apr':'04','May':'05','Jun':'06',
        'Jul':'07','Aug':'08','Sep':'09','Oct':'10','Nov':'11','Dec':'12'
    };

    function simplify(date) {
        const [year, month, day] = date.split('-');
        return `${String(Number(day))}\u00A0${numToMonth[month]}\u00A0${year}`;
    }

    // restore the form to it's initial state
    function restore() {
        const inputs = form.querySelectorAll('input, select');
        title.textContent = 'Add New Booking';
        inputs.forEach(input => input.removeAttribute('disabled'));
        submitBtn.style.display = 'block';
        submitBtn.textContent = 'Add Booking';
        cancelBtn.textContent = 'Cancel';
        form.reset();
        overlay.classList.remove('active');
        isEdit = false;
        editRow = null;
    }

    function getInfos(r) {
        const infos = r.querySelectorAll('td');
        const fullName = infos[1].textContent.trim().split(/\s+/);
        const flightnum = infos[2].textContent.trim();
        const date = infos[3].textContent.trim();
        const classType = infos[4].textContent.trim();
        const phone = infos[5].textContent.trim();
        const status = infos[6].querySelector('.status').textContent.trim();

        document.getElementById('fn').value = fullName[0];
        document.getElementById('ln').value = fullName[1];
        document.getElementById('flight_n').value = flightnum;
        document.getElementById('class').value = classType;
        document.getElementById('phone').value = phone;
        document.getElementById('status').value = status;

        const dateParts = date.split('\u00A0');
        const day = dateParts[0];
        const month = monthToNum[dateParts[1]];
        const year = dateParts[2];
        document.getElementById('date').value = `${year}-${month}-${day}`;
    }

    function view(r) {
        getInfos(r);
        const inputs = form.querySelectorAll('input, select');
        inputs.forEach(input => input.setAttribute('disabled', 'disabled'));

        title.textContent = `Booking Details`;
        submitBtn.style.display = 'none';
        cancelBtn.textContent = 'Close';
        overlay.classList.add('active');
    }

    function edit(r) {
        getInfos(r);
        const inputs = form.querySelectorAll('input, select');
        inputs.forEach(input => input.removeAttribute('disabled'));

        title.textContent = 'Edit Booking';
        submitBtn.style.display = 'block';
        submitBtn.textContent = 'Save Changes';

        cancelBtn.textContent = 'Cancel';
        overlay.classList.add('active');

        isEdit = true;
        editRow = r;
    }

    form.addEventListener('submit', (e) => {
        e.preventDefault();

        const firstName = document.getElementById('fn').value.trim();
        const lastName = document.getElementById('ln').value.trim();
        const flight_num = document.getElementById('flight_n').value.trim();
        const dep_data = document.getElementById('date').value.trim();
        const classType = document.getElementById('class').value.trim();
        const phone_num = document.getElementById('phone').value.trim();
        const status = document.getElementById('status').value.trim();

        // the edit part
        if (isEdit && editRow) {
            const infos = editRow.querySelectorAll('td');
            infos[1].textContent = `${firstName} ${lastName}`;
            infos[2].textContent = flight_num;
            infos[3].textContent = simplify(dep_data);
            infos[4].textContent = classType;
            infos[5].textContent = phone_num;
            infos[6].innerHTML = `<span class="status ${status}">${status}</span>`;
            restore();
            return;
        }

        // the add new part
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; 
        let id = ''; 
        for (let i = 0; i < 6; i++) { 
            const r = Math.floor(Math.random() * chars.length);
            id += chars[r]; 
        }

        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>${id}</td>
            <td>${firstName} ${lastName}</td>
            <td>${flight_num}</td>
            <td>${simplify(dep_data)}</td>
            <td>${classType}</td>
            <td>${phone_num}</td>
            <td><span class="status ${status}">${status}</span></td>
            <td>
                <div class="options">
                    <button class="option"><i class="fa fa-eye"></i></button>
                    <button class="option"><i class="fa fa-edit"></i></button>
                    <button class="option"><i class="fa fa-trash"></i></button>
                </div>
            </td>`;

        table.prepend(newRow);
        restore();
    });

    table.addEventListener('click', (e) => {
        const row = e.target.closest('tr');
        if (e.target.classList.contains('fa-eye')) view(row);
        else if (e.target.classList.contains('fa-edit')) edit(row);
    });
});
