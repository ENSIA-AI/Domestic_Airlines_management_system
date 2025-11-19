document.addEventListener('DOMContentLoaded', () => {
    let isEdit = false;
    let editRow = null;

    const table = document.getElementById('tablebody');
    const form = document.getElementById('PassengerForm');
    const overlay = document.getElementById('overlay');
    const title = document.getElementById('title');
    const submitBtn = document.getElementById('submit-btn');
    const cancelBtn = document.getElementById('cancel-btn');

    function restore() {
        const inputs = form.querySelectorAll('input, select');
        title.textContent = 'Add New Passenger';
        inputs.forEach(input => input.removeAttribute('disabled'));
        submitBtn.style.display = 'block';
        submitBtn.textContent = 'Add Passenger';
        cancelBtn.textContent = 'Cancel';
        form.reset();
        overlay.classList.remove('active');
        isEdit = false;
        editRow = null;
    }

    function getInfos(r) {
        const infos = r.querySelectorAll('td');
        const nationalId = infos[0].textContent.trim();
        const fullName = infos[1].textContent.trim().split(/\s+/);
        const phone = infos[2].textContent.trim();
        const dob = infos[3].textContent.trim(); 
        const gender = infos[4].textContent.trim();
        const nationality = infos[5].textContent.trim();

        document.getElementById('fn').value = fullName[0];
        document.getElementById('ln').value = fullName[1];
        document.getElementById('national_id').value = nationalId;
        document.getElementById('phone').value = phone;
        document.getElementById('dob').value = dob;
        document.getElementById('gender').value = gender;
        document.getElementById('nationality').value = nationality;
    }

    function view(r) {
        getInfos(r);
        const inputs = form.querySelectorAll('input, select');
        inputs.forEach(input => input.setAttribute('disabled', 'disabled'));

        title.textContent = 'Passenger Details';
        submitBtn.style.display = 'none';
        cancelBtn.textContent = 'Close';
        overlay.classList.add('active');
    }

    function edit(r) {
        getInfos(r);
        const inputs = form.querySelectorAll('input, select');
        inputs.forEach(input => input.removeAttribute('disabled'));

        title.textContent = 'Edit Passenger';
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
        const nationalId = document.getElementById('national_id').value.trim();
        const phone_num = document.getElementById('phone').value.trim();
        const dob = document.getElementById('dob').value.trim();
        const gender = document.getElementById('gender').value.trim();
        const nationality = document.getElementById('nationality').value.trim();

        if (isEdit && editRow) {
            const infos = editRow.querySelectorAll('td');

            infos[0].textContent = nationalId;
            infos[1].textContent = `${firstName} ${lastName}`;
            infos[2].textContent = phone_num;
            infos[3].textContent = dob; 
            infos[4].textContent = gender;
            infos[5].textContent = nationality;

            restore();
            return;
        }

        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>${nationalId}</td>
            <td>${firstName} ${lastName}</td>
            <td>${phone_num}</td>
            <td>${dob}</td>
            <td>${gender}</td>
            <td>${nationality}</td>
            <td>
                <div class="options">
                    <button class="option"><i class="fa fa-eye"></i></button>
                    <button class="option"><i class="fa fa-edit"></i></button>
                    <button class="option"><i class="fa fa-trash"></i></button>
                </div>
            </td>
        `;

        table.prepend(newRow);
        restore();
    });

    table.addEventListener('click', (e) => {
        const row = e.target.closest('tr');
        if (e.target.classList.contains('fa-eye')) view(row);
        else if (e.target.classList.contains('fa-edit')) edit(row);
        else if (e.target.classList.contains("fa-trash")) {
            const confirmed = confirm("Are you sure you want to delete this passenger?");
            if (!confirmed) return;
            const row = e.target.closest("tr");
            if (row) row.remove();
        }
    });
});
