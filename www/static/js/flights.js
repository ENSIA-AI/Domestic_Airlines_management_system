document.addEventListener('DOMContentLoaded', () => {
    loadrows();
    const form = document.getElementById('AddForm');
    const tableBody = document.getElementById('tablebody');
    const overlay = document.getElementById('overlay');
    const title = document.getElementById('title');
    const submitBtn = document.getElementById('submit-btn');
    const cancelBtn = document.getElementById('cancel-btn');
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

    // adding a new flight
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        console.log('form called');
        // fetching user inputs
        
        const DEP = document.getElementById('DEP').value;
        const ARR = document.getElementById('DEST').value;
        const DATE = document.getElementById('DATE').value;
        const AC = document.getElementById('AC').value;
        const STATUS = document.getElementById('STATUS').value;
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        const nums = '0123456789';
        // random id generation
        function getRandomInt(max) {
            // returns random number range (0, max-1)
            return Math.floor(Math.random() * max);
        }
        function generateRandomId() {
            let str = '';
            if (getRandomInt(2) == 1) {
                str = 'AH';
            } else {
                str = 'SF';
            }
            for (let j = 0 ; j < 3 ; ++j) {
                str = str + nums[getRandomInt(10)];
            }
            return str;
        }
        let FID = generateRandomId();
        let statusString = STATUS.toLowerCase();
        statusString = statusString.charAt(0).toUpperCase() + statusString.slice(1); 
        console.log(statusString);
        let formattedDate = DATE.replace('T', ' ') + ":00";
        // creating a new flight row


        
        let mysqlDateTime = DATE.replace('T', ' ') + ":00";
        // insertion : - ajax http request
        let backendParams = `request_type=insert&`+
        `flight_number=${FID}&`+
        `departure_time=${encodeURIComponent(mysqlDateTime)}&`+
        `dep_airport=${DEP}&`+
        `arr_airport=${ARR}&`+
        `status=${STATUS}&`+
        `aircraft=${AC}`;
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '../../admin/backend/flights.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            console.log('http POST REQUEST');
            if(this.status == 200) {
                // inserting the row to the front end
                console.log(`new row inserted ${FID}`);
                loadrows();
                 
            }
        }

        xhr.send(backendParams);
        form.reset();
        overlay.classList.remove('active');
    })


    // inspect a flight row (fa-eye) event listner
    function view(r) {


        const infos = r.querySelectorAll('td');
        const fid = infos[0].textContent.trim();
        const departure = infos[1].textContent.trim();
        const destination = infos[2].textContent.trim();
        const date = infos[3].textContent.trim();
        const aircraft = infos[4].textContent.trim();
        const status = infos[5].querySelector('.status').textContent.trim().toLowerCase();

        title.textContent = `Flight Details ${fid}`;

        document.getElementById('DEP').value = departure;
        document.getElementById('DEST').value = destination;
        document.getElementById('AC').value = aircraft;
        document.getElementById('STATUS').value = status;

        const yyyymmdd = date.split(' ')[0];
        
        
        document.getElementById('DATE').value = yyyymmdd;

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
                tableBody.insertAdjacentHTML('afterbegin', this.responseText);
                 
            }
        }

        xhr.send();

    }

    // editing a flight row (fa-edit) event listner
    // ajax request_type=edit
    function edit(r) {
        const infos = r.querySelectorAll('td');
        const fid = infos[0].textContent.trim();
        const departure = infos[1].textContent.trim();
        const destination = infos[2].textContent.trim();
        const date = infos[3].textContent.trim();
        const aircraft = infos[4].textContent.trim();
        const status = infos[5].querySelector('.status').textContent.trim().toLowerCase();

        title.textContent = `Flight Details ${fid}`;

        document.getElementById('DEP').value = departure;
        document.getElementById('DEST').value = destination;
        document.getElementById('AC').value = aircraft;
        document.getElementById('STATUS').value = status;

         const yyyymmdd = date.split(' ')[0];
        document.getElementById('DATE').value = yyyymmdd;


        const inputs = form.querySelectorAll('input, select');
        inputs.forEach(input => input.removeAttribute('disabled'));
        title.textContent = 'Edit Flight';
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
            if(r) {
                r.remove();
            }
        }
    }

    // listning to clicks in the webpage (3 cases : view edit or delete)
    document.addEventListener('click', (e) => {
        const row = e.target.closest('tr');
        if (e.target.classList.contains('fa-eye')) view(row);
        else if (e.target.classList.contains('fa-edit')) edit(row);
        else if (e.target.classList.contains('fa-trash')) remove(row);

    });

  


    // end of file
});