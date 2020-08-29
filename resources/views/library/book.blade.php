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
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <section>
                    <div class="section-header">
                        <ol class="breadcrumb">
                            <li>{!! HTML::linkRoute('library_index', 'Библиотека') !!}</li>
                            <li>{!! HTML::linkRoute('books', 'Бронирование печатных изданий') !!}</li>
                            <li class="active">Книга</li>
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

    <div class="card card-tiles style-default-light" style="margin-left:2%; margin-right:2%">
        <article class="style-default-bright">
            <div class="card-body">

                <article style="margin-left:10%; margin-right:10%; text-align: justify">

                    <table cellpadding="5" ><tbody>
                        <tr>
                            <td valign="top" colspan="1">
                                {!! HTML::image('img/library/'.$book->coverImg, '', array('style' => 'border:0px', 'width' => '200', 'height' => '300')) !!}
                                <br>
                            </td>
                            <td style="width:130px">
                                <p>&nbsp;</p>
                            </td>
                            <td style="text-align: left;" rowspan="2" colspan="1"><font size="4" style="font-weight: bold;">Название:&nbsp; <?php print $book->title ?></font>
                                <font size="3" >
                                    <?php
                                    print "
			<p>Автор:&nbsp;" .$book->author."</p>";
                                    print "
			<p>Тематика:&nbsp;" .$book->name."</p>";?>
                                </font>
                                <font size="2" style="font-style: italic;"><br></font><font size="2" style="color: rgb(102, 102, 102);">Издательство:</font>
                                <font size="2" style="font-style: italic; color: rgb(102, 102, 102);">
                                    <?php
                                    print "
			".$book->publisher."</p>";?>
                                </font>
                                <font size="2" style="color: rgb(102, 102, 102);">Формат:</font> <font size="2" style="font-style: italic;">
	  <span style="color: rgb(102, 102, 102);">
	  <?php
          print "
			".$book->format."</p>";?>
	  </span></font>
                                <font size="2" style="color: rgb(102, 102, 102);">

                                    @if($role == 'Студент' and $studentStatus == 0)
                                        {!! HTML::link('library/book/'.$book->id.'/order','Заказать книгу',array('class' => 'btn ink-reaction btn-primary btn-sm btn-block','role' => 'button')) !!}
                                    @endif
                                        @if(($role == 'Студент' and $studentStatus != 0 and $book->name != "Теория алгоритмов и сложности вычислений"
                                                and $book->name != "Дискретная математика") )
                                            {!! HTML::link('library/book/'.$book->id.'/order','Заказать книгу',array('class' => 'btn ink-reaction btn-primary btn-sm btn-block','role' => 'button')) !!}
                                        @endif
                                        @if(($role != 'Студент' and $role != 'Админ' and $book->name != "Теория алгоритмов и сложности вычислений"
                                        and $book->name != "Дискретная математика") )
                                            {!! HTML::link('library/book/'.$book->id.'/order','Заказать книгу',array('class' => 'btn ink-reaction btn-primary btn-sm btn-block','role' => 'button')) !!}
                                        @endif
                                    @if($role == 'Админ' )
                                    {!! HTML::link('library/book/'.$book->id.'/edit','Редактировать книгу',array('class' => 'btn ink-reaction btn-primary btn-sm','role' => 'button')) !!}
                                        <form action = "{{route('book_delete',['id' => $book->id])}}" method="post" onsubmit="return ConfirmDelete()">
                                            {{method_field('DELETE')}}
                                            {{ csrf_field() }}
                                            <div class="form-group">
                                                <button type="submit" class=" btn ink-reaction btn-warning btn-sm " style="margin-top: 10px; width: 164px">Удалить книгу</button>
                                            </div>
                                        </form>
                                    @endif
                            </td>


                        </tr>

                        </tbody>
                    </table>
                    <br></br>
                    <p><b>Аннотация</b></p>
                    <p><?php
                        print "
			<p>".$book->description."</p>";

                        ?></p>




                </article></article>	</div></div>

    <!-- BEGIN BLANK SECTION -->
    </div><!--end #content-->
    <!-- END CONTENT -->


@stop



<!-- BEGIN MENUBAR-->

<!-- END MAIN MENU -->


<!-- END BASE -->
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
