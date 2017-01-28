function countDown(second,endMinute,endHour,endDay,endMonth,endYear) {
var now = new Date();
second = (arguments.length == 1) ? second + now.getSeconds() : second;
endYear =  typeof(endYear) != 'undefined' ?  endYear : now.getFullYear();            
endMonth = endMonth ? endMonth - 1 : now.getMonth();  //номер месяца начинается с 0   
endDay = typeof(endDay) != 'undefined' ? endDay :  now.getDate();    
endHour = typeof(endHour) != 'undefined' ?  endHour : now.getHours();
endMinute = typeof(endMinute) != 'undefined' ? endMinute : now.getMinutes();   
//добавляем секунду к конечной дате (таймер показывает время уже спустя 1с.) 
var endDate = new Date(endYear,endMonth,endDay,endHour,endMinute,second+1); 
var interval = setInterval(function() { //запускаем таймер с интервалом 1 секунду
    var time = endDate.getTime() - now.getTime();
    if (time < 0) {                      //если конечная дата меньше текущей
        clearInterval(interval);
        alert("Неверная дата!");            
    } else {            
        var days = Math.floor(time / 864e5);
        var hours = Math.floor(time / 36e5) % 24; 
        var minutes = Math.floor(time / 6e4) % 60;
        var seconds = Math.floor(time / 1e3) % 60;  
        var digit='<div style="width:50px;float:left;text-align:center">'+
        '<div style="font-family:Stencil;font-size:45px;">';
        var text='</div><div>'
        var end='</div></div><div style="float:left;font-size:45px;">:</div>'
        document.getElementById('mytimer').innerHTML = '<div>осталось: </div>'+digit+hours+text+'Часов'+end+
        digit+minutes+text+'Минут'+end+digit+seconds+text+'Секунд';
        if (!seconds && !minutes && !days && !hours) {              
            clearInterval(interval);
            alert("Время вышло!");
			document.getElementById("onerun").disabled = true;
			document.getElementById("onerun2").disabled = true;
			document.getElementById("send_one").disabled = true;
			 document.getElementById("send_two").disabled = true;
			 	             
        }           
    }
    now.setSeconds(now.getSeconds() + 1); //увеличиваем текущее время на 1 секунду
}, 1000);
}
countDown(5400); //устанавливаем таймер на 30 секунд      
