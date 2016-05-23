@extends('templates.base')
@section('head')
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <title>Редактировать план</title>
    {!! HTML::style('css/bootstrap.css') !!}
    {!! HTML::style('css/materialadmin.css') !!}
    {!! HTML::style('css/full.css') !!}
@stop

@section('background')
    full
@stop

@section('content')
    <div class="col-lg-offset-1 col-md-10 col-sm-6">
        <div class="card">
            <div class="card-body">


                <h2 class="text-center">План выполнения учебных мероприятий</h2>
                <br>
                <table class="table table-condensed table-bordered">
                    <tr class="active">
                        <td>КР №1 (Тьюринг)</td>
                        <td>КР №2 (Марков)</td>
                        <td>Тест 1(авт.)</td>
                        <td>Тест 1(письм.)</td>
                        <td>Раздел 1 завершен</td>
                        <td>Тест 2(авт.)</td>
                        <td>Тест 2(письм.)</td>
                        <td>Раздел 2 завершен</td>
                        <td>КР №3-рекурсии</td>
                        <td>КР №3-письм.</td>
                        <td>Тест 3(авт.)</td>
                        <td>Тест 3(письм.)</td>
                        <td>Раздел 3 завершен</td>
                        <td>Опрос</td>
                        <td>Раздел 4 завершен</td>
                    </tr>
                    <tbody id="target">
                        <tr>
                            <td>
                                <div class='checkbox checkbox-inline checkbox-styled'><label>
                                <input type="checkbox" value="{{ $plan['control1'] }}" id="control1" class="plan" {{ $plan['control1'] >= 1 ? 'checked' : '' }}>
                                <span></span></label></div>
                            </td>
                            <td>
                                <div class='checkbox checkbox-inline checkbox-styled'><label>
                                    <input type="checkbox" value="{{ $plan['control2'] }}" id="control2" class="plan" {{ $plan['control2'] >= 1 ? 'checked' : '' }}>
                                <span></span></label></div>
                            </td>
                            <td>
                                <div class='checkbox checkbox-inline checkbox-styled'><label>
                                    <input type="checkbox" value="{{ $plan['test1'] }}" id="test1" class="plan" {{ $plan['test1'] >= 1 ? 'checked' : '' }}>
                                <span></span></label></div>
                            </td>
                            <td>
                                <div class='checkbox checkbox-inline checkbox-styled'><label>
                                    <input type="checkbox" value="{{ $plan['test1quiz'] }}" id="test1quiz" class="plan" {{ $plan['test1quiz'] >= 1 ? 'checked' : '' }}>
                                <span></span></label></div>
                            </td>
                            <td>
                                <div class='checkbox checkbox-inline checkbox-styled'><label>
                                        <input type="checkbox" value="{{ $plan['section1'] }}" id="section1" class="plan" {{ $plan['section1'] >= 1 ? 'checked' : '' }}>
                                        <span></span></label></div>
                            </td>
                            <td>
                                <div class='checkbox checkbox-inline checkbox-styled'><label>
                                    <input type="checkbox" value="{{ $plan['test2'] }}" id="test2" class="plan" {{ $plan['test2'] >= 1 ? 'checked' : '' }}>
                                <span></span></label></div>
                            </td>
                            <td>
                                <div class='checkbox checkbox-inline checkbox-styled'><label>
                                    <input type="checkbox" value="{{ $plan['test2quiz'] }}" id="test2quiz" class="plan" {{ $plan['test2quiz'] >= 1 ? 'checked' : '' }}>
                                <span></span></label></div>
                            </td>
                            <td>
                                <div class='checkbox checkbox-inline checkbox-styled'><label>
                                        <input type="checkbox" value="{{ $plan['section2'] }}" id="section2" class="plan" {{ $plan['section2'] >= 1 ? 'checked' : '' }}>
                                        <span></span></label></div>
                            </td>
                            <td>
                                <div class='checkbox checkbox-inline checkbox-styled'><label>
                                    <input type="checkbox" value="{{ $plan['control3'] }}" id="control3" class="plan"{{ $plan['control3'] >= 1 ? 'checked' : '' }} >
                                <span></span></label></div>
                            </td>
                            <td>
                                <div class='checkbox checkbox-inline checkbox-styled'><label>
                                    <input type="checkbox" value="{{ $plan['control3quiz'] }}" id="control3quiz" class="plan" {{ $plan['control3quiz'] >= 1 ? 'checked' : '' }}>
                                <span></span></label></div>
                            </td>
                            <td>
                                <div class='checkbox checkbox-inline checkbox-styled'><label>
                                    <input type="checkbox" value="{{ $plan['test3'] }}" id="test3" class="plan" {{ $plan['test3'] >= 1 ? 'checked' : '' }}>
                                <span></span></label></div>
                            </td>
                            <td>
                                <div class='checkbox checkbox-inline checkbox-styled'><label>
                                    <input type="checkbox" value="{{ $plan['test3quiz'] }}" id="test3quiz" class="plan" {{ $plan['test3quiz'] >= 1 ? 'checked' : '' }}>
                                <span></span></label></div>
                            </td>
                            <td>
                                <div class='checkbox checkbox-inline checkbox-styled'><label>
                                        <input type="checkbox" value="{{ $plan['section3'] }}" id="section3" class="plan" {{ $plan['section3'] >= 1 ? 'checked' : '' }}>
                                        <span></span></label></div>
                            </td>
                            <td>
                                <div class='checkbox checkbox-inline checkbox-styled'><label>
                                    <input type="checkbox" value="{{ $plan['lastquiz'] }}" id="lastquiz" class="plan" {{ $plan['lastquiz'] >= 1 ? 'checked' : '' }}>
                                <span></span></label></div>
                            </td>
                            <td>
                                <div class='checkbox checkbox-inline checkbox-styled'><label>
                                        <input type="checkbox" value="{{ $plan['section4'] }}" id="section4" class="plan" {{ $plan['section4'] >= 1 ? 'checked' : '' }}>
                                        <span></span></label></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    {!! HTML::script('js/personal_account/manage_plan.js') !!}

@stop