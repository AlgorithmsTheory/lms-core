/**
 * Created by Станислав on 22.05.15.
 */

function sendForm(status){
    var formsCount = document.forms.length - 2;
    var elementNumber;
    var flag = [true];
    var countChecked = 0;
    for (index = 0; index < formsCount; ++index) {
        flag[index] = false;
        typeOfForm = document.forms[index].type.value;
        for(elementNumber = 0; elementNumber < document.forms[index].elements.length - 1; ++elementNumber){
            if(typeOfForm == 5){
                // да\нет
                if(document.forms[index].elements[elementNumber].checked == true && document.forms[index].elements[elementNumber].value != 2){
                    flag[index] = true;
                }
            }
            if(typeOfForm == 3){
                //текстовый вопрос
                if(document.forms[index].elements[elementNumber].type == 'select-one' && document.forms[index].elements[elementNumber].selectedIndex != 0){
                    flag[index] = true;
                }
            }
            if(typeOfForm == 2 || typeOfForm == 4){
                // таблица соответствий и чекбоксы
                if(document.forms[index].elements[elementNumber].checked == true){
                    flag[index] = true;
                }
            }
            if(typeOfForm == 1){
                // выбор одного из списка
                if(document.forms[index].elements[elementNumber].checked == true){
                    flag[index] = true;
                }
            }
        }
    }
    if (status == true){
        for (index = 0; index < formsCount; ++index) {
            if(flag[index]) {countChecked++;}
        }
        return confirm('Вы уверены, что хотите завершить тест? Вы ответили на ' + countChecked + ' вопросов из ' + formsCount + '.');
    }
    else return alert("Время вышло");
}

function fillSuper(){
        var array = [];
        var amount = document.getElementById('amount').value;
        for (var i=0; i<amount; i++){
            //alert ('i= '+i);
            var typeOfForm = document.forms[i].type.value;
            var k = 0;
            var pattern = /^\d+$/;
            var allElem = document.forms[i].elements;
            for (var j=0; j<document.forms[i].elements.length; j++){
                //alert (allElem[j].name);
                if(typeOfForm == 1){   // выбор одного из списка
                    if(allElem[j].name=='num' || (allElem[j].name=='choice' && allElem[j].checked == true)) {
                        array[k] = allElem[j].value;
                        k++;
                    }
                }

                if(typeOfForm == 2){     //выбор нескольких из списка
                    if(allElem[j].name=='num' || (allElem[j].name=='choice[]' && allElem[j].checked == true)){
                        array[k] = allElem[j].value;
                         k++;
                    }
                }

                if(typeOfForm == 3){   //текстовый вопрос
                    if(allElem[j].name=='num' || (pattern.test(allElem[j].name) && pattern.test(allElem[j].selectedIndex))){
                        array[k] = allElem[j].value;
                        k++;
                    }
                }

                if(typeOfForm == 4){       //таблица соотвтествий
                    if(allElem[j].name=='num'){
                        array[k] = allElem[j].value;
                        k++;
                    }
                    if ((pattern.test(allElem[j].name) && allElem[j].checked == true)){
                        array[k] = allElem[j].name;
                        k++;
                    }
                }

                if(typeOfForm == 5){    //да-нет
                    if(allElem[j].name=='num' || (pattern.test(allElem[j].name) && allElem[j].checked == true)){
                        array[k] = allElem[j].value;
                        k++;
                    }
                }

            }
            //alert(array);
            document.getElementById('super'+i).value=JSON.stringify(array);   //заполнили суперформу id и выбранными вариантами
            //alert (document.getElementById('super'+i).value);
            array = [];
        }
}
