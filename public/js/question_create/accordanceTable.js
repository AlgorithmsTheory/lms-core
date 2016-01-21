/**
 * Created by Станислав on 22.01.16.
 */

/** построение таблицы соответсвий */
$('#type_question_add').on('click','#build-table', function(){
    var tr_number=document.getElementById("table-tr").value; //были изменения
    var td_number=document.getElementById("table-td").value;
    var cols = parseInt(tr_number);
    var rows = parseInt(td_number);
    var but = document.getElementById('build-table');
    but.disabled = true;

    var x = document.createElement("TABLE");
    x.setAttribute("id", "myTable");
    x.setAttribute("class" , "table table-bordered");
// x.setAttribute("style", "width: 100%;");
    document.getElementById("table-place").appendChild(x);
    var b = document.createElement("TBODY");

    b.setAttribute("id", "myBody");
    document.getElementById("myTable").appendChild(b);

    var y = document.createElement("TR");
    y.setAttribute("id", "0");
    document.getElementById("myBody").appendChild(y);
    var z = document.createElement("TD");
    var t = document.createTextNode("#");
    z.appendChild(t);
    document.getElementById("0").appendChild(z);
    for (k = 1; k <= rows; k++) {
        var z = document.createElement("TD");
        var t = document.createElement("INPUT");
        t.setAttribute("type", "text");
        t.setAttribute("style", "width: 80px;");
        t.setAttribute("placeholder", "Свойство");
        t.setAttribute("name", "variants[]");
        z.appendChild(t);
        document.getElementById("0").appendChild(z);
    }
    for (i = 1; i <= cols; i++) {
        var y = document.createElement("TR");
        y.setAttribute("id", i);
        document.getElementById("myBody").appendChild(y);
        var z = document.createElement("TD");
        var t = document.createElement("TEXTAREA");
// t.setAttribute("type", "text");
        t.setAttribute("placeholder", "Объект");
        t.setAttribute("name", "title[]");
// t.setAttribute("style", "width: 80px;");
        z.appendChild(t);
        document.getElementById(i).appendChild(z);
        for (k = 1; k <= rows; k++) {
            var z = document.createElement("TD");
            var t = document.createElement("INPUT");
            t.setAttribute("type", "checkbox");
            t.setAttribute("name", "answer[]");
            t.setAttribute("value", ((i-1)*rows + k));
            z.appendChild(t);
            document.getElementById(i).appendChild(z);
        }
    }
});