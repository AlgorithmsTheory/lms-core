@extends('templates.base')
@section('head')
    <title>Эмулятор машины Маркова</title>

    <!-- BEGIN META -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="your,keywords">
    <meta name="description" content="Short explanation about this website">
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <!-- END META -->

    <!-- BEGIN STYLESHEETS -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
    {!! HTML::style('css/bootstrap.css?1422792965') !!}
    {!! HTML::style('css/materialadmin.css?1425466319') !!}
    {!! HTML::style('css/font-awesome.min.css?1422529194') !!}
    {!! HTML::style('css/material-design-iconic-font.min.css?1421434286') !!}
    {!! HTML::style('css/libs/jquery-ui/jquery-ui-theme.css?1423393666') !!}
    {!! HTML::style('css/libs/nestable/nestable.css?1423393667') !!}
    <!-- END STYLESHEETS -->
@stop

@section('content')
@include('algorithm.HAMview')
@stop

@section('js-down')
    {!! HTML::script('js/algorithms/superScript.js') !!}
    
    {!! HTML::script('js/algorithms/symbols.js') !!}
    {!! HTML::script('js/algorithms/saving.js') !!}
    {!! HTML::script('js/algorithms/send.js') !!}

    {!! HTML::script('js/core/source/App.js') !!}
    {!! HTML::script('js/core/source/AppNavigation.js') !!}
    {!! HTML::script('js/core/source/AppOffcanvas.js') !!}
    {!! HTML::script('js/core/source/AppCard.js') !!}
    {!! HTML::script('js/core/source/AppForm.js') !!}
    {!! HTML::script('js/core/source/AppNavSearch.js') !!}
    {!! HTML::script('js/core/source/AppVendor.js') !!}
    {!! HTML::script('js/core/demo/Demo.js') !!}
    {!! HTML::script('js/core/demo/DemoUILists.js') !!}
    {!! HTML::script('js/core/demo/DemoUIMessages.js') !!}
@stop
