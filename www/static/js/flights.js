document.addEventListener('DOMContentLoaded', () => {
    loadrows();
    const form = document.getElementById('AddForm');
    const tableBody = document.getElementById('tablebody');
    const overlay = document.getElementById('overlay');
    const title = document.getElementById('form-title');
    const submitBtn = document.getElementById('submit-btn');
    const cancelBtn = document.getElementById('cancel-btn');
    const addBtn = document.getElementById('add-flight-btn');
    const tableContainer = document.querySelector('.table-container');
    let isEdit = false;
    let editRow = null;
   
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

    function setTableToLoading() {
        tableContainer.innerHTML = `
                    <table class="dams-table" id="search-table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Departure</th>
                                <th>Destination</th>
                                <th>Date</th>
                                <th>Aircraft</th>
                                <th>DGate</th>
                                <th>AGate</th>
                                <th>Status</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody  id="tablebody">

                            

                        </tbody>
                    </table>
                    <div class="spinner-container">
                        <div class="spinner"></div>
                        Loading...
                    </div>`;
    }

    // addBtn.addEventListener('click', () => {
    //     document.getElementById('form-title').textContent = 'Add New Flight';
    //     document.getElementById('submit-btn').textContent = 'Add Flight';
    //     form.reset();
    //     overlay.classList.add('active');
    // });

    // adding a new flight
form.addEventListener('submit', (e) => {
    e.preventDefault();
    setTableToLoading();

            const FID = document.getElementById('FLIGHT_NUM').value;

            const DEP = document.getElementById('DEP').value;

            const ARR = document.getElementById('DEST').value;

            const DATE = document.getElementById('DATE').value;

            const AC = document.getElementById('AC').value;

            const STATUS = document.getElementById('STATUS').value;

            const DGATE = document.getElementById('DEP_GATE').value;

            const AGATE = document.getElementById('ARR_GATE').value;

    let request_type = isEdit ? "edit" : "insert";
    
    let backendParams = `request_type=${request_type}&` +
        `flight_number=${encodeURIComponent(FID)}&` +
        `departure_time=${encodeURIComponent(DATE)}&` +
        `dep_airport=${encodeURIComponent(DEP)}&` +
        `arr_airport=${encodeURIComponent(ARR)}&` +
        `status=${encodeURIComponent(STATUS)}&` +
        `aircraft=${encodeURIComponent(AC)}&` +
        `dgate=${encodeURIComponent(DGATE)}&` + 
        `agate=${encodeURIComponent(AGATE)}`;   

    if (isEdit) {
        const OLD_FLIGHT_NUMBER = editRow.querySelectorAll('td')[0].textContent.trim();
        const OLD_DEPARTURE_TIME = editRow.querySelectorAll('td')[3].textContent.trim();
        backendParams += `&old_flight_number=${encodeURIComponent(OLD_FLIGHT_NUMBER)}&old_departure_time=${encodeURIComponent(OLD_DEPARTURE_TIME)}`;
    }

    let xhr = new XMLHttpRequest();
    xhr.open('POST', '../../admin/backend/flights.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (this.status == 200) {
            console.log("Success:", this.responseText);
            loadrows(); 
            form.reset();
            overlay.classList.remove('active');
            isEdit = false;
        }
    };
    xhr.send(backendParams);
});


    // inspect a flight row (fa-eye) event listner
    function view(r) {

        const infos = r.querySelectorAll('td');
        const fid = infos[0].textContent.trim();
        const departure = infos[1].textContent.trim();
        const destination = infos[2].textContent.trim();
        const date = infos[3].textContent.trim();
        const aircraft = infos[4].textContent.trim();
        const status = infos[7].querySelector('.status').textContent.trim().toLowerCase();
        const DGATE = infos[5].textContent.trim();
        const AGATE = infos[6].textContent.trim();
        

        title.textContent = `Flight Details ${fid}`;
        document.getElementById('FLIGHT_NUM').value = fid;
        document.getElementById('DEP').value = departure;
        document.getElementById('DEST').value = destination;
        document.getElementById('AC').value = aircraft;
        document.getElementById('STATUS').value = status;
        document.getElementById('DATE').value = date;
        document.getElementById('DEP_GATE').value = DGATE;
        document.getElementById('ARR_GATE').value = AGATE;
        


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
            title.textContent = 'Add New Flight';
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

    function loadrows() {
        let xhr = new XMLHttpRequest();
        xhr.open('GET', '../../admin/backend/flights.php', true);
        xhr.onload = function() {
            console.log('http GET request');
            if(this.status == 200) {
                // inserting the row to the front end
                tableContainer.innerHTML =
                this.responseText;
                 
            }
        }

        xhr.send();

    }

    // editing a flight row (fa-edit) event listner
    // ajax request_type=edit
    function edit(r) {
        const infos = r.querySelectorAll('td');
        const FID = infos[0].textContent.trim();
        const DEP = infos[1].textContent.trim();
        const ARR = infos[2].textContent.trim();
        const DATE = infos[3].textContent.trim();
        const AC = infos[4].textContent.trim();
        const DGATE = infos[5].textContent.trim();
        const AGATE = infos[6].textContent.trim();
        const STATUS = infos[7].querySelector('.status').textContent.trim().toLowerCase();

        console.log(FID);
        document.getElementById('FLIGHT_NUM').value = FID;
        document.getElementById('DEP').value = DEP;
        document.getElementById('DEST').value = ARR;
        document.getElementById('AC').value = AC;
        document.getElementById('STATUS').value = STATUS;
        document.getElementById('DATE').value = DATE;
        document.getElementById('DEP_GATE').value = DGATE;
        document.getElementById('ARR_GATE').value = AGATE;
 

        const inputs = form.querySelectorAll('input, select');
        inputs.forEach(input => input.removeAttribute('disabled'));
        title.textContent = `Edit Flight ${FID}`;
        submitBtn.style.display = 'block';
        submitBtn.textContent = 'Save Changes';
        cancelBtn.textContent = 'Cancel';
        overlay.classList.add('active');
        isEdit = true;
        editRow = r;
    }
    // removing a flight row (fa-remove) event listner
    // ajax request_type=delete
    function remove(r) {
        const confirmed = confirm('Are You Sure About Doing This Action?');
        if (confirmed) {
            let FID = r.querySelectorAll('td')[0].textContent.trim(); 
            let TIME = r.querySelectorAll('td')[3].textContent.trim();
            setTableToLoading() 
            let backendParams = `request_type=delete&`+
            `flight_number=${FID}&` + `departure_time=${TIME}`;
            let xhr = new XMLHttpRequest();
            xhr.open('POST', '../../admin/backend/flights.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                console.log('http POST REQUEST');
                if(this.status == 200) {
                    // deleting the row
                    console.log(`row ${FID} ${TIME} is getting deleted`);
                    console.log(this.responseText);
                    loadrows();
                    
                }
            }

            xhr.send(backendParams);
            form.reset();
        } else {
            loadrows();
        }
    }

    // listning to clicks in the webpage (3 cases : view edit or delete)
    document.addEventListener('click', (e) => {
        const row = e.target.closest('tr');
        if (e.target.classList.contains('fa-eye')) view(row);
        else if (e.target.classList.contains('fa-edit')) edit(row);
        else if (e.target.classList.contains('fa-trash')) remove(row);

    });

//     addBtn.addEventListener('click', () => {
//     isEdit = false; 
//     editRow = null; 
//     document.getElementById('form-title').textContent = 'Add New Flight';

// });

    addBtn.addEventListener('click', () => {
        isEdit = false; 
        editRow = null; 
        title.textContent = 'Add New Flight';
        submitBtn.textContent = 'Add Flight';
        form.reset();
        overlay.classList.add('active');
    });




  
});