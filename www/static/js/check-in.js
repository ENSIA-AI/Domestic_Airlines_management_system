
document.addEventListener('DOMContentLoaded', () => {

    const tableContainer = document.querySelector('.table-container');
    const checkInOverlay = document.getElementById('check-in-overlay');
    const checkInForm = document.getElementById('check-in-form');

    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    const step3 = document.getElementById('step3');
    const pdfFrame = document.getElementById('pdf-frame');
    
    const nextBtn1 = document.getElementById('next-btn1');
    const nextBtn2 = document.getElementById('next-btn2');
    const prevBtn1 = document.getElementById('prev-btn1');
    const prevBtn2 = document.getElementById('prev-btn2');
    const confirmBtn = document.getElementById('confirm-btn');
    const cancelBtn = document.getElementById('cancel-btn1');
    let selectedSeat = null;
    let currentBookingId = null;
    loadRows();

    function resetSteps() {
        step1.classList.remove('active');
        step2.classList.remove('active');
        step3.classList.remove('active');
    }

    function openCheckIn() {
        checkInOverlay.classList.add('active');
        resetSteps();
        step1.classList.add('active');
    }

    function closeCheckIn() {
        checkInOverlay.classList.remove('active');
        resetSteps();
    }

    function checkIn(row) {
        if (!row) return;

        const infos = row.querySelectorAll('td');
        if (!infos.length) return;
        openCheckIn();
        loadingAnimation();
        const bookingId = infos[2].textContent.trim();
        currentBookingId = bookingId;
        const xhr = new XMLHttpRequest();
        xhr.open(
            'GET',
            `backend/check-in.php?action=getBookingInfo&bookingId=${encodeURIComponent(bookingId)}`,
            true
        );

        xhr.onload = function () {
            if (xhr.status === 200) {
                 checkInForm.innerHTML = xhr.responseText;
                
            }
        };

        xhr.send();
    }

    function makeBookingCompleted() {
        const xhr = new XMLHttpRequest();
        xhr.open('POST',
            `backend/check-in.php`,
            true
        );

        let backendParams = `action=makeBookingCompleted` + 
        `&currentBookingId=${encodeURIComponent(currentBookingId)}`;

        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if(this.status == 200) {
                 loadRows();
            }
        }

        xhr.send(backendParams);
    }

    function loadingAnimation() {
        checkInForm.innerHTML = `
                                <div class="spinner-container" 
                                style="background-color: rgba(255, 255, 255, 0);">
                                    <div class="spinner"></div>
                                    Loading...
                                </div>`;
    }

    /* ---------- GLOBAL EVENT HANDLING ---------- */

    document.addEventListener('click', (e) => {

        // check-in icon
        if (e.target.classList.contains('fa-user-check')) {
            checkIn(e.target.closest('tr'));
        }

        // overlay click
        if (e.target === checkInOverlay) {
            closeCheckIn();
        }

        // seat selection
        if (e.target.classList.contains('seat')) {
             // remove previous selection
            document.querySelectorAll('.seat.taken').forEach(seat => {
            seat.classList.remove('taken');
            });

            // select new seat
            e.target.classList.add('taken');
            selectedSeat = e.target.textContent.trim();
        }
    });

    /* ---------- BUTTONS ---------- */

    nextBtn1?.addEventListener('click', () => {
        step1.classList.remove('active');
        step2.classList.add('active');
    });

    nextBtn2?.addEventListener('click', () => {
        if (!selectedSeat) {
            alert('Please select a seat first.');
            return;
        }

        // Prepare data to send to backend
        const formData = new FormData(checkInForm);
        formData.append('Seat', selectedSeat);
        formData.append('action', 'generateBoardingPass');

        pdfFrame.src = ""; 

        fetch('backend/check-in.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.blob())
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            // Set the iframe source to the PDF blob URL
            pdfFrame.src = url;
            
            // Move to Step 3
            step2.classList.remove('active');
            step3.classList.add('active');
        })
        .catch(err => console.error("Error generating PDF:", err));
    });

    prevBtn1?.addEventListener('click', () => {
        step2.classList.remove('active');
        step1.classList.add('active');
    });

    prevBtn2?.addEventListener('click', () => {
        step3.classList.remove('active');
        step2.classList.add('active');
    });

    confirmBtn?.addEventListener('click', () => {
        // for printing when the confirm button is clicked, uncomment this
        // pdfFrame.contentWindow.print();
        
        // make the booking status completed instead of confirmed :
        makeBookingCompleted();
        currentBookingId = null;

        // Optional: Close the modal after a delay
        setTimeout(() => {
            alert("Check-in Complete!");
            closeCheckIn();
        }, 1000);

    });


    cancelBtn?.addEventListener('click', closeCheckIn);


    function loadRows() {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'backend/check-in.php?action=loadrows', true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                tableContainer.innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    }

});
