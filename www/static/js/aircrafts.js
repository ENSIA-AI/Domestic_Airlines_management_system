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
        
        const MOD= document.getElementById('model').value;
        const REG = document.getElementById('registration').value;
        const DATE = document.getElementById('service-date').value;
        const CAP = document.getElementById('capacity').value;
        const STATUS = document.getElementById('status').value;
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        const nums = '0123456789';
        // random id generation
        function getRandomInt(max) {
            // returns random number range (0, max-1)
            return Math.floor(Math.random() * max);
        }
        function generateRandomId() {
            let str = '';
            for (let i = 0 ; i < 2 ; ++i) {
                str = str + chars[getRandomInt(26)]
            }
            for (let j = 0 ; j < 4 ; ++j) {
                str = str + nums[getRandomInt(10)];
            }
            return str;
        }
        let AID = generateRandomId();
   
        // transform STATUS to Title Case
        let statusString;
        if(STATUS == 'Active'){ statusString = 'Active';} 
        else if(STATUS =='Maintenance'){
            statusString = 'Maintenance';}
        else if(STATUS=='Retired'){
            statusString='Retired';
        }
        else if(STATUS == 'Out of Service'){
            statusString='Out of Service';
        }
        
        let dateParts = DATE.split('-');//split date into array 
        let fixedDate = `${dateParts[2]}\u00A0${numToMonth[dateParts[1]]}\u00A0${dateParts[0]}`;
        // creating a new flight row
        const newr = document.createElement('tr');
        newr.innerHTML = `
                        <td>${AID}</td>
                        <td>${MOD}</td>
                        <td>${REG}</td>
                        <td>${fixedDate}</td>
                        <td>${CAP}</td>
                        <td><span class="status ${statusString}">${statusString}</span></td>
                        <td>
                            <div class="options">
                            <button class="option"><i class="fa fa-eye"></i></button>
                            <button class="option"><i class="fa fa-edit"></i></button>
                            <button class="option"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>`;



        tableBody.prepend(newr);
        form.reset();
        overlay.classList.remove('actirve');
    })


    // inspect a flight row (fa-eye) event listner


    function view(r) {//select a row


        const infos = r.querySelectorAll('td');//pass the row as an array
        const aid = infos[0].textContent.trim();//select what insde <td>:textContent trim():remove extra spaces
        const mod = infos[1].textContent.trim();
        const reg = infos[2].textContent.trim();
        const date = infos[3].textContent.trim();
        const cap = infos[4].textContent.trim();
        const status = infos[5].querySelector('.status').textContent;

        title.textContent = `Aircraft Details ${aid}`;

        document.getElementById('model').value = mod;
        document.getElementById('registration').value = reg;
        document.getElementById('capacity').value = cap;
        document.getElementById('status').value = status;

        const dateParts = date.split('\u00A0');
        const day = dateParts[0];
        const month = monthToNum[dateParts[1]];
        const year = dateParts[2];
        document.getElementById('service-date').value = `${year}-${month}-${day}`;

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
        const aid = infos[0].textContent.trim();//select what insde <td>:textContent trim():remove extra spaces
        const mod = infos[1].textContent.trim();
        const reg = infos[2].textContent.trim();
        const date = infos[3].textContent.trim();
        const cap = infos[4].textContent.trim();
        const status = infos[5].querySelector('.status').textContent;

        title.textContent = `Aircraft Details ${aid}`;

        document.getElementById('model').value = mod;
        document.getElementById('registration').value = reg;
        document.getElementById('capacity').value = cap;
        document.getElementById('status').value = status;

        const dateParts = date.split('\u00A0');
        const day = dateParts[0];
        const month = monthToNum[dateParts[1]];
        const year = dateParts[2];
        document.getElementById('service-date').value = `${year}-${month}-${day}`;


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