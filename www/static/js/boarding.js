document.addEventListener('DOMContentLoaded', () => {
    

    let tableContainer = document.querySelector('.table-container');


    loadflights();
    document.addEventListener('click', (e) => {
 
        const button = e.target.closest('.option'); 
        
        if (button) {
            const parentRow = button.closest('tr');
            

            if (parentRow.classList.contains('active-parent')) {
                unShowChilds(parentRow);

            } else {
                showChilds(parentRow);

            }
        }
    });



    function showChilds(parentRow) {
        parentRow.classList.add('active-parent');
        const childRows = getChildRows(parentRow); 
        childRows.forEach(row => row.style.display = 'table-row');
    }

    function unShowChilds(parentRow) {
        parentRow.classList.remove('active-parent');
        const childRows = getChildRows(parentRow); 
        childRows.forEach(row => row.style.display = 'none');
    }

    function getChildRows(parentRow) {
        let rows = [];
        let current = parentRow.nextElementSibling;

    
        while (current && !current.classList.contains('parent-row')) {
            rows.push(current);
            current = current.nextElementSibling;
        }
        return rows;
    }

    
    function loadflights() {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'backend/boarding.php?action=loadFlights', true);
        xhr.onload = function () {
            if (xhr.status === 200) {

                tableContainer.innerHTML = xhr.responseText;
                
                initCountdowns();
            }
        };
        xhr.send();
    }

    // --- COUNTDOWN LOGIC ---

    function initCountdowns() {
        const countDowns = document.querySelectorAll('.countdown');
        
        countDowns.forEach(countdown => {
            // Get Time and Date from the previous cells
            // Structure: <td>Date</td> <td>Time</td> <td class='countdown'>
            const timeStr = countdown.previousElementSibling.textContent.trim();
            const dateStr = countdown.previousElementSibling.previousElementSibling.textContent.trim();
            
            // Combine them into a format JS Date accepts: "YYYY-MM-DD HH:MM:SS" or "YYYY-MM-DDTHH:MM:SS"
            // Assuming dateStr is "2024-05-20" and timeStr is "14:30:00"
            const flightDateString = `${dateStr} ${timeStr}`;
            const countDownDate = new Date(flightDateString).getTime();

            // Validate date
            if (isNaN(countDownDate)) {
                countdown.innerHTML = "Invalid Date";
                return;
            }

            // Update the countdown every 1 second
            const x = setInterval(function() {
                const now = new Date().getTime();
                const distance = countDownDate - now;

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Output result
                countdown.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

                // If expired
                if (distance < 0) {
                    clearInterval(x);
                    countdown.innerHTML = "DEPARTED"; // Update THIS specific row
                    countdown.style.color = "red";
                }
            }, 1000);
        });
    }
});