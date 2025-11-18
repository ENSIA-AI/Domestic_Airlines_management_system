document.addEventListener('DOMContentLoaded', () => {
    const table = document.getElementById('dams-table-body');
    const form = document.getElementById('BookingForm'); 
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

    form.addEventListener('submit', (e) => {
        e.preventDefault();

        const firstName = document.getElementById('fn').value.trim();
        const lastName = document.getElementById('ln').value.trim();
        const flight_num = document.getElementById('flight_n').value.trim();
        const dep_date = document.getElementById('dep-date').value.trim();
        const departure = document.getElementById('departure').value.trim();
        const destination = document.getElementById('destination').value.trim();
        const status = document.getElementById('status').value.trim();

        let dateparts = dep_date.split('-');

        const newr = document.createElement('tr');
        newr.innerHTML = `
        <td>${firstName} ${lastName}</td>
        <td>${flight_num}</td>
        <td>${simplify(dep_date)}</td>
        <td>${departure}</td>
        <td>${destination}</td>
        <td><span class="status ${capitalize(status)}">${capitalize(status)}</span></td>
        <td>
            <div class="options">
                <button class="option">
                <i class="fa-solid fa-user-check"></i>
                </button>
            </div>
        </td>`;

        table.prepend(newr);


        const overlay = document.getElementById('overlay');
        if (overlay) {
            overlay.classList.remove('active');
            form.reset();
        }
    });



    function capitalize(s) {
        if (!s) return '';
        return s.charAt(0).toUpperCase() + s.slice(1);
    }



 

    function checkIn(r) {
        // collecting info of that row
        const checkInOverlay = document.getElementById('check-in-overlay');
        const step1 = document.getElementById('step1');
        const step2 = document.getElementById('step2');
        const step3 = document.getElementById('step3');
        const nextBtn1 = document.getElementById('next-btn1');
        const nextBtn2 = document.getElementById('next-btn2');
        const prevBtn1 = document.getElementById('prev-btn1');
        const prevBtn2 = document.getElementById('prev-btn2');
        const confirmBtn = document.getElementById('confirm-btn');
        const cancelCheckInBtn = document.getElementById('cancel-btn1');

        const infos = r.querySelectorAll('td');
        const fullName = infos[0].textContent.trim().split(/\s+/);
        const flightnum = infos[1].textContent.trim();
        const date = infos[2].textContent.trim();
        const from = infos[3].textContent.trim();
        const to = infos[4].textContent.trim();
        let status = infos[5];



         document.getElementById('check-in-fn').value = fullName[0];
         document.getElementById('check-in-ln').value = fullName[1];
         document.getElementById('check-in-flight_n').value = flightnum;
         document.getElementById('check-in-departure').value = from;
         document.getElementById('check-in-destination').value = to;

        const dateParts = date.split('\u00A0');
        const day = dateParts[0];
        const month = monthToNum[dateParts[1]];
        const year = dateParts[2];
        document.getElementById('check-in-date').value = `${year}-${month}-${day}`;
    
        checkInOverlay.classList.add('active');

        step1.classList.add('active');

        nextBtn1.addEventListener('click', () => {
            step1.classList.remove('active');
            step2.classList.add('active');
        })


        nextBtn2.addEventListener('click', () => {
            step2.classList.remove('active');
            step3.classList.add('active');
        })

        prevBtn1.addEventListener('click', ()=> {
            step2.classList.remove('active');
            step1.classList.add('active');
        } )

        prevBtn2.addEventListener('click', ()=> {
            step3.classList.remove('active');
            step2.classList.add('active');
        })

        confirmBtn.addEventListener('click', ()=> {
            // send data to boarding
            // status = done
            // button of check in transform to done
            // print boarding-pass
            step3.classList.remove('active');
            checkInOverlay.classList.remove('active');
        }) 

        

        document.addEventListener('click', (e) => {
        if (e.target === checkInOverlay) {
            checkInOverlay.classList.remove('active');
            if (step1.classList.contains('active')) {
                step1.classList.remove('active');
            }
            if (step2.classList.contains('active')) {
                step2.classList.remove('active');
            }
            if (step3.classList.contains('active')) {
                step3.classList.remove('active');
            }
        }
            });

         cancelCheckInBtn.addEventListener('click', () => {
            checkInOverlay.classList.remove('active');
            if (step1.classList.contains('active')) {
                step1.classList.remove('active');
            }
            if (step2.classList.contains('active')) {
                step2.classList.remove('active');
            }
            if (step3.classList.contains('active')) {
                step3.classList.remove('active');
            }
         });

         document.addEventListener('click', (e) => {
            if (e.target.classList.contains('seat')) {
                e.target.classList.toggle('taken');
                if (e.target.classList.contains('taken')) {
                    let chosenSeat = e.target;
                    // work here later
                }

            }
         })

    }
        
    



    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('fa-user-check')) {
            const r = e.target.closest('tr');
            checkIn(r);
        }
        
    })

    



});
