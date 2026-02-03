
document.addEventListener('DOMContentLoaded', () => {

    const tableContainer = document.querySelector('.table-container');
    const checkInOverlay = document.getElementById('check-in-overlay');
    const checkInForm = document.getElementById('check-in-form');

    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    const step3 = document.getElementById('step3');

    const nextBtn1 = document.getElementById('next-btn1');
    const nextBtn2 = document.getElementById('next-btn2');
    const prevBtn1 = document.getElementById('prev-btn1');
    const prevBtn2 = document.getElementById('prev-btn2');
    const confirmBtn = document.getElementById('confirm-btn');
    const cancelBtn = document.getElementById('cancel-btn1');

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

        const bookingId = infos[0].textContent.trim();

        const xhr = new XMLHttpRequest();
        xhr.open(
            'GET',
            `backend/check-in.php?action=getBookingInfo&bookingId=${encodeURIComponent(bookingId)}`,
            true
        );

        xhr.onload = function () {
            if (xhr.status === 200) {
                 checkInForm.innerHTML = xhr.responseText;
                openCheckIn();
            }
        };

        xhr.send();
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
            e.target.classList.toggle('taken');
        }
    });

    /* ---------- BUTTONS ---------- */

    nextBtn1?.addEventListener('click', () => {
        step1.classList.remove('active');
        step2.classList.add('active');
    });

    nextBtn2?.addEventListener('click', () => {
        step2.classList.remove('active');
        step3.classList.add('active');
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
        closeCheckIn();
        // TODO: send boarding data
    });

    cancelBtn?.addEventListener('click', closeCheckIn);

    /* ---------- AJAX ---------- */

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
