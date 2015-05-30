/**
 * Created by Станислав on 22.05.15.
 */

$('.SmoothScroll').click(function(event) {
    event.preventDefault();
    var href=$(this).attr('href');
    var target=$(href);
    var top=target.offset().top - 35;
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
            if(typeOfForm == 2){
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
    var h = arr[0];
    var m = arr[1];
    var s = arr[2];
    if (s == 0) {
        if (m == 0) {
            if (h == 0) {
                alert("Время вышло");
                window.location.reload();
                return;
            }
            h--;
            m = 60;
            if (h < 10) h = "0" + h;
        }
        m--;
        if (m < 10) m = "0" + m;
        s = 59;
    }
    else s--;
    if (s < 10) s = "0" + s;
    document.getElementById("my_timer").innerHTML = h+":"+m+":"+s;
    setTimeout(startTimer, 1000);
}