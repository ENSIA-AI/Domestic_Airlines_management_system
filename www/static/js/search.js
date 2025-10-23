function search() {
    var filter, tr, i, txtValue;
    filter = searchBar.value.toUpperCase();
    tr = table.getElementsByTagName("tr");
    for (i = 1; i < tr.length; i++) {
        let tds = tr[i].getElementsByTagName("td");
        if (tds) {
            txtValue = "";
            for (let j = 0; j < tds.length; j++) {
                txtValue += tds[j].textContent || tds[j].innerText;
            }
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}