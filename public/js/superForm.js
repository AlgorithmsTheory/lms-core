/**
 * Created by Станислав on 22.05.15.
 */
function fillSuper(){
    var array = [];
    var amount = document.getElementById('amount').value;
    for (var i=0; i<amount; i++){
        //alert ('i= '+i);
        var k = 0;
        var pattern = /^\d+$/;
        var allElem = document.forms[i].elements;
        for (var j=0; j<document.forms[i].elements.length; j++){
            //alert (allElem[j].name);
            if(allElem[j].name=='num' ||
                (allElem[j].name=='choice' && allElem[j].checked == true) ||
                (allElem[j].name=='choice[]' && allElem[j].checked == true) ||
                pattern.test(allElem[j].name)) {
                array[k] = allElem[j].value;
                k++;
                //alert (allElem[j].value);
            }
            //alert('j= '+j+'/'+(document.forms[i].elements.length-1));
        }
        //alert(array);
        document.getElementById('super'+i).value=JSON.stringify(array);   //заполнили суперформу id и выбранными вариантами
        //alert (document.getElementById('super'+i).value);
        array = [];
    }
}

function sendForm() {
    return confirm("Вы хотите отправить данные?")
}