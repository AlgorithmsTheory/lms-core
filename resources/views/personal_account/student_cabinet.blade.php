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
            <div class="col-lg-8">
                <section>
                    <div class="section-header">
                        <ol class="breadcrumb">
                            <!--Надо будет изменить HTML::linkRoute('library_index', 'Библиотека')-->
                            <li>{!! HTML::linkRoute('library_index', 'Библиотека') !!}</li>
                            <li>{!! HTML::linkRoute('Kadyrov_books', 'Бронирование печатных изданий') !!}</li>
                            <li class="active">Личный кабинет</li>
                        </ol>
                    </div><!--end .section-header -->
                    <div class="section-body">
                    </div><!--end .section-body -->
                </section>
            </div>
            <div class="col-lg-4">



            </div>
        </div>
    </div>

    <div id="collapseParent">

    <div class="row ">
        <div class="col-lg-8">
            <div class="row ">
                <div class="col-lg-2">
                    <button type="submit" class="btn ink-reaction btn-primary"  data-toggle="collapse" data-target="#collapseOrders "  id ="buttonOrder"
                            data-parent="#collapseParent" aria-expanded="false" aria-controls="collapseOrders">Мои заказы</button>
                </div>

                <div class="col-lg-3">
                    <button type="submit" class="btn ink-reaction btn-primary"  data-toggle="collapse" data-target="#collapseMyBook" id ="buttonBooks"
                            data-parent="#collapseParent" aria-expanded="false" aria-controls="collapseMyBook">Книги на руках</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row " style="margin-top: 2%">
    </div>

        <div class="panel " style="background-color:#e5e6e6;">
    <div class="  collapse in" id="collapseOrders">
    <div class="card card-tiles style-default-light">
        <article style="margin-left:10%; margin-right:13%; text-align: justify; padd-top:2%;">
                <div class="row " style="margin-top: 2%">
                </div>
                <div class="row ">
                    <div class="col-lg-12">
                        <h4><strong>Мои заказы</strong></h4>
                    </div>
                </div>
                <table class="table table-hover tableMyOrder">
                    <thead>

                    <tr>
                        <th scope="col">#</th>
                        <th scope="col"><select id ="titleOrder" style="width:150px;">
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

                        <th scope="col"><select id ="dateOrder">
                                <option>Дата заказа</option>
                                @foreach($dateOrders as $dateOrder)
                                    <option>{{$dateOrder}}</option>
                                @endforeach


                            </select>
                        </th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $countOrders = 1;
                    $flagCancelOrder = 0;
                    ?>
                    @foreach ($orders as $order)
                        @if($order->status == "active")
                        <tr>
                            <th scope="row"><?php echo "$countOrders"?></th>
                            <td id="title_order_td">{{ $order->title }}</td>
                            <td id="author_order_td">{{ $order->author }}</td>
                            <td id="date_order_td">{{ $order->date_order }}</td>
                            <td ><button type="submit" class="btn btn-warning cancel_order" id="delete{{ $order->id }}" value="{{ csrf_token() }}" >Отменить заказ</button></td>
                        </tr>
                        <?php
                        $countOrders++;
                        ?>
                        @else
                            <?php $flagCancelOrder = 1;?>
                        @endif
                    @endforeach
                    </tbody>
                </table>

        </article>
    </div>
            {{--Отменённые заказы--}}
            @if($flagCancelOrder == 1)
            <div class="card card-tiles style-default-light">
                <article style="margin-left:10%; margin-right:13%; text-align: justify; padd-top:2%;">

                <div class="row ">
                    <div class="col-lg-12">
                        <h4><strong>Отменённые заказы</strong></h4>
                    </div>
                </div>
                <table class="table table-hover table_message">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Название книги</th>
                        <th scope="col">Автор книги</th>
                        <th scope="col">Датта заказа</th>
                        <th scope="col">Причина</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $countOrders = 1   ?>
                    @foreach ($orders as $order)
                        @if($order->status != "active")
                            <tr>
                                <th scope="row"><?php echo "$countOrders"?></th>
                                <td>{{ $order->title }}</td>
                                <td>{{ $order->author }}</td>
                                <td id="{{ $order->date_order }}">{{ $order->date_order }}</td>
                                <td> @if($order->status == "cancel")
                                         Заказ отменён преподавателем
                                         @endif
                                    @if($order->status == "extendT")
                                        Заказ перенесён преподавателем
                                    @endif
                                    @if($order->status == "extendS")
                                        Заказ продлён студентом
                                    @endif
                                </td>
                                <td><button type="submit" class="btn ink-reaction btn-primary  btn-link cancel_message" id="cancel{{ $order->id }}" value="{{ csrf_token() }}" style="color: red;" ><i class="glyphicon glyphicon-remove"></i></button></td>
                            </tr>
                            <?php
                            $countOrders++  ?>
                        @endif
                    @endforeach
                    </tbody>
                </table>


                </article>
            </div>
            @endif
        </div>
            {{--таблица Книги на руках--}}
    <div class="  collapse" id="collapseMyBook">
            <div class="card card-tiles style-default-light">
                <article style="margin-left:10%; margin-right:13%; text-align: justify; padd-top:2%;">
                <div class="row otstup">
                </div>
                <div class="row ">
                    <div class="col-lg-12">
                        <h4><strong>Книги на руках</strong></h4>
                    </div>
                </div>
                <table class="table table-hover tableMyBook">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col"><select id ="titleBook" style="width:150px;">
                                <option>Название книги</option>
                                @foreach($titleMyBooks as $titleMyBook)
                                    <option>{{$titleMyBook}}</option>
                                @endforeach
                            </select>
                        </th>
                        <th scope="col"><select id ="authorBook" style="width:150px;">
                                <option>Автор книги</option>
                                @foreach($authorMyBooks as $authorMyBook)
                                    <option>{{$authorMyBook}}</option>
                                @endforeach
                            </select>
                        </th>
                        <th scope="col"><select id ="dateIssureBook">
                                <option>Дата получения</option>
                                @foreach($dateIssureMyBooks as $dateIssureMyBook)
                                    <option>{{$dateIssureMyBook}}</option>
                                @endforeach
                            </select>
                        </th>
                        <th scope="col"><select id ="dateReturnBook">
                                <option>Дата возврата</option>
                                @foreach($dateReturnMyBooks as $dateReturnMyBook)
                                    <option>{{$dateReturnMyBook}}</option>
                                @endforeach
                            </select></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $countBooks = 1   ?>

                    @foreach ($books as $book)
                        @if($book->status == "delay")
                            <tr class="danger">
                                @else
                            <tr >
                                @endif
                                     <th scope="row"><?php echo "$countBooks"?></th>

                                <td id="title_book_id">{{ $book->title }}</td>
                                <td id="author_book_td">{{ $book->author }}</td>
                                <td id="date_issure_td">{{ $book->date_issure }}</td>
                                <td id="date_return_td">{{ $book->date_return }}</td>
                                <td>{!! Form::open(['url' => 'library/books/studentCabinet/'.$book->id.'/extendDate', 'class' => 'form_extend', 'id' => $book->id]) !!}
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <!-- элемент input с id = datetimepicker1 -->
                                        <div class="input-group datetimepicker"  >
                                            <input type="text" class="form-control" name="date_extend" id="date_extend" placeholder="Введите дату" required/>
                                            <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                             </span>
                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control" name="id_book" value="{{$book->id_book}}" />
                                    <input type="hidden" class="form-control" name="id_user" value="{{$book->id_user}}" />
                                    <div class="form-group">
                                        <button type="submit" class="form-control btn ink-reaction btn-primary extend_button" id ="{{$book->id}}">Продлить</button>
                                    </div>
                                    {!! Form::close() !!}
                                </td>

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
    {{--Календарь начало --}}
    {!! HTML::script('js/moment-with-locales.min.js') !!}
    {!! HTML::script('js/bootstrap-datetimepicker.min.js') !!}
    {{--Календарь конец --}}
    {!! HTML::script('js/library/studentCabinet.js') !!}
    <script type="text/javascript">


    </script>
    <!-- END JAVASCRIPT -->
@stop
