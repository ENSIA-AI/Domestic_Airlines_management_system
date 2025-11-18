document.addEventListener('DOMContentLoaded', () => {
    const addBtn = document.querySelector('.add-btn');
    const overlay = document.getElementById('overlay');
    const cancelBtn = document.getElementById('cancel-btn');
    const bookingForm = document.getElementById('BookingForm');
    const table = document.getElementById('tablebody');

    addBtn.addEventListener('click', () => {
        overlay.classList.add('active');
    });

    cancelBtn.addEventListener('click', () => {
        overlay.classList.remove('active');
        bookingForm.reset();
    });

    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) {
            overlay.classList.remove('active');
            bookingForm.reset();
        }
    });

    table.addEventListener("click", (e) => {
        if (e.target.classList.contains("fa-trash")) {
        const confirmed = confirm("Are you sure you want to delete this booking?");
        if (!confirmed) return;
        const row = e.target.closest("tr");
        if (row) row.remove();
        }
    });

    console.log('form.js initialized');
});
