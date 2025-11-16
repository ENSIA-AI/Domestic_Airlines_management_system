const form = document.getElementById('FlightsForm');
const tableBody = document.getElementById('flightsTbBody');
form.addEventListener('submit', (e)=>{
    e.preventDefault();
    const FID = document.getElementById('FID').value;
    const DEP = document.getElementById('DEP').value;
    const ARR = document.getElementById('DEST').value;
    const DATE = document.getElementById('DATE').value;
    const AC = document.getElementById('AC').value;
    const STATUS = document.getElementById('STATUS').value;
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYTZ0123456789';
    // random id generation??

    // transform STATUS to Title Case
   let statusString;
   STATUS == 'confirmed' ? statusString = 'Confirmed' : statusString = 'Cancelled';
    const newr = document.createElement('tr');
    newr.innerHTML=`
                    <td>${FID}</td>
                    <td>${DEP}</td>
                    <td>${ARR}</td>
                    <td>${DATE}</td>
                    <td>${AC}</td>
                    <td><div class="flight-status ${STATUS}">${statusString}</span></td>
                    <td>
                        <div class="options">
                        <button class="option"><i class="fa fa-eye"></i></button>
                        <button class="option"><i class="fa fa-edit"></i></button>
                        <button class="option"><i class="fa fa-trash"></i></button>
                        </div>
                    </td>`;
    

    console.log(tableBody);
    console.log(newr);
    tableBody.prepend(newr);
    form.reset();
})