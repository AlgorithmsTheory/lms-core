@extends('templates.base')
@section('head')
    <title>Бронирование печатных изданий</title>
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

@stop

@section('content')

    <!-- BEGIN BLANK SECTION -->
    <div class="container-fluid">

        @if($messageFlag == "YES")
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <p>Есть вовремя не сданные книги</p>
            </div>

        @endif

        <div class="row">
            <div class="col-lg-6">
    <section>
        <div class="section-header">
            <ol class="breadcrumb">
            <!--Надо будет изменить HTML::linkRoute('library_index', 'Библиотека')-->
                <li>{!! HTML::linkRoute('library_index', 'Библиотека') !!}</li>

                <?php if ($searchquery == ""){
                    echo '<li class="active">Бронирование печатных изданий</li>';
                }else{
                    echo '<li><a href="';
                    echo URL::route('books');
                    echo '">Бронирование печатных изданий</a></li>';
                    echo '<li class="active">Поиск печатных изданий</li>';
                }?>
            </ol>
        </div><!--end .section-header -->
        <div class="section-body">
        </div><!--end .section-body -->
    </section>
            </div>



            <div class="col-lg-6">
                @if($role == 'Админ')
                    {!! HTML::link('library/books/create','Добавить книгу',array('class' => 'btn ink-reaction btn-primary','role' => 'button')) !!}
                    {!! HTML::link('library/books/manageNewsLibrary','Настройка новостей',array('class' => 'btn ink-reaction btn-primary','role' => 'button')) !!}
                    {!! HTML::link('library/books/teacherCabinet','Личный кабинет',array('class' => 'btn ink-reaction btn-primary','role' => 'button')) !!}
                @endif
                @if($role != 'Админ')
                        {!! HTML::link('library/books/studentCabinet','Личный кабинет',array('class' => 'btn ink-reaction btn-primary','role' => 'button')) !!}
                        {!! HTML::link('library/books/manageNewsLibrary','Просмотр новостей',array('class' => 'btn ink-reaction btn-primary','role' => 'button')) !!}
                    @endif
            </div>
        </div>
    </div>


    <div class="card card-tiles style-default-light">
        <article style="margin-left:10%; margin-right:13%; text-align: justify">
            <br>
            <center>
                <form class="form" action="{{URL::route('library_search')}}"  method="post">
                    <input type="text"  name="search" id="text-to-find" size="50px" value="<?php echo $searchquery?>" placeholder="Введите название книги или имя автора" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <button type="submit" class="btn ink-reaction btn-primary"> Искать</button></form>
                <!--<input type="button" onclick="javascript: FindOnPage('text-to-find'); " value="Искать" target="_blank"/> -->
            </center>
            <center>
                <br>

                    <?php
                         $countBook = 0   ?>
                <div class="container">
                @if(count($books)%2 != 0)
                    @while($countBook < (count($books) -1))
                            <div class="row">
                                @include('library.books.book',array('book' => $books[$countBook]))
                                @include('library.books.book',array('book' => $books[++$countBook]))
                            </div>
                        <br>
                            <br>
                        <?php $countBook++?>
                    @endwhile
                        <div class="row">
                    @include('library.books.book',array('book' => $books[$countBook]))
                        </div>
                @else
                        @while($countBook < (count($books)))
                            <div class="row">
                                @include('library.books.book',array('book' => $books[$countBook]))
                                @include('library.books.book',array('book' => $books[++$countBook]))
                            </div>
                            <br>
                            <br>
                            <?php $countBook++?>
                        @endwhile
                @endif
                </div>
                <p>&nbsp;</p>
            </center>
        </article>

    </div>
    </div><!--end #content-->

    <div class="offcanvas">

    </div><!--end .offcanvas-->

    </div><!--end #base-->




@stop

@section('js-down')
    {!! HTML::script('js/core/source/App.js') !!}
    {!! HTML::script('js/core/source/AppNavigation.js') !!}
    {!! HTML::script('js/core/source/AppOffcanvas.js') !!}
    {!! HTML::script('js/core/source/AppCard.js') !!}
    {!! HTML::script('js/core/source/AppForm.js') !!}
    {!! HTML::script('js/core/source/AppNavSearch.js') !!}
    {!! HTML::script('js/core/source/AppVendor.js') !!}
    {!! HTML::script('js/core/demo/Demo.js') !!}

    <script type="text/javascript">
        function ConfirmDelete()
        {

            var x = confirm("Удалить книгу?");
            if (x)
                return true;
            else
                return false;
        }
    </script>
@stop
