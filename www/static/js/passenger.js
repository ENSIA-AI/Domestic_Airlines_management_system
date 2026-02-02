function display(str){
    if(!str) return '';
    return str.replace(/_/g, ' ').toLowerCase().replace(/\b\w/g, l => l.toUpperCase());
}

function setTableToLoading() {
    document.getElementsByClassName("table-container")[0].innerHTML = `
        <table class="dams-table" id="search-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ID/Passport Number</th>
                    <th>Passenger Name</th>
                    <th>Phone</th>
                    <th>Date of Birth</th>
                    <th>Gender</th>
                    <th>Nationality</th>
                    <th>Options</th>
                </tr>
            </thead>
        </table>
        <div class="spinner-container">
            <div class="spinner"></div>
            Loading...
        </div>`;
}

function updateTable(){
    var xhr = new XMLHttpRequest();
    xhr.onload = function(){
        if(this.status == 200){
            document.getElementsByClassName("table-container")[0].innerHTML = this.responseText;
        }
    }
    xhr.open("GET", "backend/passengers.php", true);
    xhr.send();
}

function deletePassenger(id){
    if(!confirm(`Do you really want to delete passenger ${id}?`)){
        return;
    }
    setTableToLoading();
    const formData = new FormData();
    formData.append('type', 'DEL');
    formData.append('passenger_num', id);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', "backend/passengers.php", true);
    xhr.onload = function(){
        updateTable();
    }
    xhr.onerror = function(){
        alert('Error during deletion. Please try again.');
        updateTable();
    }
    xhr.send(formData);
}

function viewPassenger(passenger, displayDob, fullPhone, nationalityName){
    const fullname = (passenger.FIRST_NAME || '') + ' ' + (passenger.MIDDLE_NAME || '') + ' ' + (passenger.LAST_NAME || '');
    const idDisplay = passenger.ID_NUM.replace(/^(P|ID)/, '$1-');
    
    document.getElementById('view-passenger-id').textContent = passenger.PASSENGER_NUM || '';
    document.getElementById('view-id-type').textContent = display(passenger.ID_TYPE);
    document.getElementById('view-id-num').textContent = idDisplay;
    document.getElementById('view-full-name').textContent = fullname.trim();
    document.getElementById('view-phone').textContent = fullPhone || '';
    document.getElementById('view-email').textContent = passenger.EMAIL || '';
    document.getElementById('view-dob').textContent = displayDob || '';
    document.getElementById('view-gender').textContent = display(passenger.GENDER);
    document.getElementById('view-nationality').textContent = nationalityName || '';
    document.getElementById('view-modal').classList.add('active');
}

function closeview(){
    document.getElementById('view-modal').classList.remove('active');
}

function editPassenger(passenger) {
    document.getElementById('form-title').textContent = 'Edit Passenger';
    document.getElementById('submit-btn').textContent = 'Update Passenger';
    document.getElementById('form-type').value = 'UPDATE';
    document.getElementById('passenger_num').value = passenger.PASSENGER_NUM;
    document.getElementById('id_type').value = passenger.ID_TYPE;
    let idNumClean = passenger.ID_NUM.replace(/^(P|ID)/, '');
    document.getElementById('id_num').value = idNumClean;
    document.getElementById('first_name').value = passenger.FIRST_NAME;
    document.getElementById('middle_name').value = passenger.MIDDLE_NAME || '';
    document.getElementById('last_name').value = passenger.LAST_NAME;
    document.getElementById('email').value = passenger.EMAIL;
    document.getElementById('gender').value = passenger.GENDER;
    document.getElementById('nationality').value = passenger.NATIONALITY;
    document.getElementById('date_of_birth').value = passenger.DATE_OF_BIRTH;
    document.getElementById('phone_country').value = passenger.PHONE_COUNTRY_CODE;
    document.getElementById('phone_number').value = passenger.PHONE_NUMBER;
    document.getElementById('overlay').classList.add('active');
}

document.addEventListener('DOMContentLoaded', function(){
    updateTable();
    
    const addBtn = document.getElementById("add-passenger-btn");
    const cancelBtn = document.getElementById("cancel-btn");
    const submitBtn = document.getElementById('submit-btn');
    const closeBtn = document.getElementById('close-view-btn');
    const view = document.getElementById('view-modal');
    const form = document.getElementById('AddForm');       
    const overlay = document.getElementById('overlay');
    
    addBtn.addEventListener('click', ()=>{
        document.getElementById("form-title").textContent = "Add New Passenger";
        document.getElementById("submit-btn").textContent = "Add Passenger";
        document.getElementById("form-type").value = "ADD";
        document.getElementById("passenger_num").value = '';
        form.reset();
        document.getElementById('phone_country').value = 'DZ';
        document.getElementById('nationality').value = 'DZ';
        overlay.classList.add('active');
    });
    
    cancelBtn.addEventListener('click', ()=>{
        overlay.classList.remove('active');
        form.reset();
    });
    
    submitBtn.addEventListener('click', () => {
        if (!validateID()) {
            form.reportValidity();
            return;
        }
        if (!validatePHONE()) {
            form.reportValidity();
            return;
        }
        setTableToLoading();
        const formData = new FormData(form);
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "backend/passengers.php", true);

        xhr.onload = function () {
            if (this.status === 200) {
                if (this.responseText && this.responseText.trim().startsWith('Error')) {
                    alert(this.responseText);
                    updateTable();
                } else {
                    updateTable();
                    overlay.classList.remove('active');
                    form.reset();
                }
            } else {
                alert(this.responseText); 
                updateTable();
            }
        };
        xhr.onerror = function () {
            alert('Connection error. Please try again.');
            updateTable();
        };
        xhr.send(formData);
    });
    
    view.addEventListener('click', function(e) {
        if (e.target === this) {
            closeview();
        }
    });
    
    closeBtn.addEventListener('click', ()=> {
        closeview();
    });
});

// form validation
function validateID() {
    const idType = document.getElementById('id_type').value;
    const id = document.getElementById('id_num').value.trim();
    const nationality = document.getElementById('nationality').value;
    const idField = document.getElementById('id_num');
    idField.setCustomValidity('');
    if (!id) {
        idField.setCustomValidity('ID/Passport number is required');
        return false;
    }
    if (idType === 'PASSPORT') {
        if (!/^[A-Z0-9]{8,9}$/i.test(id)) {
            idField.setCustomValidity('Passport must be 8-9 characters (letters/numbers only)');
            return false;
        }
    } else if (idType === 'ID_CARD') {
        if (nationality === 'DZ') {
            if (!/^[0-9]{9}$/.test(id)) {
                idField.setCustomValidity('Algerian ID must be exactly 9 digits');
                return false;
            }
        } else {
            if (!/^[0-9]{6,15}$/.test(id)) {
                idField.setCustomValidity('ID must be 6-15 digits');
                return false;
            }
        }
    }
    return true;
}

function validatePHONE() {
    const nationality = document.getElementById('nationality').value;
    const phoneField = document.getElementById('phone_number');
    const rawPhone = phoneField.value.trim();
    const phone = rawPhone.replace(/\s+/g, '');

    phoneField.setCustomValidity('');

    if (!phone) {
        phoneField.setCustomValidity('Phone number is required');
        return false;
    }
    if (nationality === 'DZ') {
        const mobile = /^0[567][0-9]{8}$/;
        const fixe = /^02[0-9]{7}$/;
        if (!mobile.test(phone) && !fixe.test(phone)) {
            phoneField.setCustomValidity(
                'Algerian number must be 05/06/07 + 8 digits OR 02 + 7 digits'
            );
            return false;
        }
    }else {
        const tel = /^[0-9]{7,15}$/;
        if (!tel.test(phone)) {
            phoneField.setCustomValidity(
                'Phone number must be 7–15 digits (international format)'
            );
            return false;
        }
    }
    phoneField.setCustomValidity('');
    return true;
}

