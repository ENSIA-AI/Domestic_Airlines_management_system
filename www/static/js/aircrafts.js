document.addEventListener('DOMContentLoaded', () => {
    let isEdit = false;
    let editRow = null;

    const table = document.getElementById('tablebody');
    const form = document.getElementById('AddForm');
    const overlay = document.getElementById('overlay');
    const title = document.getElementById('title');
    const submitBtn = document.getElementById('submit-btn');
    const cancelBtn = document.getElementById('cancel-btn');

    const numToMonth = {
        '01': 'Jan', '02': 'Feb', '03': 'Mar', '04': 'Apr', '05': 'May', '06': 'Jun',
        '07': 'Jul', '08': 'Aug', '09': 'Sep', '10': 'Oct', '11': 'Nov', '12': 'Dec'
    };

    const monthToNum = {
        'Jan': '01', 'Feb': '02', 'Mar': '03', 'Apr': '04', 'May': '05', 'Jun': '06',
        'Jul': '07', 'Aug': '08', 'Sep': '09', 'Oct': '10', 'Nov': '11', 'Dec': '12'
    };

    function simplify(date) {
        const [year, month, day] = date.split('-');
        return `${String(Number(day))}\u00A0${numToMonth[month]}\u00A0${year}`;
    }

    // restore the form to its initial state
    function restore() {
        const inputs = form.querySelectorAll('input, select');
        title.textContent = 'Add New Aircraft';
        inputs.forEach(input => input.removeAttribute('disabled'));
        submitBtn.style.display = 'block';
        submitBtn.textContent = 'Add Aircraft';
        cancelBtn.textContent = 'Cancel';
        form.reset();
        overlay.classList.remove('active');
        isEdit = false;
        editRow = null;
    }

    function getInfos(r) {
        const infos = r.querySelectorAll('td');
        const model = infos[1].textContent.trim();
        const registration = infos[2].textContent.trim();
        const serviceDate = infos[3].textContent.trim();
        const capacity = infos[4].textContent.trim();
        const status = infos[5].querySelector('.status').textContent.trim();

        document.getElementById('model').value = model;
        document.getElementById('registration').value = registration;
        document.getElementById('capacity').value = capacity;
        document.getElementById('status').value = status;

        const dateParts = serviceDate.split('\u00A0');
        const day = dateParts[0].padStart(2, '0');
        const month = monthToNum[dateParts[1]];
        const year = dateParts[2];
        document.getElementById('service-date').value = `${year}-${month}-${day}`;
    }

    function view(r) {
        getInfos(r);
        const inputs = form.querySelectorAll('input, select');
        inputs.forEach(input => input.setAttribute('disabled', 'disabled'));

        title.textContent = `Aircraft Details`;
        submitBtn.style.display = 'none';
        cancelBtn.textContent = 'Close';
        overlay.classList.add('active');
    }

    function edit(r) {
        getInfos(r);
        const inputs = form.querySelectorAll('input, select');
        inputs.forEach(input => input.removeAttribute('disabled'));

        title.textContent = 'Edit Aircraft';
        submitBtn.style.display = 'block';
        submitBtn.textContent = 'Save Changes';

        cancelBtn.textContent = 'Cancel';
        overlay.classList.add('active');

        isEdit = true;
        editRow = r;
    }

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        console.log('Form submitted!');

        const model = document.getElementById('model').value.trim();
        const registration = document.getElementById('registration').value.trim();
        const serviceDate = document.getElementById('service-date').value.trim();
        const capacity = document.getElementById('capacity').value.trim();
        const status = document.getElementById('status').value.trim();

        console.log('Form values:', { model, registration, serviceDate, capacity, status });

        // the edit part
        if (isEdit && editRow) {
            const infos = editRow.querySelectorAll('td');
            infos[1].textContent = model;
            infos[2].textContent = registration;
            infos[3].textContent = simplify(serviceDate);
            infos[4].textContent = capacity;
            infos[5].innerHTML = `<span class="status ${status}">${status}</span>`;
            restore();
            return;
        }

        // the add new part - generate sequential ID
        console.log('Adding new aircraft...');
        const currentCount = table.children.length + 1;
        const id = 'AC' + String(currentCount).padStart(3, '0');
        console.log('Generated ID:', id);

        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>${id}</td>
            <td>${model}</td>
            <td>${registration}</td>
            <td>${simplify(serviceDate)}</td>
            <td>${capacity}</td>
            <td><span class="status ${status}">${status}</span></td>
            <td>
                <div class="options">
                    <button class="option"><i class="fa fa-eye"></i></button>
                    <button class="option"><i class="fa fa-edit"></i></button>
                    <button class="option"><i class="fa fa-trash"></i></button>
                </div>
            </td>`;

        table.prepend(newRow);
        console.log('New row added to table!');
        restore();
    });

    table.addEventListener('click', (e) => {
        const row = e.target.closest('tr');
        if (e.target.classList.contains('fa-eye')) view(row);
        else if (e.target.classList.contains('fa-edit')) edit(row);
        else if (e.target.classList.contains("fa-trash")) {
            const confirmed = confirm("Are you sure you want to delete this aircraft?");
            if (!confirmed) return;
            const row = e.target.closest("tr");
            if (row) row.remove();
        }
    });
});