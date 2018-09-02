@extends('templates.base')
@section('head')
    <title>Заказ книги</title>
    <!-- BEGIN META -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="your,keywords">
    <meta name="description" content="Short explanation about this website">
    <!-- END META -->

    <!-- BEGIN STYLESHEETS -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/font-awesome.min.css') !!}
    {!! HTML::style('css/material-design-iconic-font.min.css') !!}
    <!-- END STYLESHEETS -->

    <!-- BEGIN STYLESHEETSFOR FOR CALENDAR -->
    {!! HTML::style('css/bootstrap-datetimepicker.min.css') !!}
    <!-- END STYLESHEETS FOR CALENDAR -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    {!! HTML::script('js/libs/utils/html5shiv.js') !!}
    {!! HTML::script('js/libs/utils/respond.min.js') !!}
    <![endif]-->


@stop

@section('content')

    <!-- BEGIN BLANK SECTION -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <section>
                    <div class="section-header">
                        <ol class="breadcrumb">
                            <!--Надо будет изменить HTML::linkRoute('library_index', 'Библиотека')-->
                            <li>{!! HTML::linkRoute('library_index', 'Библиотека') !!}</li>
                            <li>{!! HTML::linkRoute('books', 'Бронирование печатных изданий') !!}</li>
                            <li class="active">Заказ книги</li>
                        </ol>
                    </div><!--end .section-header -->
                    <div class="section-body">
                    </div><!--end .section-body -->
                </section>
            </div>
            <div class="col-lg-4">

                {!! HTML::link('library/books/studentCabinet','Личный кабинет',array('class' => 'btn ink-reaction btn-primary','role' => 'button')) !!}


            </div>
        </div>
    </div>

    <div class="card card-tiles style-default-light">
        <article style="margin-left:10%; margin-right:13%; text-align: justify">



            {!! Form::open(['url' => 'library/book/'.$book_id.'/order', 'id' => 'form_date']) !!}
            @if(($role == 'Студент' and $studentStatus != 0) or ($role != 'Студент' and $role != 'Админ'))
                <div class="form-group">
                    <h4> {!! Form::label('comment', 'Комментарий:') !!}</h4>
                    {!! Form::textarea('comment',null,['class' => 'form-control','placeholder' => 'Введите причину заказа книги', 'required']) !!}
                </div>
            @endif
            <div class="form-group">
                <!-- элемент input с id = datetimepicker1 -->
                <div class="input-group" id="datetimepicker" >
                    <input type="text" class="form-control" name="date_order" id="date_order" required/>
                    <span class="input-group-addon">
              <span class="glyphicon glyphicon-calendar"></span>
                </span>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="form-control btn ink-reaction btn-primary order_book_button">Заказать книгу</button>
            </div>
            {!! Form::close() !!}

        </article>

    </div>
    </div><!--end #content-->

    <div class="offcanvas">

    </div><!--end .offcanvas-->

    </div><!--end #base-->
@stop
@section('js-down')
    <!-- BEGIN JAVASCRIPT -->
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
    {!! HTML::script('js/core/demo/Demo.js') !!}
    {!! HTML::script('js/moment-with-locales.min.js') !!}
    {!! HTML::script('js/bootstrap-datetimepicker.min.js') !!}
    <script>

        $(function () {
            //Валидация календаря

            $('form').on('submit',function(event){
                var myDate = new Date();
                var input_date = $('#datetimepicker').data("DateTimePicker").date();
                if (input_date < myDate){
                    alert("Введенна не актуальная дата");
                    $(this).find('#date_order').attr('value','');
                    event.preventDefault();
                    return false;
                }

                if($('#comment').val().length > 500 || $('#comment').val().length < 30){
                    alert("Введённый комментарий должен быть от 30 до 500 символов");
                    event.preventDefault();
                    return false;
                }

            });


            $('#datetimepicker').datetimepicker({
                format: 'DD.MM.YYYY ',
                locale: 'ru',
                daysOfWeekDisabled:{!! $possible_date !!},
                disabledDates: {!! $order_date !!},
                minDate: {!! $minDay !!},
                maxDate: {!! $maxDay !!},
                useCurrent: false
            });
        });
    </script>
@stop
