const table = document.getElementById('bookingTbBody');
const form = document.getElementById('BookingForm');


form.addEventListener('submit', (e)=>{
    e.preventDefault();
    const firstName = document.getElementById('fn').value;
    const lastName = document.getElementById('ln').value;
    const flight_num = document.getElementById('flight_n').value;
    const dep_data = document.getElementById('date').value;
    const seat = document.getElementById('seat').value;
    // const email = document.getElementById('email').value;
    // const phone_num = document.getElementById('phone').value;
    const status = document.getElementById('status').value;
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXTZ0123456789';
    let id = '';
    for(let i=0;i<6;i++){
        let r = Math.floor(Math.random() * 35);
        id += chars[r];
    }
    const newr = document.createElement('tr');
    newr.innerHTML=`
    <td>${id}</td>
                    <td>${lastName} ${lastName}</td>
                    <td>${flight_num}</td>
                    <td>${dep_data}</td>
                    <td>${seat}</td>
                    <td><span class="status ${status}">${status}</span></td>
                    <td>
                        <div class="options">
                            <button class="option"><i class="fa fa-edit"></i></button>
                            <button class="option"><i class="fa fa-trash"></i></button>
                        </div>
                    </td>`;

    table.appendChild(newr);
    form.reset();
})