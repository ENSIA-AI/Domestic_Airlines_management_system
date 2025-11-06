const table = document.getElementById('bookingTbBody');
const form = document.getElementById('BookingForm');

form.addEventListener('submit', (e)=>{
    e.preventDefault();
    const FID = document.getElementById('FID').value;
    const DEP = document.getElementById('DEP').value;
    const ARR = document.getElementById('ARR').value;
    const DATE = document.getElementById('DATE').value;
    const AC = document.getElementById('SEAT').value;
    const STATUS = document.getElementById('status').value;
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXTZ0123456789';
    let id = '';
    for(let i=0;i<6;i++){
        let r = Math.floor(Math.random() * 35);
        id += chars[r];
    }
    const newr = document.createElement('tr');
    newr.innerHTML=`
    
                    <td>${FID}</td>
                    <td>${DEP}</td>
                    <td>${ARR}</td>
                    <td>${DATE}</td>
                    <td>${AC}</td>
                    <td><span class="status ${STATUS}">${STATUS}</span></td>
                    <td>
                        <div class="options">
                            <button class="option"><i class="fa fa-edit"></i></button>
                            <button class="option"><i class="fa fa-trash"></i></button>
                        </div>
                    </td>`;

    table.appendChild(newr);
    form.reset();
})