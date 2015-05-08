<html>
<script type="text/javascript">
    <!--
       function fillSuper(){
           var array = [];
           var amount = document.getElementById('amount').value;
           for (var i=0; i<amount; i++){
               //alert ('i= '+i);
               var k = 0;
               var allElem = document.forms[i].elements;
               for (var j=0; j<document.forms[i].elements.length; j++){
                   //alert (allElem[j].name);
                   if(allElem[j].name=='num' || (allElem[j].name=='choice' && allElem[j].checked == true) || (allElem[j].name=='choice[]' && allElem[j].checked == true)) {
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
     // -->
</script>
<body>
<h1>Добро пожаловать в систему тестирования</h1>
<p>Всего в тесте оказалось {{ $amount }} вопросов</p>
<ul>
    @foreach($widgets as $widget)
    <li>{!! $widget !!}</li>
    @endforeach
</ul>
{!! Form::open(['method' => 'PATCH', 'route' => 'question_checktest', 'name' => 'super', 'onsubmit' => 'return sendForm();']) !!}
@for ($i = 0; $i < $amount; $i++)
<input id="super{{$i}}" type="hidden" name="{{$i}}" value="жопа">
@endfor
<input id="amount" type="hidden" name="amount" value="{{ $amount }}">
<input id="check" onClick="fillSuper()" type="submit" name="check" value="Отправить">
{!! Form::close() !!}
</body>
</html>