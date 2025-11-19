document.addEventListener('DOMContentLoaded', () => {
  let moreBtns = document.querySelectorAll('.fa-circle-chevron-down');
  let parentRows = document.querySelectorAll('.parent-row');

  moreBtns.forEach((btn) => {
    btn.addEventListener('click', () => {
      const parentRow = btn.closest('.parent-row');
      if (parentRow.classList.contains('active-parent')) {
        unShowChilds(parentRow);
      } else {
        showChilds(parentRow);
      }
      
    })
  })




  function showChilds(parentRow) {
      parentRow.classList.add('active-parent');
      childRows = getChildRows(parentRow);
      childRows.forEach(row => row.style.display='table-row');
    
  }

  function unShowChilds(parentRow) {
    parentRow.classList.remove('active-parent');
    childRows = getChildRows(parentRow);
    childRows.forEach(row => row.style.display='none');

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

    const countDowns = document.querySelectorAll('.countdown');
    countDowns.forEach(countdown => {
      const time = countdown.previousElementSibling.textContent;
      const date = countdown.previousElementSibling.previousElementSibling.textContent;
      const dateParts = date.split(' ');
      const day = dateParts[0];
      const month = dateParts[1];
      const year = dateParts[2];
      
      const countDownDate = new Date(`${month} ${day}, ${year} ${time}:00`).getTime();
      //format is  new Date("Dec 31, 2025 23:59:59").getTime();

    // 2. Update the countdown every 1 second
      const x = setInterval(function() {

        // Get today's date and time
        const now = new Date().getTime();

        // Find the distance between now and the countdown date
        const distance = countDownDate - now;

        // Time calculations for days, hours, minutes, and seconds
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Output the result in the element with id="countdown-timer"
        countdown.innerHTML = days + "d " + hours + "h "
        + minutes + "m " + seconds + "s ";

        // If the countdown is finished, write some text 
        if (distance < 0) {
            clearInterval(x); // Stop the timer
            document.getElementById("countdown-timer").innerHTML = "EXPIRED";
        }
    }, 1000); // 1000 milliseconds = 1 second


    })
    


    


})