@extends('templates.base')
@section('head')
    <title>Персоналии</title>
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

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    {!! HTML::script('js/libs/utils/html5shiv.js') !!}
    {!! HTML::script('js/libs/utils/respond.min.js') !!}
    <![endif]-->
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
            <div class="col-lg-9">
    <section>
        <div class="section-header">
            <ol class="breadcrumb">
                <li>{!! HTML::linkRoute('home', 'Главная') !!}</li>
                <li>{!! HTML::linkRoute('library_index', 'Библиотека') !!}</li>
                <li class="active">Персоналии</li>

            </ol>
        </div><!--end .section-header -->
        <div class="section-body">
        </div><!--end .section-body -->
    </section>
            </div>



            <div class="col-lg-3">
                @if($role == 'Админ')
                    {!! HTML::link('library/persons/create','Добавить ',array('class' => 'btn ink-reaction btn-primary','role' => 'button')) !!}
                @endif
            </div>
        </div>
    </div>


    <div class="card card-tiles style-default-light">
        <article style="margin-left:10%; margin-right:13%; text-align: justify">
            <div class="card-body">
            <center>
                    <?php
                         $countPerson = 0   ?>
                <div class="container">
                @if(count($persons)%2 != 0)
                    @while($countPerson < (count($persons) -1))
                            <div class="row">
                                @include('library.persons.person.person',array('person' => $persons[$countPerson]))
                                @include('library.persons.person.person',array('person' => $persons[++$countPerson]))
                            </div>
                        <br>
                            <br>
                        <?php $countPerson++?>
                    @endwhile
                        <div class="row">
                    @include('library.persons.person.person',array('person' => $persons[$countPerson]))
                        </div>
                @else
                        @while($countPerson < (count($persons)))
                            <div class="row">
                                @include('library.persons.person.person',array('person' => $persons[$countPerson]))
                                @include('library.persons.person.person',array('person' => $persons[++$countPerson]))
                            </div>
                            <br>
                            <br>
                            <?php $countPerson++?>
                        @endwhile
                @endif
                </div>
                <p>&nbsp;</p>
            </center>
            </div>
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
    <!-- END JAVASCRIPT -->
@stop
