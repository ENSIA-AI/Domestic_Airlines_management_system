document.addEventListener('DOMContentLoaded', () => {
    const addBtn = document.querySelector('.add-btn');
    const overlay = document.getElementById('overlay');
    const cancelBtn = document.getElementById('cancel-btn');
    const bookingForm = document.getElementById('BookingForm');

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

    console.log('form.js initialized');
});
