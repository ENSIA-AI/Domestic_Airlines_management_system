const addBtn = document.querySelector('.add-btn');
const overlay = document.getElementById('overlay');
const cancelBtn = document.getElementById('cancel-btn');

addBtn.addEventListener('click', () => {
    overlay.classList.add('active');
});

cancelBtn.addEventListener('click', () => {
    overlay.classList.remove('active');
});

overlay.addEventListener('click', (e) => {
    if (e.target === overlay) overlay.classList.remove('active');
});


const delbtn = document.querySelectorAll(".fa-trash");

delbtn.forEach(button => {
    button.addEventListener("click", () => {
        const confirmed = confirm("Are you sure you want to delete this booking?");
        if (!confirmed) return;

        const row = button.closest("tr");
        if (row) {
            row.remove();
        }
    });
});
