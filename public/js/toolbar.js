/**
 * Created by Станислав on 22.05.15.
 */

$('.SmoothScroll').click(function(event) {
    event.preventDefault();
    var href=$(this).attr('href');
    var target=$(href);
    var top=target.offset().top - 55;
    $('html,body').animate({
        scrollTop: top
    }, 1000);
});

$(document).change(function(){
    var formsCount = document.forms.length;
    var index;
    var flag = [true];
    var elementNumber;
    var elementToChange;
    var typeOfForm; //1 2 3 или 4 (тип вопроса)
    for (index = 0; index < formsCount - 1; ++index) {
        flag[index] = false;
        typeOfForm = document.forms[index].type.value;
        for(elementNumber = 0; elementNumber < document.forms[index].elements.length - 1; ++elementNumber){
            if(typeOfForm == 5){
                if(document.forms[index].elements[elementNumber].checked == true && document.forms[index].elements[elementNumber].value != 2){
                    flag[index] = true;
                }
            }
            if(typeOfForm == 3){
                //select
                if(document.forms[index].elements[elementNumber].type == 'select-one' && document.forms[index].elements[elementNumber].selectedIndex != 0){
                    flag[index] = true;
                }
            }
            if(typeOfForm == 2 || typeOfForm == 4                                                                                             ){
                // таблица соответствий
                if(document.forms[index].elements[elementNumber].checked == true){
                    flag[index] = true;
                }
            }
            if(typeOfForm == 1){
                //да/нет
                if(document.forms[index].elements[elementNumber].checked == true){
                    flag[index] = true;
                }
            }
            if(typeOfForm == 8){
                //открытый тип
                if(document.forms[index].elements[4].value != ""){
                    flag[index] = true;
                }
            }
            if(typeOfForm == 9){
                //Три точки
                if(document.forms[index].elements[4].value != ""){
                    flag[index] = true;
                }
            }
            if(typeOfForm == 11){
                //Восстановление аналитического вида
                if(document.forms[index].elements[4].value != ""){
                    flag[index] = true;
                }
            }
        }
        if(document.forms[index].seeLater.checked == false)
        {
            if (flag[index] == true) {
                elementToChange = document.getElementById(index);
                elementToChange.className = "Answered";
            }
            else{
                elementToChange = document.getElementById(index);
                elementToChange.className = "NotAnswered";
            }
        }
        else
        {
            elementToChange = document.getElementById(index);
            elementToChange.className = "Return";
        }

    }

});

function startTimer() {
    var my_timer = document.getElementById("my_timer");
    var time = my_timer.innerHTML;
    var arr = time.split(":");
    var m = arr[0];
    var s = arr[1];
    if (s <= 0) {
        if (m <= 0) {                                                                                                   //если время вышло
            fillSuper();                                                                                                //собираем все данные в супер-форму
            $('#super-form').attr('onsubmit','return sendForm(false)');                                                 //меняем обработчик на false
            $('#super-form').trigger('submit');                                                                         //генерируем событие submit
            return;
        }
        m--;
        if (m < 10) m = "0" + m;
        s = 59;
    }
    else s--;
    if (s < 10) s = "0" + s;
    document.getElementById("my_timer").innerHTML = m+":"+s;
    setTimeout(startTimer, 1000);
}