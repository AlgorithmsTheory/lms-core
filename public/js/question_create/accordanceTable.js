/**
 * Created by Станислав on 22.01.16.
 */
var tr_number=document.getElementById("table-tr").value; //были изменения
var td_number=document.getElementById("table-td").value;
var rows = parseInt(tr_number);
var cols = parseInt(td_number);

$('#guess').val(evalGuess(rows, cols));

/** построение таблицы соответсвий */
$('#type_question_add').on('click','#build-table', function(){
    var tr_number=document.getElementById("table-tr").value; //были изменения
    var td_number=document.getElementById("table-td").value;
    cols = parseInt(tr_number);
    rows = parseInt(td_number);
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

            var d = document.createElement("DIV");
            d.setAttribute("class", "checkbox checkbox-styled");

            var l = document.createElement("LABEL");

            t.setAttribute("type", "checkbox");
            t.setAttribute("name", "answer[]");
            t.setAttribute("value", ((i-1)*rows + k));

            var s = document.createElement("SPAN");

            l.appendChild(t);
            l.appendChild(s);
            d.appendChild(l);
            z.appendChild(d);
            y.appendChild(z);
        }
    }
    $('#guess').val(evalGuess(rows, cols));
});

$('#type_question_add').on('change', '#myTable input', function(){
    $('#guess').val(evalGuess(rows, cols));
});

function evalGuess(rows, columns) {
    var rowNumber = 1 << rows;
    var totalProbability = 0;
    for (var i = 0; i < rowNumber; i++) {
        var splittedBinaryNumber = parseInt(i).toString(2).split('');
        var lengthDifference = rows - splittedBinaryNumber.length;
        var rightAnswers = 0;
        var multProbability = 1;
        for (var j = 0; j < lengthDifference; j++) {
            multProbability *= 1 - evalProbabilityForRow(columns, getRightAnswersCountInRow(j+1, columns));
        }
        var k = 0;
        for (j = lengthDifference; j < rows; j++) {
            if (splittedBinaryNumber[k++] > 0) {
                rightAnswers++;
                multProbability *= evalProbabilityForRow(columns, getRightAnswersCountInRow(j+1, columns));
            }
            else multProbability *= 1 - evalProbabilityForRow(columns, getRightAnswersCountInRow(j+1, columns));
        }
        console.log(splittedBinaryNumber.join() + ': ' + rightAnswers + ', ' + multProbability);
        if (rightAnswers >= 0.6 * rows) totalProbability += multProbability;
    }
    return totalProbability;
}

function getRightAnswersCountInRow(rowNum, columnsCount) {
    var rightAnswersCount = 0;
    for (var cell = 0; cell < columnsCount; cell++) {
        if ($(($('#' + rowNum + ' input')[cell])).prop('checked')) rightAnswersCount++;
    }
    return rightAnswersCount;
}

function getMinWriteAnswersForRow(rightAnswersCount) {
    return Math.ceil(rightAnswersCount * 0.6);
}

function evalProbabilityForRow(count, rightAnswersCount) {
    var rowNumber = 1 << count;
    var minWriteAnswers = getMinWriteAnswersForRow(rightAnswersCount);
    var rightSums = 0;
    for (var i = 1; i < rowNumber; i++) {
        var splittedBinaryNumber = parseInt(i).toString(2).split('');
        var lengthDifference = count - splittedBinaryNumber.length;
        var sum = 0;
        var k = 0;
        for (var j = lengthDifference; j < count; j++) {
            if (j < rightAnswersCount) sum += parseInt(splittedBinaryNumber[k++]);
            else sum -= parseInt(splittedBinaryNumber[k++]);
        }
        if (sum >= minWriteAnswers) rightSums++;
    }
    return rightSums / (rowNumber - 1);
}