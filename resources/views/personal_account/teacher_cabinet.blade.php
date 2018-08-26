@extends('templates.base')
@section('head')
    <title>Личный кабинет</title>
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
            <div class="col-lg-6">
                <section>
                    <div class="section-header">
                        <ol class="breadcrumb">
                            <!--Надо будет изменить HTML::linkRoute('library_index', 'Библиотека')-->
                            <li>{!! HTML::linkRoute('library_index', 'Библиотека') !!}</li>
                            <li>{!! HTML::linkRoute('books', 'Бронирование печатных изданий') !!}</li>
                            <li class="active">Личный кабинет</li>
                        </ol>
                    </div><!--end .section-header -->
                    <div class="section-body">
                    </div><!--end .section-body -->
                </section>
            </div>
            <div class="col-lg-6">

                    {!! HTML::link('library/books/create','Добавить книгу',array('class' => 'btn ink-reaction btn-primary','role' => 'button')) !!}
                {!! HTML::link('library/books/manageNewsLibrary','Настройка новостей',array('class' => 'btn ink-reaction btn-primary','role' => 'button')) !!}
                    {!! HTML::link('#collapseExample','Настроить календарь ',array('class' => 'btn ink-reaction btn-primary','role' => 'button',
                    'data-toggle' => 'collapse', 'aria-expanded' => 'false', 'aria-controls' => 'collapseExample')) !!}
                    <div class="collapse" id="collapseExample">
                        <div class="card card-body">
                            {!! Form::open(array('route' => 'setDateCalendar', 'id' => 'formcheckbox')) !!}
                            <div class="form-group">
                                <h4> {!! Form::label('start_date', 'Первый день:') !!}</h4>
                                {!! Form::input('date','start_date',null,['class' => 'form-control', 'required' => 'required']) !!}
                            </div>
                            <div class="form-group">
                                <h4> {!! Form::label('end_date', 'Последний день:') !!}</h4>
                                {!! Form::input('date','end_date',null,['class' => 'form-control', 'required' => 'required']) !!}
                            </div>
                            <div class="form-group">
                                <h4>{!! Form::label('', 'Дни заказов:') !!}</h4>
                               <input type="checkbox" name="1Day" value="1"> Понедельник
                                <input type="checkbox" name="2Day" value="2"> Вторник
                                <input type="checkbox" name="3Day" value="3"> Среда
                                <input type="checkbox" name="4Day" value="4"> Четверг
                                <br>
                                <input type="checkbox" name="5Day" value="5"> Пятница
                                <input type="checkbox" name="6Day" value="6"> Суббота
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn ink-reaction btn-primary" id ="CalendarBatton">Отправить</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>

            </div>
        </div>
    </div>

    <div id="collapseParent">
        {{--Кнопки с collapse--}}
    <div class="row ">
        <div class="col-lg-8">
            <div class="row ">
                <div class="col-lg-2">
                    <button type="submit" class="btn ink-reaction btn-primary"  data-toggle="collapse" data-target="#collapseOrders "  id ="buttonOrder" data-parent="#collapseParent"
                            aria-expanded="false" aria-controls="collapseOrders">Заказы книг</button>
                </div>

                <div class="col-lg-3">
                    <div class="btn-group">
                        <button type="button" data-toggle="dropdown" class="btn ink-reaction btn-primary dropdown-toggle">Книги<span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#collapseIssureBook" data-toggle="collapse"  id ="buttonIssureBook" data-parent="#collapseParent"
                                   aria-expanded="false" aria-controls="collapseIssureBook">Выданные</a></li>
                            <li><a href="#collapseInLibraryBook" data-toggle="collapse" id ="buttonInLibraryBook" data-parent="#collapseParent"
                                   aria-expanded="false" aria-controls="collapseInLibraryBook">В наличии</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row " style="margin-top: 2%">
    </div>

        <div class="panel style-default-light">
    {{--таблица Заказы книг--}}
    <div class="collapse in" id="collapseOrders" aria-expanded="false">

            <article style="margin-left:2%;  text-align: justify; padd-top:2%;">
                <div class="row otstup">
                </div>
                <div class="row ">
                    <div class="col-lg-12">
                        <h4><strong>Заказы книг</strong></h4>
                    </div>
                </div>
                <table class="table table-hover tableOrder">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col"><select id ="studentOrder">
                                <option>Студент</option>
                                @foreach($nameOrders as $nameOrder)
                                    <option>{{$nameOrder}}</option>
                                @endforeach
                            </select>
                        </th>
                        <th scope="col"><select id ="groupOrder">
                                <option>Группа</option>
                                @foreach($groupOrders as $groupOrder)
                                    <option>{{$groupOrder}}</option>
                                @endforeach
                            </select>
                        </th>
                        <th scope="col" ><select id ="titleOrder" style="width:150px;">
                                <option>Название книги</option>
                                @foreach($titleOrders as $titleOrder)
                                    <option>{{$titleOrder}}</option>
                                @endforeach
                            </select>
                        </th>
                        <th scope="col"><select id ="authorOrder" style="width:150px;">
                                <option>Автор книги</option>
                                @foreach($authorOrders as $authorOrder)
                                    <option>{{$authorOrder}}</option>
                                @endforeach
                            </select>
                        </th>
                        <th scope="col"><select id ="genresOrder" style="width:90px;">
                                <option>Жанр книги</option>
                                @foreach($genresOrders as $genresOrder)
                                    <option>{{$genresOrder}}</option>
                                @endforeach
                            </select>
                        </th>
                        <th scope="col"><select id ="dateOrder">
                                <option>Дата заказа</option>
                                @foreach($dateOrders as $dateOrder)
                                    <option>{{$dateOrder}}</option>
                                @endforeach
                            </select></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $countBooks = 1   ?>
                    @foreach ($orders as $order)
                        @if($order->status == "delay")
                            <tr class="danger" >
                        @else
                            <tr >
                                @endif
                                <th scope="row"><?php echo "$countBooks"?></th>
                                <td id="student_order_id" class="{{$order->status}}">{{$order->first_name}} {{$order->last_name}}</td>

                                <td id="group_order_id">{{ $order->group_name }}</td>
                                <td id="title_order_id" style="width:150px;">{{ $order->title }}</td>
                                <td id="author_order_td" style="width:130px;">{{ $order->author }}</td>
                                <td id="genre_order_td" style="width:90px;">{{ $order->name }}</td>
                                <td id="date_return_order_td">{{ $order->date_order }}</td>
                                <td>{!! Form::open(['url' => '#', 'class' => 'form_issure', 'id' => $order->id, 'method' => 'POST']) !!}
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{$order->id}}" name="order_id">
                                    <input type="hidden" value="{{$order->id_user}}" name="user_id">
                                    <input type="hidden" value="{{$order->id_book}}" name="book_id">

                                    <div class="form-group">
                                        <button type="submit" class=" btn ink-reaction btn-primary issure_button" id ="issure{{$order->id}}">Выдать</button>
                                    </div>
                                    {!! Form::close() !!}
                                </td>
                                <td ><button type="submit" class="btn btn-warning cancel_order" id="{{ $order->id }}" value="{{ csrf_token() }}" >Отменить</button></td>
                                <td>{!! Form::open(['url' => '#', 'class' => 'form_extend', 'id' => 'extend'.$order->id]) !!}
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <!-- элемент input с id = datetimepicker1 -->
                                        <div class="input-group datetimepicker"  >
                                            <input type="text" class="form-control" name="date_extend" id="extend{{$order->id}}" placeholder="Введите дату" required/>

                                            <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                             </span>
                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control" name="id_book" value="{{$order->id_book}}" />
                                    <input type="hidden" class="form-control" name="id_user" value="{{$order->id_user}}" />
                                    <input type="hidden" class="form-control" name="id_order" value="{{$order->id}}" />
                                    <input type="hidden" class="form-control" name="date_order" value="{{$order->date_order}}" />
                                    <div class="form-group">
                                        <button type="submit" class="form-control btn ink-reaction btn-primary extend_button" id ="{{$order->id}}">Перенести</button>
                                    </div>
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                            @if($order->comment != '')
                            <tr class="info" id="comment{{$order->id}}">
                                <td colspan = "10"><b><i class="glyphicon glyphicon-comment"></i> Комментарий:  </b>{{$order->comment}}</td>

                            </tr>
                                @endif
                            <?php
                            $countBooks++  ?>
                            @endforeach
                    </tbody>
                </table>
            </article>

    </div>


    {{--Таблица Выданные Книги --}}
    <div class="collapse " id="collapseIssureBook" aria-expanded="false">

            <article style="margin-left:2%;  text-align: justify; padd-top:2%;">
                <div class="row otstup">
                </div>
                <div class="row ">
                    <div class="col-lg-12">
                        <h4><strong>Выданные Книги </strong></h4>
                    </div>
                </div>
                <table class="table table-hover tableIssureBook">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col"><select id ="studentIssureBook">
                                <option>Студент</option>
                                <option>Должники</option>
                            </select>
                        </th>
                        <th scope="col"><select id ="groupIssureBook">
                                <option>Группа</option>
                                @foreach($groupIssureBooks as $groupIssureBook)
                                    <option>{{$groupIssureBook}}</option>
                                @endforeach
                            </select>
                        </th>
                        <th scope="col"><select id ="titleIssureBook" style="width:150px;">
                                <option>Название книги</option>
                                @foreach($titleIssureBooks as $titleIssureBook)
                                    <option>{{$titleIssureBook}}</option>
                                @endforeach
                            </select>
                        </th>
                        <th scope="col"><select id ="authorIssureBook" style="width:150px;">
                                <option>Автор книги</option>
                                @foreach($authorIssureBooks as $authorIssureBook)
                                    <option>{{$authorIssureBook}}</option>
                                @endforeach
                            </select>
                        </th>
                        <th scope="col"><select id ="genresIssureBook" style="width:100px;">
                                <option>Жанр книги</option>
                                @foreach($genresIssureBooks as $genresIssureBook)
                                    <option>{{$genresIssureBook}}</option>
                                @endforeach
                            </select>
                        </th>
                        <th scope="col"><select id ="dateIssureBook" >
                                <option>Дата выдачи</option>
                                @foreach($dateIssureIssureBooks as $dateIssureIssureBook)
                                    <option>{{$dateIssureIssureBook}}</option>
                                @endforeach
                            </select></th>
                        <th scope="col"><select id ="dateReturnIssureBook" >
                                <option>Дата Возврата</option>
                                @foreach($dateReturnIssureBooks as $dateReturnIssureBook)
                                    <option>{{$dateReturnIssureBook}}</option>
                                @endforeach
                            </select></th>
                        <th scope="col"></th>
                        <th scope="col"></th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $countBooks = 1   ?>
                    @foreach ($issureBooks as $issureBook)
                        @if($issureBook->status == "delay")
                        <tr class="danger">
                            @else
                            <tr >
                            @endif
                            <th scope="row"><?php echo "$countBooks"?></th>
                            <td id="student_issure_book_id" class="{{$issureBook->status}}">{{ $issureBook->first_name }} {{$issureBook->last_name}}</td>
                            <td id="group_issure_book_id">{{ $issureBook->group_name }}</td>
                            <td id="title_issure_book_id">{{ $issureBook->title }}</td>
                            <td id="author_issure_book_td">{{ $issureBook->author }}</td>
                                <td id="genere_issure_book_td">{{ $issureBook->name }}</td>
                            <td id="date_issure_book_td">{{ $issureBook->date_issure }}</td>
                            <td id="date_return_issure_book_td">{{ $issureBook->date_return }}</td>
                            <td ><button type="submit" class="btn ink-reaction btn-primary  return_book" id="{{ $issureBook->id }}" value="{{ csrf_token() }}">Возврат книги</button></td>
                            @if($issureBook->status == "delay")
                            <td>{!! Form::open(['url' => '#', 'class' => 'form_remember', 'id' => 'remember'.$issureBook->id]) !!}
                                <input type="hidden" class="form-control" name="id_issureBook" value="{{$issureBook->id}}" />
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <button type="submit" class="btn-warning  btn ink-reaction btn-primary remember_button" id ="{{$issureBook->id}}">Напомнить</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                                @endif
                        </tr>
                        <?php
                        $countBooks++  ?>
                    @endforeach
                    </tbody>
                </table>
            </article>

    </div>


    {{--Таблица Книги в наличии--}}
    <div class="collapse " id="collapseInLibraryBook" aria-expanded="false">

            <article style="margin-left:2%;  text-align: justify; padd-top:2%;">
                <div class="row otstup">
                </div>
                <div class="row ">
                    <div class="col-lg-12">
                        <h4><strong>Книги в наличии </strong></h4>
                    </div>
                </div>
                <table class="table table-hover tableInLibrary">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col"><select id ="titleLibraryBook" style="width:150px;">
                                <option>Название книги</option>
                                @foreach($titleInLibraryBooks as $titleInLibraryBook)
                                    <option>{{$titleInLibraryBook}}</option>
                                @endforeach
                            </select>
                        </th>
                        <th scope="col"><select id ="authorLibraryBook" style="width:150px;">
                                <option>Автор книги</option>
                                @foreach($authorInLibraryBooks as $authorInLibraryBook)
                                    <option>{{$authorInLibraryBook}}</option>
                                @endforeach
                            </select>
                        </th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $countBooks = 1   ?>
                    @foreach ($inLibraryBooks as $inLibraryBook)
                        <tr >
                            <th scope="row"><?php echo "$countBooks"?></th>
                            <td id="title_library_id">{{ $inLibraryBook->title }}</td>
                            <td id="author_library_id">{{ $inLibraryBook->author }}</td>
                        </tr>
                        <?php
                        $countBooks++  ?>
                    @endforeach
                    </tbody>
                </table>
            </article>

    </div>
        </div>

</div>

    </div>
    <!--end #content-->

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
    {{--Календарь начало --}}
    {!! HTML::script('js/moment-with-locales.min.js') !!}
    {!! HTML::script('js/bootstrap-datetimepicker.min.js') !!}
    {{--Календарь конец --}}
    {!! HTML::script('js/library/teacherCabinet.js') !!}
    <script type="text/javascript">
        //Валидация формы изменения Календаря заказов
        $( document ).ready(function(){

            $('#formcheckbox').on('submit', function(event) {

                if ( validateForm() ) { // если есть ошибки возвращает true
                    alert(" Неправильно введенная дата");
                    event.preventDefault();
                }
                function validateForm() {
                    if ($('#start_date').val() >= $('#end_date').val()){
                        var v_date = true;
                    }
                    $("#end_date").toggleClass('error', v_date );
                    return (v_date);
                }
            });
            var checkboxes = $("input[type='checkbox']"),
                submitButt = $("#CalendarBatton");
            submitButt.attr("disabled", true);
            checkboxes.click(function() {
                submitButt.attr("disabled", !checkboxes.is(":checked"));
            });
        });

//пока пусть будет, потверждение удаления
        function ConfirmDelete()
        {
            var x = confirm("Удалить книгу?");
            if (x)
                return true;
            else
                return false;
        }

    </script>
    <!-- END JAVASCRIPT -->
@stop
