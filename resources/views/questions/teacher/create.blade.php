<html>
<head>
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/font-awesome.min.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/material-design-iconic-font.min.css') !!}
    {!! HTML::script('js/jquery.js') !!}
</head>
<body>
<h1 class="text-primary">Добро пожаловать в систему тестирования</h1>


<h2 class="text-primary">Создать новый вопрос</h2>

<form action="question_add" method="POST" class="form">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="col-lg-offset-1 col-md-10 col-sm-6">
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <textarea  name="title" id="textarea1" class="form-control" rows="3" placeholder=""></textarea>
                <label for="textarea1">Текст</label>
            </div>

            <div class="form-group">
                <textarea  name="answer" id="textarea2" class="form-control" rows="3" placeholder=""></textarea>
                <label for="textarea2">Ответ</label>
            </div>

            <div id="variants" class="col-md-10 col-sm-6">
                <div class="form-group">
                    <textarea  name="variants[]"  class="form-control textarea3" rows="1" placeholder=""></textarea>
                    <label for="textarea3">Вариант 1</label>
                </div>
                <div class="form-group">
                    <textarea  name="variants[]"  class="form-control textarea3" rows="1" placeholder=""></textarea>
                    <label for="textarea3">Вариант 2</label>
                </div>
                <div class="form-group">
                    <textarea  name="variants[]"  class="form-control textarea3" rows="1" placeholder=""></textarea>
                    <label for="textarea3">Вариант 3</label>
                </div>
                <div class="form-group">
                    <textarea  name="variants[]"  class="form-control textarea3" rows="1" placeholder=""></textarea>
                    <label for="textarea3">Вариант 4</label>
                </div>
            </div>
            <div class="col-md-2 col-sm-6">
                <button type="button" class="btn ink-reaction btn-floating-action btn-success" id="add-var"><b>+</b>   </button>
                <button type="button" class="btn ink-reaction btn-floating-action btn-danger" id="del-var"><b>-</b></button>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group">
                <select name="section" id="select-section" class="form-control" size="1">
                    <option value="$nbsp"></option>
                    @foreach ($sections as $section)
                        <option value="{{$section}}">{{$section}}</option>/td>
                    @endforeach
                </select>
                <label for="select-section">Раздел</label>
            </div>

            <div class="form-group" id="container">

            </div>

            <p>Тип</p>                                                                <!--обязательное поле-->
            <input type="text"  name="type">

            <p>Баллов за верный ответ</p>                                            <!--обязательное поле-->
            <input type="number" min="0" name="points">
            <select name="id" id="select-section" class="form-control" size="1">
            <input type="submit" value="Добавить" name="update">
        </div>
    </div>
</div>
</form>
<a id="updatejq" href="">  [updatejq ]  </a>
<script type="text/javascript">
    $(function(){
        var count = 5;

        $('#add-var').click(function(){
            $('#variants').append('\
            <div class="form-group">\
                <textarea  name="variants[]"  class="form-control textarea3" rows="1" placeholder=""></textarea>\
                <label for="textarea3">Вариант ' + count + '</label>\
            </div>\
            ');
            count++;
        });

        $('#del-var').click(function(){
            if (count > 2){
                lastelem = $('#variants').children().last().remove();
                count--;
            }
            });

        $('#select-section').change(function(){
            choice = $('#select-section option:selected').val();
            token = $('.form').children().eq(0).val();
                $.ajax({
                    cache: false,
                    type: 'POST',
                    url:   "{{URL::route('test')}}",
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');

                        if (token) {
                            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    data: { choice: choice, token: 'token' },
                    success: function(html){
                        $('#container').html(html);
                    }
                    /*success: function(data){
                        alert(data);
                    }*/
                });
                return false;
            });

        /*$("a#updatejq").click(function() {
            //No special header needed, form is serialized, token goes right through
            //no different than a regular laravel post.
            dataString = $(".form").serialize();
            alert('here');
            $.ajax({
                type: "POST",
                url:"{{URL::route('test')}}",  //Notice here you just echo out the route to controller method.
                data: dataString,
                //dataType: "json", //////////json not applicable at all here. Commented out.
                success: function() {
                    alert('updated');
                    //You could even have a modal popup
                    //here to notify an update.

                }
            });
            return false;
        });*/
    })
</script>
{!! HTML::script('js/libs/jquery/jquery-1.11.2.min.js') !!}
{!! HTML::script('js/libs/jquery/jquery-migrate-1.2.1.min.js') !!}
{!! HTML::script('js/libs/bootstrap/bootstrap.min.js') !!}
{!! HTML::script('js/libs/spin.js/spin.min.js') !!}
{!! HTML::script('js/libs/autosize/jquery.autosize.min.js') !!}
{!! HTML::script('js/libs/nanoscroller/jquery.nanoscroller.min.js') !!}
{!! HTML::script('js/core/source/App.js') !!}
{!! HTML::script('js/core/source/AppNavigation.js') !!}
{!! HTML::script('js/core/source/AppOffcanvas.js') !!}
{!! HTML::script('js/core/source/AppCard.js') !!}
{!! HTML::script('js/core/source/AppForm.js') !!}
{!! HTML::script('js/core/source/AppNavSearch.js') !!}
{!! HTML::script('js/core/source/AppVendor.js') !!}
{!! HTML::script('js/core/source/AppVendor.js') !!}
{!! HTML::script('js/core/demo/Demo.js') !!}
</body>
</html>