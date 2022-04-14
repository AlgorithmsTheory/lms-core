/**
 * Created by Станислав on 22.05.15.
 */

function sendForm(status){
    var formsCount = document.forms.length - 2;
    var elementNumber;
    var flag = [true];
    var countChecked = 0;
    let ramCounter = 0;
    let postCounter = 0;
    let mtCounter = 0;
    let hamCounter = 0;
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
            if(typeOfForm == 12){
				// Turing
                let ctx = $('[name ^= mt-entity]').eq(mtCounter);
                
                flag[index] = true;
                
                mtCounter++;
                break;
			}
            if(typeOfForm == 13){
				// Markov
                let ctx = $('[name ^= ham-entity]').eq(hamCounter);
                
                flag[index] = true;
                
                hamCounter++;
                break;
			}
            if(typeOfForm == 14){
				// Post
                let ctx = $('[name ^= post-entity]').eq(postCounter);
                let code = JSON.stringify(GetRules(ctx));
                if(code.indexOf('Raw') != -1) {
                    flag[index] = true;
                }
                postCounter++;
                break;
			}
			if(typeOfForm == 15){
				// RAM
				let code = envs[ramCounter].RAM.TextEditor.get_text();
				if( /^\s*\w+/.test(code) ){
					flag[index] = true;
				}
                ramCounter++;
                break;
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
    // Execute Turing program before send result
    window.mt2SubmitAllTasks();
    // var cnt = 0;
    // $("[name^=mt-entity]").each(function(){
    //     mtSubmitTask(cnt, false);
    //     cnt++
    // });
    // Execute Markov program before send result
    var cnt = 0;
    $("[name^=ham-entity]").each(function(){
        hamSubmitTask(cnt, false);
        cnt++
    });
    // Execute Post program before send result
    var cnt = 0;
    $("[name^=post-entity]").each(function(){
        postSubmitTask(cnt, false);
        cnt++
    });
    // Execute RAM program before send result
    var cnt = 0;
    $("[name^=ram-entity]").each(function(){
        ramSubmitTask(cnt, false);
        cnt++
    });

    var amount = document.getElementById('amount').value;
    for (var i=0; i<amount; i++){
        fill(i);
    }
}

function fill(i) {
    var array = [];
    var typeOfForm = document.forms[i].type.value;
    var k = 0;
    var pattern = /^\d+$/;
    var allElem = document.forms[i].elements;
    for (var j=0; j<document.forms[i].elements.length; j++){
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

        if(typeOfForm == 8){    //открытый тип
            if(allElem[j].name=='num' || (allElem[j].name=='choice')){
                array[k] = allElem[j].value;
                k++;
            }
        }
        if(typeOfForm == 9){    //три точки
            if(allElem[j].name=='num' || (allElem[j].name=='choice[]')){
                array[k] = allElem[j].value;
                k++;
            }
        }
        if(typeOfForm == 11){    //восстановить аналитический вид
            if(allElem[j].name=='num' || (allElem[j].name=='choice')){
                array[k] = allElem[j].value;
                k++;
            }
        }
        if(typeOfForm == 12){    // Turing
		    if(allElem[j].name=='num' || (allElem[j].name=='debug_counter') || (allElem[j].name=='task') ){
			    array[k] = allElem[j].value;
                k++;
			}
		}
        if(typeOfForm == 13){    // Markov
		    if(allElem[j].name=='num' || (allElem[j].name=='debug_counter') || (allElem[j].name=='task') ){
			    array[k] = allElem[j].value;
                k++;
			}
		}
        if(typeOfForm == 14){    // Post
		    if(allElem[j].name=='num' || (allElem[j].name=='debug_counter') || (allElem[j].name=='sequences_true') || (allElem[j].name=='sequences_all')){
			    array[k] = allElem[j].value;
                k++;
			}
		}
		if(typeOfForm == 15){    // RAM
		    if(allElem[j].name=='num' || (allElem[j].name=='debug_counter') || (allElem[j].name=='sequences_true') || (allElem[j].name=='sequences_all')){
			    array[k] = allElem[j].value;
                k++;
			}
		}
    }
    document.getElementById('super'+i).value=JSON.stringify(array);   //заполнили суперформу id и выбранными вариантами
}
