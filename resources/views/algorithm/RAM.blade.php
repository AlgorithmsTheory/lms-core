@extends('templates.base')
@section('head')
		<title>Эмулятор Random Access Machine</title>

		<!-- BEGIN META -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
		<meta name="keywords" content="your,keywords">
		<meta name="description" content="Short explanation about this website">
		<!-- END META -->

		<!-- BEGIN STYLESHEETS -->
		<!-- END STYLESHEETS -->
@stop
		
@section('content')
@include('algorithm.RAMview')
@stop		

@section('js-down')
		<!-- BEGIN JAVASCRIPT -->
        {!! HTML::script('js/ram/ace.js') !!}
        
        {!! HTML::script('js/ram/RAM.js') !!}
        
		{!! HTML::script('js/algorithms/symbols.js') !!}
		{!! HTML::script('js/algorithms/saving.js') !!}
		{!! HTML::script('js/algorithms/superScript.js') !!}
		{!! HTML::script('js/core/source/App.js') !!}
		{!! HTML::script('js/core/source/AppNavigation.js') !!}
		{!! HTML::script('js/core/source/AppOffcanvas.js') !!}
		{!! HTML::script('js/core/source/AppCard.js') !!}
		{!! HTML::script('js/core/source/AppForm.js') !!}
		{!! HTML::script('js/core/source/AppNavSearch.js') !!}
		{!! HTML::script('js/core/source/AppVendor.js') !!}
		{!! HTML::script('js/core/demo/Demo.js') !!}
		{!! HTML::script('js/core/demo/DemoUILists.js') !!}
		{!! HTML::script('js/algorithms/send.js') !!}
		{!! HTML::script('js/core/demo/DemoUIMessages.js') !!}

		<!-- END JAVASCRIPT -->
@stop
