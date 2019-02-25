@extends('templates.base')
@section('head')
    <title>Определения к экзамену</title>

    <!-- BEGIN META -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="your,keywords">
    <meta name="description" content="Short explanation about this website">
    <!-- END META -->

    <!-- BEGIN STYLESHEETS -->
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
    <div class ="row">
        <div class="col-sm-9" >
    <section>
        <div class="section-header">
            <ol class="breadcrumb">
                <li>{!! HTML::linkRoute('home', 'Главная') !!}</li>
                <li>{!! HTML::linkRoute('library_index', 'Библиотека') !!}</li>
                <li class="active">Определения к экзамену</li>
            </ol>
        </div>
    </section><!--end .section-header -->
        </div>
        <div class="col-sm-3" >
            @if($role == 'Админ')
                {!! HTML::link('library/definitions/create','Добавить определение',array('class' => 'btn ink-reaction btn-primary','role' => 'button')) !!}
            @endif
        </div>
    </div>

        <div class="card card-tiles style-default-light" style="margin-left:2%; margin-right:2%">
        <article class="style-default-bright">
            <div class="card-body">
                <article style="margin-left:10%; margin-right:10%">

                    <table class="table table-hover">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col"><h4>Термин</h4></th>
                            <th scope="col"><h4>Определение</h4></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($definitions as $definition)
                                <tr>
                                    <th scope="row"><h4>
                                            @if($definition->id_lecture == null)
                                                {{$definition->name}}
                                            @endif
                                            @if($definition->id_lecture != null)
                                                    {!! link_to_route('lecture', $definition->name, $definition->linkToLecture)!!}
                                            @endif
                                        </h4></th>
                                    <td>
                                        {{$definition->content}}
                                    </td>
                                    @if ($role == 'Админ')
                                        <td>

                                            <a type="button" class="btn btn-default btn-lg" href="definitions/{{$definition->id."/edit"}}">
                                                <span class="glyphicon glyphicon-pencil" style="color:orange;"></span>
                                            </a></td>
                                        <td>
                                            <button type="submit" class="btn btn-default btn-lg deleteDefinition" id="{{ $definition->id }}" name="delete{{ $definition->id }}" value="{{ csrf_token() }}" >
                                                <span class="glyphicon glyphicon-remove" style="color:red;"></span>
                                            </button>
                                        </td>
                                </tr>
                        @endif
                        @endforeach
                    </table>



                </article>
            </div>
        </article>
    </div>

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
    {!! HTML::script('js/library/definition.js') !!}
    <!-- END JAVASCRIPT -->
@stop

