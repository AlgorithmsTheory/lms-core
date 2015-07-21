<html>
<head>
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/font-awesome.min.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('cssmaterial-design-iconic-font.min.css') !!}
    {!! HTML::script('js/jquery.js') !!}
</head>
<body>
<h1 class="text-primary">Добро пожаловать в систему тестирования</h1>


<h2 class="text-primary">Создать новый вопрос</h2>

{!! Form::open(['method' => 'PATCH', 'route' => 'question_add', 'class' => 'form']) !!}

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
                <select name="section" id="select" class="form-control" size="1">
                    <option value="$nbsp"></option>
                    @foreach ($sections as $section)
                        <option value="{{$section}}">{{$section}}</option>/td>
                    @endforeach
                </select>
                <label for="select">Раздел</label>
            </div>

            <p>Тема</p>                                                                <!--обязательное поле-->
            <input type="text"  name="theme">

            <p>Тип</p>                                                                <!--обязательное поле-->
            <input type="text"  name="type">

            <p>Баллов за верный ответ</p>                                            <!--обязательное поле-->
            <input type="number" min="0" name="points">

            <input type="submit" value="Добавить" name="update">
{!! Form::close() !!}
        </div>
    </div>
</div>

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
        })

        $('#del-var').click(function(){
            if (count > 2){
                lastelem = $('#variants').children().last().remove();
                count--;
            }
            })
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