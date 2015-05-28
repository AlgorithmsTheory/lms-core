/**
 * Created by Станислав on 22.05.15.
 */

$('.SmoothScroll').click(function(event) {
    event.preventDefault();
    var href=$(this).attr('href');
    var target=$(href);
    var top=target.offset().top;
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
    for (index = 0; index < formsCount; ++index) {
        flag[index] = false;
        typeOfForm = document.forms[index].type.value;
        for(elementNumber = 0; elementNumber < document.forms[index].elements.length; ++elementNumber){
            if(typeOfForm == 9){
//спросить у Стаса
            }
            if(typeOfForm == 20){
//спросить у Стаса
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
        if (flag[index] == true) {
            elementToChange = document.getElementById(index);
            elementToChange.className = "Answered";
            //alert(index);
        }
        else{
            elementToChange = document.getElementById(index);
            elementToChange.className = "NotAnswered";
        }

    }

});