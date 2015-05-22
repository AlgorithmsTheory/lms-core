<html>
<head>
    <title>Тест</title>

    {!! HTML::style('css/test_style.css') !!}
    <script src="/public/js/jquery-1.11.3.js"></script>
    <script type="text/javascript">
    <!--
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
     // -->
</script>
</head>
<body>
<nav class="fixed-nav">
    <div class="menu wrapper">
        <ul>
            @for ($i=0; $i<$amount; $i++)
            <li class="NotAnswered" id="{{$i}}"><a href="#form{{$i+1}}" class="SmoothScroll"> {{$i+1}} </a></li>
           @endfor
        </ul>
    </div>
</nav>

<h1>Добро пожаловать в систему тестирования</h1>
<p>Всего в тесте оказалось {{ $amount }} вопросов</p>

    <?php $i=1;?>
    @foreach($widgets as $widget)
    <br id="form{{$i}}">
    <?php $i++;?>
    {!! $widget !!}
    @endforeach

{!! Form::open(['method' => 'PATCH', 'route' => 'question_checktest', 'class' => 'smart-blue', 'name' => 'super', 'onsubmit' => 'return sendForm();']) !!}
@for ($i = 0; $i < $amount; $i++)
<input id="super{{$i}}" type="hidden" name="{{$i}}" value="">
@endfor
<input id="amount" type="hidden" name="amount" value="{{ $amount }}">
<input type="hidden" name="id_test" value="{{ $id_test }}">
<input id="check" onClick="fillSuper()" class="smart-blue" type="submit" name="check" value="Отправить">
{!! Form::close() !!}

<script>
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
                elementToChange.className = "BeenSeen";
                //alert(index);
            }
            else{
                elementToChange = document.getElementById(index);
                elementToChange.className = "NotAnswered";
            }

        }

    });
</script>

</body>
</html>