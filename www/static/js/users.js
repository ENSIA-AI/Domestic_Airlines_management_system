document.addEventListener('DOMContentLoaded', () => {

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

    // adding a new aircraft
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        // fetching user inputs
        
        const FN= document.getElementById('fullname').value;
        const USR = document.getElementById('username').value;
        const EMAIL = document.getElementById('email').value;
        const STATUS = document.getElementById('status').value;
        const ROLE =document.getElementById('role').value;
        const DATE = document.getElementById('date-created').value;
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        const nums = '0123456789';
        // random id generation
        function getRandomInt(max) {
            // returns random number range (0, max-1)
            return Math.floor(Math.random() * max);
        }
        function generateRandomId() {
            let str = 'U';
            if(ROLE=='Admin'){
                str = str+'A';
            }
            else if(ROLE=='Manager'){
                str=str+M;
            }
            else if(ROLE=='Employee'){
                str= str + 'E';
            }
            else{
                str = str + 'V';
            }
            for (let j = 0 ; j < 4 ; ++j) {
                str = str + nums[getRandomInt(10)];
            }
            return str;
        }
        let UID = generateRandomId();
   
        // transform STATUS to Title Case
        let statusString;
        if(STATUS == 'Active'){ statusString = 'Active';} 
        else if(STATUS =='Inactive'){
            statusString = 'Inactive';}

        let dateParts = DATE.split('-');//split date into array 
        let fixedDate = `${dateParts[2]}\u00A0${numToMonth[dateParts[1]]}\u00A0${dateParts[0]}`;
        // creating a new flight row
        const newr = document.createElement('tr');
        newr.innerHTML = `
                        <td>${UID}</td>
                        <td>${FN}</td>
                        <td>${USR}</td>
                        <td>${EMAIL}</td>
                        <td>${ROLE}</td>
                        <td><span class="status ${statusString}">${statusString}</span></td>
                        <td>${fixedDate}</td>
                        <td>
                            <div class="options">
                            <button class="option"><i class="fa fa-eye"></i></button>
                            <button class="option"><i class="fa fa-edit"></i></button>
                            <button class="option"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>`;



        tableBody.prepend(newr);
        form.reset();
        overlay.classList.remove('active');
    })


    // inspect a flight row (fa-eye) event listner


    function view(r) {//select a row


        const infos = r.querySelectorAll('td');//pass the row as an array
        const uid = infos[0].textContent.trim();//select what insde <td>:textContent trim():remove extra spaces
        const fn = infos[1].textContent.trim();
        const usr = infos[2].textContent.trim();
        const email = infos[3].textContent.trim();
        const role = infos[4].textContent.trim();
        const status = infos[5].querySelector('.status').textContent;
        const date = infos[6].textContent.trim();
        title.textContent = `USER ${uid} Details`;

        document.getElementById('fullname').value = fn;
        document.getElementById('username').value = usr;
        document.getElementById('email').value = email;
        document.getElementById('role').value = role;
        document.getElementById('status').value = status;

        const dateParts = date.split('\u00A0');
        const day = dateParts[0];
        const month = monthToNum[dateParts[1]];
        const year = dateParts[2];
        document.getElementById('date-created').value = `${year}-${month}-${day}`;

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

    function edit(r) {

        const infos = r.querySelectorAll('td');//pass the row as an array
        const uid = infos[0].textContent.trim();//select what insde <td>:textContent trim():remove extra spaces
        const fn = infos[1].textContent.trim();
        const usr = infos[2].textContent.trim();
        const email = infos[3].textContent.trim();
        const role = infos[4].textContent.trim();
        const status = infos[5].querySelector('.status').textContent;
        const date = infos[6].textContent.trim();
        title.textContent = `USER ${uid} Details`;

        document.getElementById('fullname').value = fn;
        document.getElementById('username').value = usr;
        document.getElementById('email').value = email;
        document.getElementById('role').value = role;
        document.getElementById('status').value = status;

        const dateParts = date.split('\u00A0');
        const day = dateParts[0];
        const month = monthToNum[dateParts[1]];
        const year = dateParts[2];
        document.getElementById('date-created').value = `${year}-${month}-${day}`;

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

    function remove(r) {
        const confirmed = confirm('Are You Sure About Doing This Action?');
        if (confirmed) {
            if(r) {
                r.remove();
            }
        }
    }


    document.addEventListener('click', (e) => {
        const row = e.target.closest('tr');
        if (e.target.classList.contains('fa-eye')) view(row);
        else if (e.target.classList.contains('fa-edit')) edit(row);
        else if (e.target.classList.contains('fa-trash')) remove(row);

    });

  


    // end of file
});