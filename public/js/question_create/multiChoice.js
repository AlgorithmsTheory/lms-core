/**
 * Created by Станислав on 22.01.16.
 */

var count = $('#count').val();                                                                                          //счетчик числа вариантов
var rightAnswersCount = $('#right-answers').val();
$('#guess').val(evalGuess(count, rightAnswersCount));

/** Добавление варианта */
$('#type_question_add').on('click','#add-var-2', function(){
    count++;
    $('#variants').append('\
            <div class="form-group">\
                <textarea  name="variants[]"  class="form-control textarea3" rows="1" placeholder="" required></textarea>\
                <label for="textarea3">Вариант ' + count + '</label>\
            </div>\
            ');
    $('#eng-variants').append('\
            <div class="form-group">\
                <textarea  name="eng-variants[]"  class="form-control textarea3" rows="1" placeholder=""></textarea>\
                <label for="textarea3">Variant ' + count + '</label>\
            </div>\
            ');
    $('#answers').append('\
            <div class="checkbox checkbox-styled" style="margin-top:49px">\
                <label>\
                    <input type="checkbox" name="answers[]" value="'+ count + '">\
                    <span></span>\
                </label>\
            </div>\
            ');
    $('#guess').val(evalGuess(count, rightAnswersCount));
});

/** Удаление последнего варианта */
$('#type_question_add').on('click','#del-var-2',function(){
    if (count > 1){
        $('#variants').children().last().remove();
        $('#eng-variants').children().last().remove();
        $('.checkbox-styled').last().remove();
        count--;
        $('#guess').val(evalGuess(count, rightAnswersCount));
    }
});

$('#type_question_add').on('change', '#answers input', function () {
   if ($(this).prop('checked')) rightAnswersCount++;
   else rightAnswersCount--;
    $('#guess').val(evalGuess(count, rightAnswersCount));
});

function getMinWriteAnswers(rightAnswersCount) {
    return Math.ceil(rightAnswersCount * 0.6);
}

function evalGuess(count, rightAnswersCount) {
    var rowNumber = 1 << count;
    var minWriteAnswers = getMinWriteAnswers(rightAnswersCount);
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

