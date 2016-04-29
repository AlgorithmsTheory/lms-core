<html>
<head>
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/test_style.css') !!}
    {!! HTML::style('css/font-awesome.min.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/material-design-iconic-font.min.css') !!}
    {!! HTML::style('css/materialadmin_demo.css') !!}
    {!! HTML::script('js/jquery.js') !!}
</head>
<body>
<section>
    <div class="section-body">
        <div class="col-md-12 col-sm-6 card style-primary">
            <h1 class="text-default-bright">Создать новый вопрос</h1>
        </div>
        <form action="{{URL::route('question_add')}}" method="POST" class="form" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="q-type" value="">
            <div class="col-lg-offset-1 col-md-10 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <!-- Выбор типа вопроса -->
                        <div class="form-group">
                            <select name="type" id="select-type" class="form-control" size="1">
                                <option value="$nbsp"></option>
                                @foreach ($types as $type)
                                <option value="{{$type['type_name']}}">{{$type['type_name']}}</option>/td>
                                @endforeach
                            </select>
                            <label for="select-type">Тип</label>
                        </div>


                        <div id="type_question_add"></div>



                    {!! HTML::script('js/question_create/questionCreate.js') !!}
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