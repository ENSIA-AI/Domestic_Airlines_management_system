document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('bookingForm');
    const tableBody = document.getElementById('tablebody');


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
        // fetching user inputs
        const FID = document.getElementById('FID').value;
        const DEP = document.getElementById('DEP').value;
        const ARR = document.getElementById('DEST').value;
        const DATE = document.getElementById('DATE').value;
        const AC = document.getElementById('AC').value;
        const STATUS = document.getElementById('STATUS').value;
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYTZ0123456789';
        // random id generation??

        // transform STATUS to Title Case
        let statusString;
        STATUS == 'confirmed' ? statusString = 'Confirmed' : statusString = 'Cancelled';
        let dateParts = DATE.split('-');
        let fixedDate = `${dateParts[2]}\u00A0${numToMonth[dateParts[1]]}\u00A0${dateParts[0]}`;
        // creating a new flight row
        const newr = document.createElement('tr');
        newr.innerHTML = `
                        <td>${FID}</td>
                        <td>${DEP}</td>
                        <td>${ARR}</td>
                        <td>${fixedDate}</td>
                        <td>${AC}</td>
                        <td><div class="flight-status ${STATUS}">${statusString}</span></td>
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


    function view(r) {
        const overlay = document.getElementById('overlay');
        const title = document.getElementById('title');
        const submitBtn = document.getElementById('submit-btn');
        const cancelBtn = document.getElementById('cancel-btn');

        const infos = r.querySelectorAll('td');
        const fid = infos[0].textContent.trim();
        const departure = infos[1].textContent.trim();
        const destination = infos[2].textContent.trim();
        const date = infos[3].textContent.trim();
        const aircraft = infos[4].textContent.trim();
        const status = infos[5].querySelector('.flight-status').textContent.trim().toLowerCase();

        title.textContent = `Flight Details ${fid}`;

        document.getElementById('FID').value = fid;
        document.getElementById('DEP').value = departure;
        document.getElementById('DEST').value = destination;
        document.getElementById('AC').value = aircraft;
        document.getElementById('STATUS').value = status;

        const dateParts = date.split('\u00A0');
        const day = dateParts[0];
        const month = monthToNum[dateParts[1]];
        const year = dateParts[2];
        document.getElementById('DATE').value = `${year}-${month}-${day}`;

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
        const overlay = document.getElementById('overlay');
        const title = document.getElementById('title');
        const submitBtn = document.getElementById('submit-btn');
        const cancelBtn = document.getElementById('cancel-btn');


        submitBtn.addEventListener('click', ()=> {
        const newFlightId = document.getElementById('FID').value; 
        const newDep = document.getElementById('DEP').value ;
        const newDest = document.getElementById('DEST').value ;
        const newAc = document.getElementById('AC').value ;
        const newStatus = document.getElementById('STATUS').value; 
        const newDate = document.getElementById('DATE').value;
        })
        title.textContent = `Edit Flight ${fid}`;

        overlay.classList.add('active');

        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                overlay.classList.remove('active');
                restore();
            }
        }, { once: true });

        function restore() {
            title.textContent = 'Add New Flight';
            form.reset();
            overlay.dataset.mode = '';
        }

        cancelBtn.addEventListener('click', () => {
            overlay.classList.remove('active');
            restore();
        }, { once: true });
    }


    table.addEventListener('click', (e) => {
        const row = e.target.closest('tr');
        if (e.target.classList.contains('fa-eye')) view(row);
        else if (e.target.classList.contains('fa-edit')) edit(row);
    });


    // end of file
});