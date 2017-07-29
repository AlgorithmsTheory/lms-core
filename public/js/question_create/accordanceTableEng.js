/**
 * Created by ssorokin on 28.07.2017.
 */

/** построение английской таблицы соответствий */
$('#type_question_add').on('click','#build-table-eng', function(){
    var trNumberEng = $("#table-tr-eng").val(); //были изменения
    var tdNumberEng = $("#table-td-eng").val();
    var rowsEng = parseInt(trNumberEng);
    var colsEng = parseInt(tdNumberEng);
    $('#build-table-eng').prop( "disabled", true);

    var tableEng = document.createElement("TABLE");
    tableEng.setAttribute("id", "table-eng");
    tableEng.setAttribute("class" , "table table-bordered");
    $("#table-place-eng").append(tableEng);

    var tableBodyEng = document.createElement("TBODY");
    tableBodyEng.setAttribute("id", "body-eng");
    tableEng.appendChild(tableBodyEng);

    var firstTrEng = document.createElement("TR");
    firstTrEng.setAttribute("id", "0-eng");
    tableBodyEng.appendChild(firstTrEng);

    var leftUpCornerTdEng = document.createElement("TD");
    var cornerTextEng = document.createTextNode("#");
    leftUpCornerTdEng.appendChild(cornerTextEng);
    firstTrEng.appendChild(leftUpCornerTdEng);

    for (var colCounterEng = 1; colCounterEng <= colsEng; colCounterEng++) {
        var currentTdEng = document.createElement("TD");
        var currentTdInputEng = document.createElement("INPUT");
        currentTdInputEng.setAttribute("type", "text");
        currentTdInputEng.setAttribute("style", "width: 80px;");
        currentTdInputEng.setAttribute("placeholder", "Property");
        currentTdInputEng.setAttribute("name", "eng-variants[]");
        currentTdEng.appendChild(currentTdInputEng);
        firstTrEng.appendChild(currentTdEng);
    }

    for (var rowCounter = 1; rowCounter <= rowsEng; rowCounter++) {
        var currentTrEng = document.createElement("TR");
        currentTrEng.setAttribute("id", rowCounter + "-eng");
        tableBodyEng.appendChild(currentTrEng);

        var objectTdEng = document.createElement("TD");
        var textareaObjectTdEng = document.createElement("TEXTAREA");
        textareaObjectTdEng.setAttribute("placeholder", "Object");
        textareaObjectTdEng.setAttribute("name", "eng-title[]");
        objectTdEng.appendChild(textareaObjectTdEng);

        currentTrEng.appendChild(objectTdEng);

        for (var dataColsCounter = 1; dataColsCounter <= colsEng; dataColsCounter++) {
            var currentDataTdEng = document.createElement("TD");

            var currentDataDivTdEng = document.createElement("DIV");
            currentDataDivTdEng.setAttribute("class", "checkbox checkbox-styled");

            var currentDataLabelDivTdEng = document.createElement("LABEL");

            var currentDataInputLabelDivTdEng = document.createElement("INPUT");
            currentDataInputLabelDivTdEng.setAttribute("type", "checkbox");
            currentDataInputLabelDivTdEng.setAttribute("name", "eng-answer[]");
            currentDataInputLabelDivTdEng.setAttribute("value", ((rowCounter - 1) * colsEng + dataColsCounter));

            var currentDataSpanLabelDivTdEng = document.createElement("SPAN");

            currentDataLabelDivTdEng.appendChild(currentDataInputLabelDivTdEng);
            currentDataLabelDivTdEng.appendChild(currentDataSpanLabelDivTdEng);
            currentDataDivTdEng.appendChild(currentDataLabelDivTdEng);
            currentDataTdEng.appendChild(currentDataDivTdEng);
            currentTrEng.appendChild(currentDataTdEng);
        }
    }
});