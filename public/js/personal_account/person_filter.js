function groupFilter() {
    // Declare variables
    var filter, table, tr, td, i;
    filter = $('#groupInput option:selected').text().toUpperCase().trim();
    theValue = +$('#groupInput option:selected').val();
    table = document.getElementById("target");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
            const selectEl = td.querySelector('select');
            if (selectEl) {
                if (filter === 'ВСЕ' || +selectEl.value === theValue) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            } else {
                if (filter === 'ВСЕ' || td.innerHTML.toUpperCase().trim() === filter) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
}

function emailFilter() {
    // Declare variables
    var input, filter, table, tr, td, i;
    input = document.getElementById("emailInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("target");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[3];
        if (td) {
            if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

function nameFilter() {
    // Declare variables
    var input, filter, table, tr, td, i;
    input = document.getElementById("nameInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("target");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        if (td) {
            if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
};